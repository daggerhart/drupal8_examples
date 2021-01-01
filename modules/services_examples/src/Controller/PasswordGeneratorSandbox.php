<?php

namespace Drupal\services_examples\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;
use Drupal\services_examples\PasswordGeneratorInterface;
use Drupal\services_examples\PasswordGeneratorSimple;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PasswordGeneratorSandbox.
 *
 * @package Drupal\services_examples\Controller
 */
class PasswordGeneratorSandbox extends ControllerBase {

  /**
   * @var \Drupal\services_examples\PasswordGeneratorSimple
   */
  protected $simple;

  /**
   * @var \Drupal\services_examples\PasswordGeneratorInterface
   */
  protected $crypto;

  /**
   * @var \Drupal\services_examples\PasswordGeneratorInterface
   */
  protected $unambiguous;

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('password_generator_simple'),
      $container->get('password_generator_crypto_secure'),
      $container->get('password_generator_unambiguous')
    );
  }

  /**
   * PasswordGeneratorSandbox constructor.
   *
   * @param \Drupal\services_examples\PasswordGeneratorSimple $password_generator_simple
   *   Simple password generator service.
   * @param \Drupal\services_examples\PasswordGeneratorInterface $password_generator_crypto_secure
   *   Crypto secure password generator service.
   * @param \Drupal\services_examples\PasswordGeneratorInterface $password_generator_unambiguous_crypto_secure
   *   Unambiguous password generator service (decorated)
   */
  public function __construct(
    PasswordGeneratorSimple $password_generator_simple,
    PasswordGeneratorInterface $password_generator_crypto_secure,
    PasswordGeneratorInterface $password_generator_unambiguous_crypto_secure
  ) {
    $this->simple = $password_generator_simple;
    $this->crypto = $password_generator_crypto_secure;
    $this->unambiguous = $password_generator_unambiguous_crypto_secure;
  }

  /**
   * Page output.
   *
   * @return array[]
   *   Render array.
   */
  public function page() {
    return [
      'password' => [
        '#markup' => Markup::create("
          <h2>Basic Password</h2>
          <pre>{$this->simple->generatePassword()}</pre>
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
