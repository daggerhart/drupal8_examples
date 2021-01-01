<?php

namespace Drupal\services_examples;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class CookieServiceSimple.
 *
 * Count the number of requests this visitor has made and store the value as a
 * cookie in the visitor's browser.
 *
 * @package Drupal\services_examples
 */
class CookieServiceSimple implements EventSubscriberInterface {

  /**
   * Name of the cookie this service will manage.
   */
  const COOKIE_NAME = 'request_count';

  /**
   * Current request.
   *
   * @var \Symfony\Component\HttpFoundation\Request|null
   */
  protected $request;

  /**
   * The cookie value that will be set during the respond event.
   *
   * @var int
   */
  protected $newCookieValue;

  /**
   * Whether or not the cookie should be updated during the response event.
   *
   * @var bool
   */
  protected $shouldUpdateCookie = FALSE;

  /**
   * Whether or not the cookie should be deleted during the response event.
   *
   * @var bool
   */
  protected $shouldDeleteCookie = FALSE;

  /**
   * CookieServiceSimple constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   Core request stack.
   */
  public function __construct(RequestStack $request_stack) {
    $this->request = $request_stack->getCurrentRequest();
  }

  /**
   * Get the cookie's value.
   *
   * @return mixed
   */
  public function getCookieValue() {
    // If we're mid-request and setting a new cookie value, return it. This
    // handles the visitor's first request where a cookie could not be set yet.
    if (!empty($this->newCookieValue)) {
      return $this->newCookieValue;
    }

    return $this->request->cookies->get(self::COOKIE_NAME);
  }

  public function setCookieValue($value) {
    $this->shouldUpdateCookie = TRUE;
    $this->newCookieValue = $value;
  }

  /**
   * Get the "should update cookie" flag.
   *
   * @return bool
   *   Whether or not the cookie should be updated during the response event.
   */
  public function getShouldUpdateCookie() {
    return $this->shouldUpdateCookie;
  }

  /**
   * Get the "should delete cookie" flag.
   *
   * @return bool
   *   Whether or not the cookie should be deleted during the response event.
   */
  public function getShouldDeleteCookie() {
    return $this->shouldDeleteCookie;
  }

  /**
   * Set the "should delete cookie" flag.
   *
   * @param bool $delete_cookie
   *   Whether the cookie should be deleted during the response event.
   */
  public function setShouldDeleteCookie(bool $delete_cookie = TRUE) {
    $this->shouldDeleteCookie = $delete_cookie;
  }

  /**
   * {@inheritDoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::REQUEST => 'onRequest',
      KernelEvents::RESPONSE => 'onResponse',
    ];
  }

  /**
   * React to the symfony kernel request event.
   *
   * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
   *   The event to process.
   */
  public function onRequest(RequestEvent $event) {
    if (!$event->isMasterRequest()) {
      // The request event can fire more than once. Don't do anything if it's
      // not the master request.
      return;
    }

    $value = $this->getCookieValue();
    $value = (int) $value + 1;
    $this->setCookieValue($value);
  }

  /**
   * React to the symfony kernel response event by managing visitor cookies.
   *
   * @param \Symfony\Component\HttpKernel\Event\ResponseEvent $event
   *   The event to process.
   */
  public function onResponse(ResponseEvent $event) {
    $response = $event->getResponse();

    // If the cookie should be updated, add new cookie in the response headers.
    if ($this->getShouldUpdateCookie()) {
      $response->headers->setCookie(new Cookie(
        static::COOKIE_NAME,
        $this->getCookieValue()
      ));
    }

    // If the cookie should be deleted, clear it in the response headers.
    if ($this->getShouldDeleteCookie()) {
      $response->headers->clearCookie(static::COOKIE_NAME);
    }
  }

}
