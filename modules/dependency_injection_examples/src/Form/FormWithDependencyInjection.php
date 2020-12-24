<?php

namespace Drupal\dependency_injection_examples\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\dependency_injection_examples\ServiceWithWiredServices;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class FormWithDependencyInjection.
 *
 * @package Drupal\dependency_injection_examples\Form
 */
class FormWithDependencyInjection extends FormBase {

  /**
   * My wired service.
   *
   * @var \Drupal\dependency_injection_examples\ServiceWithWiredServices
   */
  protected $serviceWithWiredServices;

  /**
   * {@inheritdoc}
   */
  static public function create(ContainerInterface $container) {
    return new static(
      $container->get('my_service_with_wired_services')
    );
  }

  /**
   * FormWithDependencyInjection constructor.
   *
   * @param \Drupal\dependency_injection_examples\ServiceWithWiredServices $service_with_wired_services
   */
  public function __construct(ServiceWithWiredServices $service_with_wired_services) {
    $this->serviceWithWiredServices = $service_with_wired_services;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'form_with_dependency_injection';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['submit'] = [
      '#type' => 'submit',
      '#default_value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->serviceWithWiredServices->logServiceArgumentsAsMarkup();
    $this->serviceWithWiredServices->messageServiceArgumentsAsMarkup();
  }

}
