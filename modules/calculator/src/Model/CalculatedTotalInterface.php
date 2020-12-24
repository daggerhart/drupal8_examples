<?php

namespace Drupal\calculator\Model;

/**
 * Interface CalculatedTotalInterface.
 *
 * @package Drupal\calculator\Model
 */
interface CalculatedTotalInterface {

  /**
   * Get the current value.
   *
   * @return int|float
   *   Latest value of the calculated total.
   */
  public function value();

  /**
   * Update the current value of the calculated total.
   *
   * @param int|float $next_value
   */
  public function update($next_value);

  /**
   * Get the entire calculation history.
   *
   * @return array
   */
  public function history(): array;

}
