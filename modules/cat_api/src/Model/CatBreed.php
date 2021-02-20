<?php

namespace Drupal\cat_api\Model;

use Drupal\Core\Render\Markup;

/**
 * Class CatBreed.
 *
 * @package Drupal\cat_api\Model
 */
class CatBreed implements CatBreedInterface {

  /**
   * @var string
   */
  private $id;

  /**
   * @var string
   */
  private $name;

  /**
   * @var string
   */
  private $description;

  /**
   * @var string
   */
  private $temperament;

  /**
   * @var string
   */
  private $imageUrl;

  /**
   * CatBreed constructor.
   *
   * @param string $id
   *   Breed id.
   * @param string $name
   *   Breed name.
   * @param string $desc
   *   Breed description.
   * @param string $temp
   *   Breed temperament.
   * @param string $image_url
   *   Breed image url.
   */
  public function __construct(string $id, string $name, string $desc, string $temp, string $image_url) {
    $this->id = $id;
    $this->name = $name;
    $this->description = $desc;
    $this->temperament = $temp;
    $this->imageUrl = $image_url;
  }

  /**
   * {@inheritDoc}
   */
  public function getId(): string {
    return $this->id;
  }

  /**
   * {@inheritDoc}
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * {@inheritDoc}
   */
  public function getDescription(): string {
    return $this->description;
  }

  /**
   * {@inheritDoc}
   */
  public function getTemperament(): string {
    return $this->temperament;
  }

  /**
   * {@inheritDoc}
   */
  public function getPicture() {
    return Markup::create("<img src='{$this->imageUrl}' alt='{$this->name} picture'>");
  }

}
