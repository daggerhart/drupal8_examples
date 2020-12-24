<?php

namespace Drupal\dependency_injection_examples;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;

/**
 * Class ServiceWithWiredServices.
 *
 * @package Drupal\dependency_injection_examples
 */
class ServiceWithWiredServices {

  /**
   * Custom service for creating markup.
   *
   * @var \Drupal\dependency_injection_examples\AwesomeMarkupCreator
   */
  protected $awesomeMarkupCreator;

  /**
   * Custom service that has some arguments.
   *
   * @var \Drupal\dependency_injection_examples\ServiceWithArguments
   */
  protected $serviceWithArguments;

  /**
   * Core messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Core logger factory service.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * ServiceWithWiredServices constructor.
   *
   * @param \Drupal\dependency_injection_examples\AwesomeMarkupCreator $awesome_markup_creator
   * @param \Drupal\dependency_injection_examples\ServiceWithArguments $service_with_arguments
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_channel_factory
   */
  public function __construct(
    AwesomeMarkupCreator $awesome_markup_creator,
    ServiceWithArguments $service_with_arguments,
    MessengerInterface $messenger,
    LoggerChannelFactoryInterface $logger_channel_factory
  )
  {
    $this->awesomeMarkupCreator = $awesome_markup_creator;
    $this->serviceWithArguments = $service_with_arguments;
    $this->messenger = $messenger;
    $this->logger = $logger_channel_factory->get('di_wired');
  }

  /**
   * Get the arguments from our custom service with arguments as markup.
   *
   * @return \Drupal\Component\Render\MarkupInterface|string
   */
  public function getServiceArgumentsAsMarkup() {
    $arguments = $this->serviceWithArguments->getArguments();
    return $this->awesomeMarkupCreator->makeMarkup($arguments);
  }

  /**
   * Use the logger to create a log of the arguments from our service.
   */
  public function logServiceArgumentsAsMarkup() {
    $this->logger->info('Arguments from our service: %arguments_markup', [
      '%arguments_markup' => $this->getServiceArgumentsAsMarkup(),
    ]);
  }

  /**
   * Use the messenger service to output the arguments from our service.
   */
  public function messageServiceArgumentsAsMarkup() {
    $this->messenger->addStatus('Arguments from our service:');
    $this->messenger->addStatus(
      $this->getServiceArgumentsAsMarkup()
    );
  }

}
