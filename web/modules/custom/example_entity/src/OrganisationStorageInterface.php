<?php

namespace Drupal\example_entity;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\example_entity\Entity\OrganisationInterface;

/**
 * Defines the storage handler class for Organisation entities.
 *
 * This extends the base storage class, adding required special handling for
 * Organisation entities.
 *
 * @ingroup example_entity
 */
interface OrganisationStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Organisation revision IDs for a specific Organisation.
   *
   * @param \Drupal\example_entity\Entity\OrganisationInterface $entity
   *   The Organisation entity.
   *
   * @return int[]
   *   Organisation revision IDs (in ascending order).
   */
  public function revisionIds(OrganisationInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Organisation author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Organisation revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\example_entity\Entity\OrganisationInterface $entity
   *   The Organisation entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(OrganisationInterface $entity);

  /**
   * Unsets the language for all Organisation with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
