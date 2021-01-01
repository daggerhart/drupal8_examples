<?php

namespace Drupal\cookie_services\Form;

use Drupal\cookie_services\CookieServiceInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CookieServiceSandbox.
 *
 * @package Drupal\cookie_services\Form
 */
class CookieServiceSandbox extends FormBase {

  /**
   * Our simple cookie service that counts requests.
   *
   * @var \Drupal\cookie_services\CookieServiceInterface
   */
  protected $cookieServiceSimple;

  /**
   * Our complex cookie service.
   *
   * @var \Drupal\cookie_services\CookieServiceInterface
   */
  protected $cookieServiceComplex;

  /**
   * @var \Drupal\cookie_services\CookieServiceInterface
   */
  protected $anotherCookieServiceComplex;

  /**
   * CookieServiceSimpleForm constructor.
   *
   * @param \Drupal\cookie_services\CookieServiceInterface $cookie_service_simple
   *   Simple cookie service.
   * @param \Drupal\cookie_services\CookieServiceInterface $cookie_service_complex
   *   Complex cookie service.
   * @param \Drupal\cookie_services\CookieServiceInterface $another_cookie_service_complex
   *   Another complex cookie
   */
  public function __construct(
    CookieServiceInterface $cookie_service_simple,
    CookieServiceInterface $cookie_service_complex,
    CookieServiceInterface $another_cookie_service_complex
  ) {
    $this->cookieServiceSimple = $cookie_service_simple;
    $this->cookieServiceComplex = $cookie_service_complex;
    $this->anotherCookieServiceComplex = $another_cookie_service_complex;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cookie_service_simple'),
      $container->get('cookie_service_complex'),
      $container->get('another_cookie_service_complex')
    );
  }

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'cookie_service_sandbox_form';
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['simple'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Simple Cookie - Requests Count'),
      'current_value' => [
        '#markup' => 'Current Value: ' . $this->cookieServiceSimple->getCookieValue(),
      ],
      'new_value' => [
        '#type' => 'number',
        '#title' => $this->t('Set New Cookie Value'),
        '#default_value' => $this->cookieServiceSimple->getCookieValue(),
      ],
      'actions' => [
        '#type' => 'actions',
        'set_simple_cookie_value' => [
          '#type' => 'submit',
          '#value' => $this->t('Set New Cookie Value'),
        ],
        'delete_simple_cookie' => [
          '#type' => 'submit',
          '#value' => $this->t('Delete Cookie'),
        ],
      ],
    ];

    $complex_data = print_r($this->cookieServiceComplex->getCookieValue(), 1);
    $form['complex'] = [
      '#type' => 'fieldset',
      '#title' => $this->t("Complex Cookie - {$this->cookieServiceComplex->getCookieName()} - Random Data"),
      'current_value' => [
        '#markup' => Markup::create("
          Current Value:<br>
          <pre>{$complex_data}</pre>
        "),
      ],
      'actions' => [
        '#type' => 'actions',
        'set_complex_cookie_value' => [
          '#type' => 'submit',
          '#value' => $this->t("Set New Complex Cookie Value - {$this->cookieServiceComplex->getCookieName()}"),
        ],
        'delete_complex_cookie' => [
          '#type' => 'submit',
          '#value' => $this->t("Delete Complex Cookie - {$this->cookieServiceComplex->getCookieName()}"),
        ],
      ],
    ];

    $another_complex_data = print_r($this->anotherCookieServiceComplex->getCookieValue(), 1);
    $form['another_complex'] = [
      '#type' => 'fieldset',
      '#title' => $this->t("Complex Cookie - {$this->anotherCookieServiceComplex->getCookieName()} - Random Data"),
      'current_value' => [
        '#markup' => Markup::create("
          Current Value:<br>
          <pre>{$another_complex_data}</pre>
        "),
      ],
      'actions' => [
        '#type' => 'actions',
        'set_another_complex_cookie_value' => [
          '#type' => 'submit',
          '#value' => $this->t("Set New Complex Cookie Value - {$this->anotherCookieServiceComplex->getCookieName()}"),
        ],
        'delete_another_complex_cookie' => [
          '#type' => 'submit',
          '#value' => $this->t("Delete Complex Cookie - {$this->anotherCookieServiceComplex->getCookieName()}"),
        ],
      ],
    ];

    return $form;
  }

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $trigger = $form_state->getTriggeringElement();
    $trigger_button = NULL;
    if (isset($trigger['#parents'], $trigger['#parents'][0])) {
      $trigger_button = $trigger['#parents'][0];
    }

    switch ($trigger_button) {
      case 'set_simple_cookie_value':
        $this->messenger()->addStatus('Setting new simple cookie value.');
        $new_value = $form_state->getValue('new_value') ?? 0;
        $this->cookieServiceSimple->setCookieValue($new_value);
        break;

      case 'delete_simple_cookie':
        $this->messenger()->addStatus('Deleting simple cookie.');
        $this->cookieServiceSimple->setShouldDeleteCookie(TRUE);
        break;

      case 'set_complex_cookie_value':
        $this->messenger()->addStatus("Setting new complex cookie value for {$this->cookieServiceComplex->getCookieName()}.");
        $value = [
          'some_value' => random_int(0, random_int(100, 1000000)),
          'another_value' => random_int(0, random_int(100, 1000000)),
          'again' => random_int(0, random_int(100, 1000000)),
          'more' => random_int(0, random_int(100, 1000000)),
        ];
        $this->cookieServiceComplex->setCookieValue($value);
        break;

      case 'delete_complex_cookie':
        $this->messenger()->addStatus("Deleting complex cookie {$this->cookieServiceComplex->getCookieName()}.");
        $this->cookieServiceComplex->setShouldDeleteCookie(TRUE);
        break;

      case 'set_another_complex_cookie_value':
        $this->messenger()->addStatus("Setting new complex cookie value for {$this->anotherCookieServiceComplex->getCookieName()}.");
        $value = [
          'first' => random_int(0, random_int(100, 1000000)),
          'last' => random_int(0, random_int(100, 1000000)),
          'city' => random_int(0, random_int(100, 1000000)),
          'state' => random_int(0, random_int(100, 1000000)),
        ];
        $this->anotherCookieServiceComplex->setCookieValue($value);
        break;

      case 'delete_another_complex_cookie':
        $this->messenger()->addStatus("Deleting complex cookie {$this->anotherCookieServiceComplex->getCookieName()}.");
        $this->anotherCookieServiceComplex->setShouldDeleteCookie(TRUE);
        break;
    }
  }

}
