<?php

namespace Drupal\services_examples;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * Class PasswordGeneratorUnambiguous.
 *
 * @package Drupal\services_examples
 */
class PasswordGeneratorUnambiguous extends PasswordGeneratorCryptoSecure {

  /**
   * {@inheritDoc}
   */
  public function setLogger(LoggerChannelFactoryInterface $logger_channel_factory) {
    $this->logger = $logger_channel_factory->get('pass_unambig');
  }

  /**
   * {@inheritDoc}
   */
  public function getCharacterSets() {
    return [
      'numbers' => '23479',
      'lower' => 'abcdefghjkmnpqrstuvwxyz',
      'upper' => 'ACDEFHJKMNPQRTUVWXYZ',
      'symbols' => '@#$%^&*(){}[]',
    ];
  }

}
