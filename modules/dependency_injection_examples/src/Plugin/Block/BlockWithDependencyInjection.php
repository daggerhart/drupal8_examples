<?php

namespace Drupal\dependency_injection_examples\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\dependency_injection_examples\ServiceWithWiredServices;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a very simple block that displays some text.
 *
 * @Block(
 *   id = "block_with_dependency_injection",
 *   admin_label = @Translation("Block With Dependency Injection")
 * )
 */
class BlockWithDependencyInjection extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * My wired service.
   *
   * @var \Drupal\dependency_injection_examples\ServiceWithWiredServices
   */
  protected $serviceWithWiredServices;

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('my_service_with_wired_services')
    );
  }

  /**
   * BlockWithDependencyInjection constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\dependency_injection_examples\ServiceWithWiredServices $service_with_wired_services
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ServiceWithWiredServices $service_with_wired_services) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->serviceWithWiredServices = $service_with_wired_services;
  }

  /**
   * {@inheritDoc}
   */
  public function build() {
    return [
      '#markup' => $this->serviceWithWiredServices->getServiceArgumentsAsMarkup(),
    ];
  }

}
