<?php

namespace Drupal\example_entity;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\node\Entity\Node;

/**
 * Access controller for the Organisation entity.
 *
 * @see \Drupal\example_entity\Entity\Organisation.
 */
class OrganisationAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\example_entity\Entity\OrganisationInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished organisation entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published organisation entities');

      case 'update':
        
        
        /** @var Node $about */
//        $about = $entity->about->entity;
//
//        $id = $about->getOwner()->id();
//        return AccessResult::allowedIf($id == $account->id());
        return AccessResult::allowedIfHasPermission($account, 'edit organisation entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete organisation entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add organisation entities');
  }

}
