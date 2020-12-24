<?php

namespace Drupal\calculator\Service;

interface CalculatorFactoryInterface {

  /**
   * Create a new calculator instance ready for use.
   *
   * @return \Drupal\calculator\Service\Calculator
   *   New calculator instance with default total.
   */
  public function createCalculator(): CalculatorInterface;

}
