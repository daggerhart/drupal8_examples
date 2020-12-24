<?php

namespace Drupal\dependency_injection_examples\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\dependency_injection_examples\ServiceWithWiredServices;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ControllerWithDependencyInjection.
 *
 * @package Drupal\dependency_injection_examples\Controller
 */
class ControllerWithDependencyInjection implements ContainerInjectionInterface {

  /**
   * My wired service.
   *
   * @var \Drupal\dependency_injection_examples\ServiceWithWiredServices
   */
  protected $serviceWithWiredServices;

  /**
   * {@inheritDoc}
   */
  static public function create(ContainerInterface $container) {
    return new static(
      $container->get('my_service_with_wired_services')
    );
  }

  /**
   * ControllerWithDependencyInjection constructor.
   *
   * @param \Drupal\dependency_injection_examples\ServiceWithWiredServices $service_with_wired_services
   */
  public function __construct(ServiceWithWiredServices $service_with_wired_services) {
    $this->serviceWithWiredServices = $service_with_wired_services;
  }

  /**
   * Page output.
   */
  public function page() {
    $this->serviceWithWiredServices->messageServiceArgumentsAsMarkup();

    return [
      '#markup' => $this->serviceWithWiredServices->getServiceArgumentsAsMarkup(),
    ];
  }

}
