<?php

namespace Drupal\example_entity\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\example_entity\Entity\OrganisationInterface;

/**
 * Class OrganisationController.
 *
 *  Returns responses for Organisation routes.
 *
 * @package Drupal\example_entity\Controller
 */
class OrganisationController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Organisation  revision.
   *
   * @param int $organisation_revision
   *   The Organisation  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($organisation_revision) {
    $organisation = $this->entityManager()->getStorage('organisation')->loadRevision($organisation_revision);
    $view_builder = $this->entityManager()->getViewBuilder('organisation');

    return $view_builder->view($organisation);
  }

  /**
   * Page title callback for a Organisation  revision.
   *
   * @param int $organisation_revision
   *   The Organisation  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($organisation_revision) {
    $organisation = $this->entityManager()->getStorage('organisation')->loadRevision($organisation_revision);
    return $this->t('Revision of %title from %date', array('%title' => $organisation->label(), '%date' => format_date($organisation->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a Organisation .
   *
   * @param \Drupal\example_entity\Entity\OrganisationInterface $organisation
   *   A Organisation  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(OrganisationInterface $organisation) {
    $account = $this->currentUser();
    $langcode = $organisation->language()->getId();
    $langname = $organisation->language()->getName();
    $languages = $organisation->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $organisation_storage = $this->entityManager()->getStorage('organisation');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $organisation->label()]) : $this->t('Revisions for %title', ['%title' => $organisation->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all organisation revisions") || $account->hasPermission('administer organisation entities')));
    $delete_permission = (($account->hasPermission("delete all organisation revisions") || $account->hasPermission('administer organisation entities')));

    $rows = array();

    $vids = $organisation_storage->revisionIds($organisation);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\example_entity\OrganisationInterface $revision */
      $revision = $organisation_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $organisation->getRevisionId()) {
          $link = $this->l($date, new Url('entity.organisation.revision', ['organisation' => $organisation->id(), 'organisation_revision' => $vid]));
        }
        else {
          $link = $organisation->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->revision_log_message->value, '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.organisation.translation_revert', ['organisation' => $organisation->id(), 'organisation_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.organisation.revision_revert', ['organisation' => $organisation->id(), 'organisation_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.organisation.revision_delete', ['organisation' => $organisation->id(), 'organisation_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['organisation_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
