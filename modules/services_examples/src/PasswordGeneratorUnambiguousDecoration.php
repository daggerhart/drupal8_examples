<?php

namespace Drupal\services_examples;

/**
 * Class PasswordGeneratorUnambiguousDecoration.
 *
 * @package Drupal\services_examples
 */
class PasswordGeneratorUnambiguousDecoration implements PasswordGeneratorInterface {

  /**
   * Service that is decorated.
   *
   * @var \Drupal\services_examples\PasswordGeneratorUnambiguous
   */
  protected $innerService;

  /**
   * PasswordGeneratorUnambiguousDecoration constructor.
   *
   * @param \Drupal\services_examples\PasswordGeneratorUnambiguous $password_generator_unambiguous
   *   Service that is being decorated.
   */
  public function __construct(PasswordGeneratorUnambiguous $password_generator_unambiguous) {
    $this->innerService = $password_generator_unambiguous;
  }

  /**
   * {@inheritDoc}
   */
  public function generatePassword($length = 32, $allowed_sets = []) {
    $inner_service = get_class($this->innerService);
    \Drupal::messenger()->addStatus("This message provided by the decoration on {$inner_service}. Even though the original service was requested, the container smartly returned an instance of the decoration. If a service is decorated multiple times, the decoration with the highest priority going first.");

    return $this->innerService->generatePassword($length, $allowed_sets);
  }

}
