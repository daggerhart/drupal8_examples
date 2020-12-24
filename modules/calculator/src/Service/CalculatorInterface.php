<?php

namespace Drupal\calculator\Service;

use Drupal\calculator\Model\CalculatedTotalInterface;

/**
 * Interface CalculatorInterface.
 *
 * Interfaces describe strict method specifications.
 */
interface CalculatorInterface {

  /**
   * Number calculated.
   *
   * @return int|float
   */
  public function getValue();

  /**
   * Get the calculated total instance.
   *
   * @return \Drupal\calculator\Model\CalculatedTotalInterface
   */
  public function getTotal(): CalculatedTotalInterface;

  /**
   * Add a number to the total.
   *
   * @param int|float $a
   *   Any number.
   *
   * @return CalculatorInterface
   *   Calculator instance.
   */
  public function add($a): CalculatorInterface;

  /**
   * Subtract a number to the total.
   *
   * @param int|float $a
   *   Any number.
   *
   * @return CalculatorInterface
   *   Calculator instance.
   */
  public function subtract($a): CalculatorInterface;

  /**
   * Divide the total by a number.
   *
   * @param int|float $a
   *   Any number.
   *
   * @return CalculatorInterface
   *   Calculator instance.
   */
  public function divide($a): CalculatorInterface;

  /**
   * Multiply the total by a number.
   *
   * @param int|float $a
   *   Any number.
   *
   * @return CalculatorInterface
   *   Calculator instance.
   */
  public function multiply($a): CalculatorInterface;

}
