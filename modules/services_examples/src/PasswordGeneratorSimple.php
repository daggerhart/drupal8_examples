<?php

namespace Drupal\services_examples;

/**
 * Class PasswordGeneratorSimple.
 *
 * @package Drupal\services_examples
 */
class PasswordGeneratorSimple {

  /**
   * Generate a password.
   *
   * @param int $length
   *
   * @return string
   */
  public function generatePassword($length = 29) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $password = '';
    for ($i = 0; $i < $length; $i++) {
      $password .= $characters[rand(0, $characters_length - 1)];
    }

    return $password;
  }

}
