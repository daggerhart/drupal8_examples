<?php

namespace Drupal\custom_events\Event;

use Drupal\user\UserInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Event that is fired when a user logs in.
 */
class UserLoginEvent extends Event {

  const EVENT_NAME = 'custom_events_user_login';

  /**
   * The user account.
   *
   * @var \Drupal\user\UserInterface
   */
  public $account;

  /**
   * Constructs the object.
   *
   * @param \Drupal\user\UserInterface $account
   *   The account of the user logged in.
   */
  public function __construct(UserInterface $account) {
    $this->account = $account;
  }

}
