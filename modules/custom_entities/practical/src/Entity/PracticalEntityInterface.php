<?php

namespace Drupal\practical\Entity;

use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Practical entity entities.
 *
 * @ingroup practical
 */
interface PracticalEntityInterface extends EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Practical entity name.
   *
   * @return string
   *   Name of the Practical entity.
   */
  public function getName();

  /**
   * Sets the Practical entity name.
   *
   * @param string $name
   *   The Practical entity name.
   *
   * @return \Drupal\practical\Entity\PracticalEntityInterface
   *   The called Practical entity entity.
   */
  public function setName($name);

  /**
   * Gets the Practical entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Practical entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Practical entity creation timestamp.
   *
   * @param int $timestamp
   *   The Practical entity creation timestamp.
   *
   * @return \Drupal\practical\Entity\PracticalEntityInterface
   *   The called Practical entity entity.
   */
  public function setCreatedTime($timestamp);
}
