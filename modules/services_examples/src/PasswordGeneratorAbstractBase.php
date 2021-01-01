<?php

namespace Drupal\services_examples;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Class PasswordGeneratorAbstractBase.
 *
 * @package Drupal\services_examples
 */
abstract class PasswordGeneratorAbstractBase implements PasswordGeneratorInterface {

  use StringTranslationTrait;

  /**
   * Messenger.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Logger.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * BasePasswordGenerator constructor.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   Core messenger.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * Set the logger channel instance on this service.
   *
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_channel_factory
   *   Logger factory.
   */
  abstract public function setLogger(LoggerChannelFactoryInterface $logger_channel_factory);

  /**
   * Get a random number.
   *
   * @param int|null $min
   *   Number floor.
   * @param int|null $max
   *   Number ceiling.
   *
   * @return int
   */
  abstract public function getRandomNumber(int $min = 0, int $max = NULL);

  /**
   * Return an associative array where each value is a list of characters that
   * can be used for password generation.
   *
   * @return array
   */
  public function getCharacterSets() {
    return [
      'numbers' => '0123456789',
      'lower' => 'abcdefghijklmnopqrstuvwxyz',
      'upper' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
      'symbols' => '@#$%^&*(){}[]',
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function generatePassword($length = 16, $allowed_sets = []) {
    $sets = $this->getCharacterSets();

    if (!empty($allowed_sets)) {
      $sets = array_filter($sets, function($key) use ($allowed_sets) {
        return in_array($key, $allowed_sets);
      }, ARRAY_FILTER_USE_KEY);
    }

    $total_sets = count($sets);
    $password = '';
    // Ensure each set is used at least once.
    foreach ($sets as $characters) {
      $characters_length = strlen($characters);
      $password .= $characters[$this->getRandomNumber(0, $characters_length - 1)];
      $length -= 1;
    }

    for ($i = 0; $i < $length; $i++) {
      // Get a random character set.
      $characters = array_values($sets)[$this->getRandomNumber(0, $total_sets -1)];
      $characters_length = strlen($characters);

      // Get a random character from the set.
      $password .= $characters[$this->getRandomNumber(0, $characters_length - 1)];
    }

    $this->messenger->addStatus($this->t('Password Generated: %password', [
      '%password' => $password,
    ]));

    $this->logger->info('Password Generated. Length: %length, Sets: %sets', [
      '%length' => $length + $total_sets,
      '%sets' => implode(', ', array_keys($sets)),
    ]);

    return $password;
  }

}
