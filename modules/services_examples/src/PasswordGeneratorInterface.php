<?php

namespace Drupal\services_examples;

interface PasswordGeneratorInterface {

  /**
   * Generate a password.
   *
   * @param int $length
   *
   * @return string
   */
  public function generatePassword($length, $allowed_sets = []);

}
