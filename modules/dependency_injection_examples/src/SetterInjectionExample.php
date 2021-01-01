<?php

namespace Drupal\dependency_injection_examples;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;

class SetterInjectionExample {

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
   * SetterInjectionExample constructor.
   *
   * @param \Drupal\dependency_injection_examples\ServiceWithArguments $service_with_arguments
   */
  public function __construct(ServiceWithArguments $service_with_arguments) {
    $this->serviceWithArguments = $service_with_arguments;
  }

  /**
   * Set the service's awesome markup creator.
   *
   * @param \Drupal\dependency_injection_examples\AwesomeMarkupCreator $awesome_markup_creator
   */
  public function setAwesomeMarkupCreator(AwesomeMarkupCreator $awesome_markup_creator) {
    $this->awesomeMarkupCreator = $awesome_markup_creator;
  }

  /**
   * Set the service's logger.
   *
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_channel_factory
   */
  public function setLogger(LoggerChannelFactoryInterface $logger_channel_factory) {
    $this->logger = $logger_channel_factory->get('di_injected');
  }

  /**
   * Set the service's messenger.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   */
  public function setMessenger(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * Use the messenger service to output the arguments from our service.
   */
  public function messageServiceArgumentsAsMarkup() {
    $this->messenger->addStatus('Message and arguments using our injected services:');
    $arguments = $this->serviceWithArguments->getArguments();
    $message = $this->awesomeMarkupCreator->makeMarkup($arguments);
    $this->messenger->addStatus($message);
  }

}
