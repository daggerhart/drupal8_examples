<?php

namespace Drupal\cat_api\Service;

/**
 * Interface CatApiClientInterface.
 *
 * @package Drupal\cat_api\Service
 */
interface CatApiClientInterface {

  /**
   * Retrieve data from the cat api.
   *
   * @param string $endpoint
   * @param array $query
   *
   * @return array
   */
  public function get(string $endpoint, array $query = []): array;

}
