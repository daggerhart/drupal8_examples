<?php

namespace Drupal\services_examples;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * Class PasswordGeneratorCryptoSecure.
 *
 * @package Drupal\services_examples
 */
class PasswordGeneratorCryptoSecure extends PasswordGeneratorAbstractBase {

  /**
   * {@inheritDoc}
   */
  public function setLogger(LoggerChannelFactoryInterface $logger_channel_factory) {
    $this->logger = $logger_channel_factory->get('pass_crypto');
  }

  /**
   * {@inheritDoc}
   */
  public function getRandomNumber(int $min = NULL, int $max = NULL) {
    return random_int($min, $max);
  }

}
