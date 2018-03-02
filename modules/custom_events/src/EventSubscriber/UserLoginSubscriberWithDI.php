<?php

namespace Drupal\custom_events\EventSubscriber;

use Drupal\Core\Database\Connection;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\custom_events\Event\UserLoginEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class UserLoginSubscriber.
 *
 * @package Drupal\custom_events\EventSubscriber
 */
class UserLoginSubscriberWithDI implements EventSubscriberInterface, ContainerInjectionInterface {

  /**
   * Database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      // Static class constant => method on this class.
      UserLoginEvent::EVENT_NAME => 'onUserLogin',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('date.formatter')
    );
  }

  /**
   * UserLoginSubscriber constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   Database connection object.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   Date formatter.
   */
  public function __construct(Connection $database, DateFormatterInterface $date_formatter) {
    $this->database = $database;
    $this->dateFormatter = $date_formatter;
  }

  /**
   * React to the user login event dispatched.
   *
   * @param \Drupal\custom_events\Event\UserLoginEvent $event
   *   Dat event object yo.
   */
  public function onUserLogin(UserLoginEvent $event) {
    $account_created = $this->database->select('users_field_data', 'ud')
      ->fields('ud', ['created'])
      ->condition('ud.uid', $event->account->id())
      ->execute()
      ->fetchField();

    drupal_set_message(t('Welcome, your account was created on %created_date.', [
      '%created_date' => $this->dateFormatter->format($account_created, 'short'),
    ]));
  }

}
