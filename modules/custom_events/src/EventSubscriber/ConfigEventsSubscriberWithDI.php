<?php

namespace Drupal\custom_events\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ConfigEventsSubscriberWithDI.
 *
 * @package Drupal\custom_events\EventSubscriber
 */
class ConfigEventsSubscriberWithDI implements EventSubscriberInterface, ContainerInjectionInterface {

  /**
   * Messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  public $messenger;

  /**
   * {@inheritdoc}
   *
   * @return array
   *   The event names to listen for, and the methods that should be executed.
   */
  public static function getSubscribedEvents() {
    return [
      ConfigEvents::SAVE => 'configSave',
      ConfigEvents::DELETE => 'configDelete',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return static(
      $container->get('messenger')
    );
  }

  /**
   * ConfigEventsSubscriberWithDI constructor.
   *
   * @param \Drupal\custom_events\EventSubscriber\MessengerInterface $messenger
   *   Messenger service injected during the static create() method.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * React to a config object being saved.
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   Config crud event.
   */
  public function configSave(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    $this->messenger->addStatus('Saved config: ' . $config->getName());
  }

  /**
   * React to a config object being deleted.
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   Config crud event.
   */
  public function configDelete(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    $this->messenger->addStatus('Deleted config: ' . $config->getName());
  }

}
