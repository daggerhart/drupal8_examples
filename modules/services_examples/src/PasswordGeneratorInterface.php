<?php

namespace Drupal\services_examples;

/**
 * Interface PasswordGeneratorInterface.
 *
 * @package Drupal\services_examples
 */
interface PasswordGeneratorInterface {

  /**
   * Generate a password.
   *
   * @param int $length
   *
   * @return string
   */
  public function generatePassword($length = 16, $allowed_sets = []);

}
