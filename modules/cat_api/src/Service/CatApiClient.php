<?php

namespace Drupal\cat_api\Service;

use Drupal\Component\Serialization\Json;
use GuzzleHttp\Client;

/**
 * Class CatApiClient
 *
 * @package Drupal\cat_api\Service
 */
class CatApiClient implements CatApiClientInterface {

  /**
   * Prepared instance of http client.
   *
   * @var \GuzzleHttp\Client
   */
  private $httpClient;

  /**
   * Json serializer.
   *
   * @var \Drupal\Component\Serialization\Json
   */
  private $json;

  /**
   * CatApiClient constructor.
   *
   * @param \GuzzleHttp\Client $http_client
   * @param \Drupal\Component\Serialization\Json $json
   */
  public function __construct(Client $http_client, Json $json) {
    $this->httpClient = $http_client;
    $this->json = $json;
  }

  /**
   * {@inheritDoc}
   */
  public function get(string $endpoint, array $query = []): array {
    $response = $this->httpClient->get($endpoint, [
      'query' => $query,
    ]);

    if ($response->getStatusCode() === 200) {
      return $this->json::decode($response->getBody()->getContents());
    }

    return [];
  }

}
