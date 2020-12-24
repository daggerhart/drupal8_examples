<?php

namespace Drupal\calculator\Service;

use Drupal\calculator\Model\CalculatedTotal;

/**
 * Class CalculatorFactory.
 *
 * @package Drupal\calculator\Service
 */
class CalculatorFactory implements CalculatorFactoryInterface {

  /**
   * {@inheritdoc}
   */
  public function createCalculator(): CalculatorInterface {
    return new Calculator( new CalculatedTotal() );
  }

}
