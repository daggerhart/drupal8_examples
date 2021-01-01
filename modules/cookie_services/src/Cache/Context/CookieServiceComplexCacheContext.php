<?php

namespace Drupal\cookie_services\Cache\Context;

use Drupal\cookie_services\CookieServiceInterface;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;

/**
 * Class CookieServiceComplexCacheContext.
 *
 * Example using a portion of complex cookie data as a custom cache context.
 *
 * @package Drupal\cookie_services\Cache\Context
 */
class CookieServiceComplexCacheContext implements CacheContextInterface {

  /**
   * Complex cookie service.
   *
   * @var \Drupal\cookie_services\CookieServiceInterface
   */
  protected $anotherCookieServiceComplex;

  /**
   * CookieServiceComplexCacheContext constructor.
   *
   * @param \Drupal\cookie_services\CookieServiceInterface $another_cookie_service_complex
   *   Complex cookie service.
   */
  public function __construct(CookieServiceInterface $another_cookie_service_complex) {
    $this->anotherCookieServiceComplex = $another_cookie_service_complex;
  }

  /**
   * {@inheritdoc}
   */
  public static function getLabel() {
    return t('Another Cookie Service Complex - City');
  }

  /**
   * {@inheritdoc}
   */
  public function getContext() {
    $cookie_value = $this->anotherCookieServiceComplex->getCookieValue();
    return $cookie_value['city'] ?? false;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }

}
