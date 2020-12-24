<?php

namespace Drupal\dependency_injection_examples;

/**
 * Class ServiceWithArguments.
 *
 * @package Drupal\dependency_injection_examples
 */
class ServiceWithArguments {

  /**
   * Array of whatever we want.
   *
   * @var array
   */
  protected $arguments = [];

  /**
   * ServiceWithArguments constructor.
   */
  public function __construct() {
    $this->arguments = func_get_args();
  }

  /**
   * @return array
   *   All arguments passed into the constructor.
   */
  public function getArguments(): array {
    return $this->arguments;
  }

}
