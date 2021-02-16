<?php

namespace Drupal\cat_api;

/**
 * Interface CredentialsInterface.
 *
 * @package Drupal\cat_api
 */
interface CredentialsInterface {

  /**
   * Get this site's Cat API Key.
   *
   * @return string
   */
  public function getApiKey(): string;

}
