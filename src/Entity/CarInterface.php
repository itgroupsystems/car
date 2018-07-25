<?php

namespace Drupal\car\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
* Provides an interface for defining Car entities.
*
* @ingroup car
*/
interface CarInterface extends ContentEntityInterface, EntityChangedInterface {

    // Add get/set methods for your configuration properties here.

    /**
    * Gets the Car name.
    *
    * @return string
    *   Name of the Car.
    */
    public function getName();

    /**
    * Sets the Car name.
    *
    * @param string $name
    *   The Car name.
    *
    * @return \Drupal\car\Entity\CarInterface
    *   The called Car entity.
    */
    public function setName($name);

    /**
    * Gets the Car creation timestamp.
    *
    * @return int
    *   Creation timestamp of the Car.
    */
    public function getCreatedTime();

    /**
    * Sets the Car creation timestamp.
    *
    * @param int $timestamp
    *   The Car creation timestamp.
    *
    * @return \Drupal\car\Entity\CarInterface
    *   The called Car entity.
    */
    public function setCreatedTime($timestamp);

    /**
    * Returns the Car published status indicator.
    *
    * Unpublished Car are only visible to restricted users.
    *
    * @return bool
    *   TRUE if the Car is published.
    */
    public function isPublished();

    /**
    * Sets the published status of a Car.
    *
    * @param bool $published
    *   TRUE to set this Car to published, FALSE to set it to unpublished.
    *
    * @return \Drupal\car\Entity\CarInterface
    *   The called Car entity.
    */
    public function setPublished($published);

}
