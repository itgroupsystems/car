<?php

namespace Drupal\car;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;
use Symfony\Component\Routing\Route;

/**
* Provides routes for Car entities.
*
* @see \Drupal\Core\Entity\Routing\AdminHtmlRouteProvider
* @see \Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider
*/
class CarHtmlRouteProvider extends AdminHtmlRouteProvider {

    /**
    * {@inheritdoc}
    */
    public function getRoutes(EntityTypeInterface $entity_type) {
        $collection = parent::getRoutes($entity_type);

        return $collection;
    }

    /**
    * Gets the settings form route.
    *
    * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
    *   The entity type.
    *
    * @return \Symfony\Component\Routing\Route|null
    *   The generated route, if available.
    */
    protected function getSettingsFormRoute(EntityTypeInterface $entity_type) {
        if (!$entity_type->getBundleEntityType()) {
            $route = new Route("/admin/structure/{$entity_type->id()}/settings");
            $route
            ->setDefaults([
                '_form' => 'Drupal\car\Form\CarSettingsForm',
                // '_title' => "{$entity_type->getLabel()} settings",
            ])
            ->setRequirement('_permission', $entity_type->getAdminPermission())
            ->setOption('_admin_route', TRUE);

            return $route;
        }
    }

}
