<?php

namespace Drupal\cat_api\Service;

use Drupal\cat_api\Model\CatBreed;

/**
 * Class CatBreedFactory.
 *
 * @package Drupal\cat_api\Service
 */
class CatBreedFactory {

  /**
   * Create instance of CatBreed from the results of the CatApiClient.
   *
   * @param array $results
   *   Result array from an CatApiClient request.
   *
   * @return \Drupal\cat_api\Model\CatBreed
   */
  public function createFromSearchResult(array $results) {
    $breed = $results['breeds'][0];

    return new CatBreed(
      $breed['id'],
      $breed['name'],
      $breed['description'],
      $breed['temperament'],
      $results['url'] ?? ''
    );
  }

  /**
   * Create instance of CatBreed from the results of the CatApiClient.
   *
   * @param array $breed
   *   Result array from an CatApiClient request.
   *
   * @return \Drupal\cat_api\Model\CatBreed
   */
  public function createFromBreedResult(array $breed) {
    return new CatBreed(
      $breed['id'],
      $breed['name'],
      $breed['description'],
      $breed['temperament'],
      $breed['image']['url'] ?? ''
    );
  }

}
