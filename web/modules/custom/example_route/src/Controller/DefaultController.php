<?php

namespace Drupal\example_route\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DefaultController.
 *
 * @package Drupal\example_route\Controller
 */
class DefaultController extends ControllerBase {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   */
  public function __construct(AccountProxy $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user')
    );
  }

  /**
   * Page.
   *
   * @return string
   *   Return Hello string.
   */
  public function page($name) {

    $config = \Drupal::config('example_route.settings')->get('test');

    $structure = [
      'example' => $config
    ];

    \Drupal::moduleHandler()->alter('example_route_my_page', $structure);
    

    return new JsonResponse($structure);
  }

  /**
   * Page.
   *
   * @return string
   *   Return Hello string.
   */
  public function page2(Node $node) {
    return new JsonResponse([
      'title' => $node->label(),
    ]);

  }

}
