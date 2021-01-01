<?php

namespace Drupal\cookie_services\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\cookie_services\CookieServiceSimple;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CookieServiceSimpleForm.
 *
 * @package Drupal\cookie_services\Form
 */
class CookieServiceSandbox extends FormBase {

  /**
   * Our simple cookie service that counts requests.
   *
   * @var \Drupal\cookie_services\CookieServiceSimple
   */
  protected $cookieServiceSimple;

  /**
   * CookieServiceSimpleForm constructor.
   *
   * @param \Drupal\cookie_services\CookieServiceSimple $cookie_service_simple
   *   Simple cookie service.
   */
  public function __construct(CookieServiceSimple $cookie_service_simple) {
    $this->cookieServiceSimple = $cookie_service_simple;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cookie_service_simple')
    );
  }

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'cookie_service_simple_form';
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
        $this->messenger()->addStatus('Setting new cookie value.');
        $new_value = $form_state->getValue('new_value') ?? 0;
        $this->cookieServiceSimple->setCookieValue($new_value);
        break;

      case 'delete_simple_cookie':
        $this->messenger()->addStatus('Deleting cookie.');
        $this->cookieServiceSimple->setShouldDeleteCookie(TRUE);
        break;
    }
  }

}
