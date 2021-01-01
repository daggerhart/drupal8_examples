<?php

namespace Drupal\services_examples\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\services_examples\CookieServiceSimple;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CookieServiceSimpleForm.
 *
 * @package Drupal\services_examples\Form
 */
class CookieServiceSimpleForm extends FormBase {

  /**
   * Our simple cookie service that counts requests.
   *
   * @var \Drupal\services_examples\CookieServiceSimple
   */
  protected $cookieServiceSimple;

  /**
   * CookieServiceSimpleForm constructor.
   *
   * @param \Drupal\services_examples\CookieServiceSimple $cookie_service_simple
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
    $form['current_value'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Current Cookie Value'),
      'value' => [
        '#markup' => $this->cookieServiceSimple->getCookieValue(),
      ],
    ];
    $form['new_value'] = [
      '#type' => 'number',
      '#title' => $this->t('New Cookie Value'),
      '#default_value' => $this->cookieServiceSimple->getCookieValue(),
    ];
    $form['actions'] = [
      '#type' => 'actions',
      'set_cookie_value' => [
        '#type' => 'submit',
        '#value' => $this->t('Set New Cookie Value'),
      ],
      'delete_cookie' => [
        '#type' => 'submit',
        '#value' => $this->t('Delete Cookie'),
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
      case 'set_cookie_value':
        $this->messenger()->addStatus('Setting new cookie value.');
        $new_value = $form_state->getValue('new_value') ?? 0;
        $this->cookieServiceSimple->setCookieValue($new_value);
        break;

      case 'delete_cookie':
        $this->messenger()->addStatus('Deleting cookie.');
        $this->cookieServiceSimple->setShouldDeleteCookie(TRUE);
        break;
    }
  }

}
