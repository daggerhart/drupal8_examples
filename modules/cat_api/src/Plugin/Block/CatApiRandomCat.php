<?php

namespace Drupal\cat_api\Plugin\Block;

use Drupal\cat_api\Service\CatApiClientInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\Markup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block that displays a random cat picture.
 *
 * This block demonstrates Dependency Injection in a Drupal plugin.
 *
 * @Block(
 *   id = "cat_api_random_cat",
 *   admin_label = @Translation("Cat API - Random Cat")
 * )
 */
class CatApiRandomCat extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Cat API Client.
   *
   * @var \Drupal\cat_api\Service\CatApiClientInterface
   */
  private $catApiClient;

  /**
   * CatApiRandomCat constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\cat_api\Service\CatApiClientInterface $cat_api_client
   *   Cat API Client.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CatApiClientInterface $cat_api_client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->catApiClient = $cat_api_client;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('cat_api.client')
    );
  }

  /**
   * {@inheritDoc}
   */
  public function build() {
    $results = $this->catApiClient->get('images/search', [
      'limit' => 1,
    ]);

    return [
      'image' => [
        '#markup' => Markup::create("<img src='{$results[0]['url']}' alt='{$results[0]['id']}'>")
      ],
    ];
  }

}
