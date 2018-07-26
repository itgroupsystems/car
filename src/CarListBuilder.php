<?php

namespace Drupal\car;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
* Defines a class to build a listing of Car entities.
*
* @ingroup car
*/
class CarListBuilder extends EntityListBuilder {


    /**
    * {@inheritdoc}
    */
    public function buildHeader() {
        $header['id'] = $this->t('Car ID');
        $header['registration_number'] = $this->t('Registration number');
        $header['color'] = $this->t('Color');
        $header['km'] = $this->t('Kilometers');
        $header['owner'] = $this->t('Owner');
        return $header + parent::buildHeader();
    }

    /**
    * {@inheritdoc}
    */
    public function buildRow(EntityInterface $entity) {
        /* @var $entity \Drupal\car\Entity\Car */
        $row['id'] = $entity->id();
        $row['registration_number'] = Link::createFromRoute(
            $entity->registration_number->value,
            'entity.car.edit_form',
            ['car' => $entity->id()]
        );
        $row['color'] = $this->t($entity->color->value);
        $row['kilometers'] = $entity->km->value;
        $row['owner'] = $entity->owner->value;
        return $row + parent::buildRow($entity);
    }

}
