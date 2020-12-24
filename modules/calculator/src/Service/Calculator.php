<?php

namespace Drupal\calculator\Service;

use Drupal\calculator\Model\CalculatedTotalInterface;

/**
 * Class Calculator.
 *
 * @package Drupal\calculator\Service
 */
class Calculator implements CalculatorInterface {

  /**
   * Where we are storing the total number calculated.
   *
   * @var \Drupal\calculator\Model\CalculatedTotalInterface
   */
  protected $total;

  /**
   * Calculator constructor.
   * This method is executed automatically when a class is instantiated.
   *
   * @param \Drupal\calculator\Model\CalculatedTotalInterface $starting_total
   */
  public function __construct(CalculatedTotalInterface $starting_total) {
    $this->total = $starting_total;
  }

  /**
   * {@inheritdoc}
   */
  function getValue() {
    return $this->total->value();
  }

  /**
   * {@inheritdoc}
   */
  public function getTotal(): CalculatedTotalInterface {
    return $this->total;
  }

  /**
   * {@inheritdoc}
   */
  function add($a): CalculatorInterface {
    $this->total->update(
      $this->total->value() + $a
    );

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  function subtract($a): CalculatorInterface {
    $this->total->update(
      $this->total->value() - $a
    );

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  function divide($a): CalculatorInterface {
    $this->total->update(
      $this->total->value() / $a
    );

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  function multiply($a): CalculatorInterface {
    $this->total->update(
      $this->total->value() * $a
    );

    return $this;
  }

}
