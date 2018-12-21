<?php

namespace Drupal\mon_module;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

class UpKeepRobotAccessControlHandler extends EntityAccessControlHandler
{
    /**
     * @see \Drupal\comment\Entity\Comment.
     *
     * @param EntityInterface $entity
     * @param string $operation
     * @param AccountInterface $account
     * @return AccessResult|\Drupal\Core\Access\AccessResultAllowed|\Drupal\Core\Access\AccessResultInterface
     */
    protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account)
    {
        switch ($operation) {
            case 'view':
                return AccessResult::allowedIfHasPermission($account, 'view robot entity');

            case 'edit':
                return AccessResult::allowedIfHasPermission($account, 'edit robot entity');

            case 'delete':
                return AccessResult::allowedIfHasPermission($account, 'delete robot entity');
        }
        return AccessResult::allowed();
    }

    protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL)
    {
        return AccessResult::allowedIfHasPermission($account, 'add robot entity');
    }
}