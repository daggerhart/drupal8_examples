<?php

namespace Drupal\cat_api\Service;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Http\ClientFactory;

/**
 * Class CatApiClientFactory.
 *
 * @package Drupal\cat_api\Service
 */
class CatApiClientFactory {

  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  private $configFactory;

  /**
   * Guzzle client factory.
   *
   * @var \Drupal\Core\Http\ClientFactory
   */
  private $httpClientFactory;

  /**
   * Json serializer.
   *
   * @var \Drupal\Component\Serialization\Json
   */
  private $json;

  /**
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   * @param \Drupal\Core\Http\ClientFactory $http_client_factory
   * @param \Drupal\Component\Serialization\Json $json
   */
  public function __construct(ConfigFactoryInterface $config_factory, ClientFactory $http_client_factory, Json $json) {
    $this->configFactory = $config_factory;
    $this->httpClientFactory = $http_client_factory;
    $this->json = $json;
  }

  /**
   * Create a new fully prepared instance of CatApiClient.
   *
   * @return \Drupal\cat_api\Service\CatApiClient
   */
  public function create() {
    $config = $this->configFactory->get('cat_api.settings');
    $http_client = $this->httpClientFactory->fromOptions([
      'verify' => FALSE,
      'base_uri' => $config->get('base_uri'),
      'headers' => [
        'x-api-key' => $config->get('api_key'),
        'Content-Type' => 'application/json',
      ],
    ]);

    return new CatApiClient($http_client, $this->json);
  }

}
