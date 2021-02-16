<?php

namespace Drupal\cat_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 *
 * @package Drupal\cat_api\Form
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'cat_api.settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'cat_api.settings',
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('cat_api.settings');

    $form['base_uri'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Api Base Url'),
      '#default_value' => $config->get('base_uri'),
    ];
    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Api Key'),
      '#default_value' => $config->get('api_key'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('cat_api.settings')
      ->set('base_uri', rtrim($form_state->getValue('base_uri'), '/') . '/')
      ->set('api_key', trim($form_state->getValue('api_key')))
      ->save();
  }

}
