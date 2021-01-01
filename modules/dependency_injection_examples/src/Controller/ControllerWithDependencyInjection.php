<?php

namespace Drupal\dependency_injection_examples\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\dependency_injection_examples\ServiceWithWiredServices;
use Drupal\dependency_injection_examples\SetterInjectionExample;
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
   * Service where other services were injected using setters.
   *
   * @var \Drupal\dependency_injection_examples\SetterInjectionExample
   */
  protected $setterInjectionExample;

  /**
   * {@inheritDoc}
   */
  static public function create(ContainerInterface $container) {
    return new static(
      $container->get('my_service_with_wired_services'),
      $container->get('my_service_with_setter_injection')
    );
  }

  /**
   * ControllerWithDependencyInjection constructor.
   *
   * @param \Drupal\dependency_injection_examples\ServiceWithWiredServices $service_with_wired_services
   * @param \Drupal\dependency_injection_examples\SetterInjectionExample $setter_injection_example
   */
  public function __construct(ServiceWithWiredServices $service_with_wired_services, SetterInjectionExample $setter_injection_example) {
    $this->serviceWithWiredServices = $service_with_wired_services;
    $this->setterInjectionExample = $setter_injection_example;
  }

  /**
   * Page output.
   */
  public function page() {
    $this->serviceWithWiredServices->messageServiceArgumentsAsMarkup();
    $this->setterInjectionExample->messageServiceArgumentsAsMarkup();

    return [
      '#markup' => $this->serviceWithWiredServices->getServiceArgumentsAsMarkup(),
    ];
  }

}
