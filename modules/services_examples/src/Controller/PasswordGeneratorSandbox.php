<?php

namespace Drupal\services_examples\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;
use Drupal\services_examples\BasicPasswordGenerator;
use Drupal\services_examples\CryptoSecurePasswordGenerator;
use Drupal\services_examples\UnambiguousCryptoSecurePasswordGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PasswordGeneratorSandbox.
 *
 * @package Drupal\services_examples\Controller
 */
class PasswordGeneratorSandbox extends ControllerBase {

  /**
   * @var \Drupal\services_examples\BasicPasswordGenerator
   */
  protected $basic;

  /**
   * @var \Drupal\services_examples\CryptoSecurePasswordGenerator
   */
  protected $crypto;

  /**
   * @var \Drupal\services_examples\UnambiguousCryptoSecurePasswordGenerator
   */
  protected $unambiguous;

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('basic_password_generator'),
      $container->get('crypto_secure_password_generator'),
      $container->get('unambiguous_password_generator')
    );
  }

  /**
   * PasswordGeneratorSandbox constructor.
   *
   * @param \Drupal\services_examples\BasicPasswordGenerator $basic_password_generator
   * @param \Drupal\services_examples\CryptoSecurePasswordGenerator $crypto_secure_password_generator
   * @param \Drupal\services_examples\UnambiguousCryptoSecurePasswordGenerator $unambiguous_crypto_secure_password_generator
   */
  public function __construct(
    BasicPasswordGenerator $basic_password_generator,
    CryptoSecurePasswordGenerator $crypto_secure_password_generator,
    UnambiguousCryptoSecurePasswordGenerator $unambiguous_crypto_secure_password_generator
  ) {
    $this->basic = $basic_password_generator;
    $this->crypto = $crypto_secure_password_generator;
    $this->unambiguous = $unambiguous_crypto_secure_password_generator;
  }

  /**
   * @return array[]
   */
  public function page() {
    return [
      'password' => [
        '#markup' => Markup::create("
          <h2>Basic Password</h2>
          <pre>{$this->basic->generatePassword()}</pre>
        "),
      ],
      'crypto' => [
        '#markup' => Markup::create("
          <h2>Cryptographically Secure Password</h2>
          <pre>{$this->crypto->generatePassword()}</pre>
        "),
      ],
      'unambiguous' => [
        '#markup' => Markup::create("
          <h2>Unambiguous Password</h2>
          <pre>{$this->unambiguous->generatePassword()}</pre>
        "),
      ],
      'unambiguous_limited' => [
        '#markup' => Markup::create("
          <h2>Unambiguous Password limited</h2>
          <pre>{$this->unambiguous->generatePassword(32, ['numbers', 'lower', 'upper'])}</pre>
        "),
      ],
    ];
  }

}
