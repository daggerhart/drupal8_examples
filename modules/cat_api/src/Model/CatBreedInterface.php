<?php

namespace Drupal\cat_api\Model;

/**
 * Interface CatBreedInterface.
 *
 * @package Drupal\cat_api\Model
 */
interface CatBreedInterface {

  /**
   * Get cat breed id.
   *
   * @return string
   */
  public function getId(): string;

  /**
   * Get the breed name.
   *
   * @return string
   */
  public function getName(): string;

  /**
   * Get the breed description.
   *
   * @return string
   */
  public function getDescription(): string;

  /**
   * Get the breed's temperament.
   *
   * @return string
   */
  public function getTemperament(): string;

  /**
   * Get a markup object for the cat breed image.
   *
   * @return \Drupal\Component\Render\MarkupInterface|string
   */
  public function getPicture();

}
