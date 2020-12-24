<?php

namespace Drupal\dependency_injection_examples;

use Drupal\Core\Render\Markup;

/**
 * Class AwesomeMarkupCreator.
 *
 * @package Drupal\dependency_injection_examples
 */
class AwesomeMarkupCreator {

  /**
   * Convert stuff into markup wrapped in preformatted element.
   *
   * @param mixed $value
   *
   * @return \Drupal\Component\Render\MarkupInterface|string
   */
  public function makeMarkup($value) {
    if (is_array($value) || is_object($value)) {
      $value = print_r($value, 1);
    }

    return Markup::create("<pre>{$value}</pre>");
  }

}
