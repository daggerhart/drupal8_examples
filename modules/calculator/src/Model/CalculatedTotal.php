<?php

namespace Drupal\calculator\Model;

/**
 * Class CalculatedTotal.
 *
 * @package Drupal\calculator\Model
 */
class CalculatedTotal implements CalculatedTotalInterface {

  /**
   * History of the value changes.
   *
   * @var array
   */
  protected $history = [];

  /**
   * CalculatedTotal constructor.
   *
   * @param int $initial_value
   *   Initial value of the total.
   */
  public function __construct($initial_value = 0) {
    $this->update($initial_value);
  }

  /**
   * {@inheritdoc}
   */
  public function value() {
    $last = array_key_last($this->history);
    return $this->history[$last];
  }

  /**
   * {@inheritdoc}
   */
  public function update($next_value) {
    $this->history[] = $next_value;
  }

  /**
   * {@inheritdoc}
   */
  public function history(): array {
    return $this->history;
  }

}
