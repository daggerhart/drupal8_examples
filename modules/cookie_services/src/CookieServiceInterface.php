<?php

namespace Drupal\cookie_services;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface CookieServiceInterface.
 *
 * @package Drupal\cookie_services
 */
interface CookieServiceInterface extends EventSubscriberInterface {

  /**
   * Get the cookie's name.
   *
   * @return string
   *   Cookie name.
   */
  public function getCookieName();

  /**
   * Set the cookie's name.
   */
  public function setCookieName(string $cookie_name);

  /**
   * Get the cookie's value.
   *
   * @return mixed
   *   Cookie value.
   */
  public function getCookieValue();

  /**
   * Set the cookie's new value.
   *
   * @param mixed $value
   */
  public function setCookieValue($value);

  /**
   * Get the "should update cookie" flag.
   *
   * @return bool
   *   Whether or not the cookie should be updated during the response event.
   */
  public function getShouldUpdateCookie();

  /**
   * Get the "should delete cookie" flag.
   *
   * @return bool
   *   Whether or not the cookie should be deleted during the response event.
   */
  public function getShouldDeleteCookie();

  /**
   * Set the "should delete cookie" flag.
   *
   * @param bool $delete_cookie
   *   Whether the cookie should be deleted during the response event.
   */
  public function setShouldDeleteCookie(bool $delete_cookie = TRUE);

}
