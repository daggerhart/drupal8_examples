<?php

namespace Drupal\cookie_services;

use Drupal\Component\Serialization\SerializationInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class CookieServiceComplexData.
 *
 * @package Drupal\cookie_services
 */
class CookieServiceComplexData implements CookieServiceInterface {

  /**
   * Name of the cookie this service will manage.
   *
   * @var string
   */
  protected $cookieName;

  /**
   * Current request.
   *
   * @var \Symfony\Component\HttpFoundation\Request|null
   */
  protected $request;

  /**
   * Json serialization service.
   *
   * @var \Drupal\Component\Serialization\SerializationInterface
   */
  protected $json;

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
   * @param \Drupal\Component\Serialization\SerializationInterface $json
   *   Json serialization service.
   */
  public function __construct(RequestStack $request_stack, SerializationInterface $json) {
    $this->request = $request_stack->getCurrentRequest();
    $this->json = $json;
  }

  /**
   * {@inheritDoc}
   */
  public function getCookieName() {
    return $this->cookieName;
  }

  /**
   * {@inheritDoc}
   */
  public function setCookieName(string $cookie_name) {
    $this->cookieName = $cookie_name;
  }

  /**
   * {@inheritDoc}
   */
  public function getCookieValue() {
    // If we're mid-request and setting a new cookie value, return it. This
    // handles the visitor's first request where a cookie could not be set yet.
    if (!empty($this->newCookieValue)) {
      return $this->newCookieValue;
    }

    // Get the value from the cookie and attempt to decode it.
    $value = $this->request->cookies->get($this->getCookieName());

    try {
      $value = $this->json->decode($value);
    }
    catch (\Exception $exception) {}

    return $value;
  }

  /**
   * {@inheritDoc}
   */
  public function setCookieValue($value) {
    $this->shouldUpdateCookie = TRUE;
    $this->newCookieValue = $value;
  }

  /**
   * {@inheritDoc}
   */
  public function getShouldUpdateCookie() {
    return $this->shouldUpdateCookie;
  }

  /**
   * {@inheritDoc}
   */
  public function getShouldDeleteCookie() {
    return $this->shouldDeleteCookie;
  }

  /**
   * {@inheritDoc}
   */
  public function setShouldDeleteCookie(bool $delete_cookie = TRUE) {
    $this->shouldDeleteCookie = $delete_cookie;
  }

  /**
   * {@inheritDoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => 'onResponse',
    ];
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
      $value = $this->getCookieValue();
      if (is_array($value) || is_object($value)) {
        $value = $this->json->encode((array) $value);
      }

      $response->headers->setCookie(new Cookie(
        $this->getCookieName(),
        $value
      ));
    }

    // If the cookie should be deleted, clear it in the response headers.
    if ($this->getShouldDeleteCookie()) {
      $response->headers->clearCookie($this->getCookieName());
    }
  }

}
