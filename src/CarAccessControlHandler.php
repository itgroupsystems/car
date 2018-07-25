<?php

namespace Drupal\car;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
* Access controller for the Car entity.
*
* @see \Drupal\car\Entity\Car.
*/
class CarAccessControlHandler extends EntityAccessControlHandler {

    /**
    * {@inheritdoc}
    */
    protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
        /** @var \Drupal\car\Entity\CarInterface $entity */
        switch ($operation) {
            case 'view':
            if (!$entity->isPublished()) {
                return AccessResult::allowedIfHasPermission($account, 'view unpublished car entities');
            }
            return AccessResult::allowedIfHasPermission($account, 'view published car entities');

            case 'update':
            return AccessResult::allowedIfHasPermission($account, 'edit car entities');

            case 'delete':
            return AccessResult::allowedIfHasPermission($account, 'delete car entities');
        }

        // Unknown operation, no opinion.
        return AccessResult::neutral();
    }

    /**
    * {@inheritdoc}
    */
    protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
        return AccessResult::allowedIfHasPermission($account, 'add car entities');
    }

}
