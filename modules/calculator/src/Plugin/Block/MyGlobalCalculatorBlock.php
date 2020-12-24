<?php

namespace Drupal\calculator\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\Markup;
use Drupal\calculator\Service\CalculatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a very simple block that displays some text.
 *
 * @Block(
 *   id = "my_global_calculator_block",
 *   admin_label = @Translation("My Global Calculator Block")
 * )
 */
class MyGlobalCalculatorBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Global calculator service.
   *
   * @var \Drupal\calculator\Service\CalculatorInterface
   */
  protected $globalCalculator;

  /**
   * {@inheritDoc}
   */
  static public function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('global_calculator')
    );
  }

  /**
   * MyGlobalCalculatorBlock constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\calculator\Service\CalculatorInterface $global_calculator
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CalculatorInterface $global_calculator) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->globalCalculator = $global_calculator;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => Markup::create('Calculated Total: ' . $this->globalCalculator->getValue() ),
    ];
  }

}
