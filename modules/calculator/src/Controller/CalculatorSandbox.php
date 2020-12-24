<?php

namespace Drupal\calculator\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Render\Markup;
use Drupal\calculator\Service\CalculatorInterface;
use Drupal\calculator\Service\CalculatorFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CalculatorSandbox.
 *
 * @package Drupal\calculator\Controller
 */
class CalculatorSandbox implements ContainerInjectionInterface {

  /**
   * Core messenger instance.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * @var \Drupal\calculator\Service\CalculatorFactoryInterface
   */
  protected $calculatorFactory;

  /**
   * @var \Drupal\calculator\Service\CalculatorInterface
   */
  protected $globalCalculator;

  /**
   * {@inheritdoc}
   */
  static public function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger'),
      $container->get('calculator_factory'),
      $container->get('global_calculator')
    );
  }

  /**
   * CalculatorSandbox constructor.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   Core messenger instance.
   * @param \Drupal\calculator\Service\CalculatorFactoryInterface $calculator_factory
   *   Calculator factory.
   * @param \Drupal\calculator\Service\CalculatorInterface $global_calculator
   *   Global calculator.
   */
  public function __construct(
    MessengerInterface $messenger,
    CalculatorFactoryInterface $calculator_factory,
    CalculatorInterface $global_calculator
  )
  {
    $this->messenger = $messenger;
    $this->calculatorFactory = $calculator_factory;
    $this->globalCalculator = $global_calculator;
  }

  /**
   * @return array
   *   Render array.
   */
  public function page() {
    $this->messenger->addStatus('Hello');
    $this->globalCalculator
      ->add(5)
      ->subtract(7)
      ->add(156.89)
      ->divide(3)
    ;

    return [
      'total' => [
        '#markup' => $this->globalCalculator->getValue(),
      ],
      'history' => [
        '#markup' => Markup::create('<pre>' . print_r($this->globalCalculator->getTotal()->history(),1) . '</pre>'),
      ]
    ];
  }

}
