<?php

namespace Drupal\cat_api\Form;

use Drupal\cat_api\Service\CatApiClientInterface;
use Drupal\cat_api\Service\CatBreedFactory;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SearchCatsForm.
 *
 * This demonstrates Dependency Injection into custom Drupal Forms.
 *
 * @package Drupal\cat_api\Form
 */
class SearchCatsForm extends FormBase {

  /**
   * Cat API client.
   *
   * @var \Drupal\cat_api\Service\CatApiClientInterface
   */
  private $catApiClient;

  /**
   * Cat breed factory service.
   *
   * @var \Drupal\cat_api\Service\CatBreedFactory
   */
  private $catBreedFactory;

  /**
   * SearchCatsForm constructor.
   *
   * @param \Drupal\cat_api\Service\CatApiClientInterface $cat_api_client
   * @param \Drupal\cat_api\Service\CatBreedFactory $cat_breed_factory
   */
  public function __construct(CatApiClientInterface $cat_api_client, CatBreedFactory $cat_breed_factory) {
    $this->catApiClient = $cat_api_client;
    $this->catBreedFactory = $cat_breed_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cat_api.client'),
      $container->get('cat_api.breed_factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'cat_api.search_cats';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $breed_id = NULL, int $limit = 3) {
    $form['search'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Search'),
      'breed_id' => [
        '#type' => 'select',
        '#title' => $this->t('Breed'),
        '#options' => array_merge([
          '' => $this->t('Select Breed')
        ], $this->getBreedOptions()),
        '#default_value' => $breed_id ? $breed_id : '',
        '#required' => TRUE,
      ],
      'limit' => [
        '#type' => 'select',
        '#title' => $this->t('Limit'),
        '#options' => array_combine(range(1, 5), range(1, 5)),
        '#default_value' => $limit,
      ],
      'actions' => [
        '#type' => 'actions',
        'submit' => [
          '#type' => 'submit',
          '#value' => $this->t('Search'),
        ]
      ],
    ];

    if ($breed_id) {
      $form['results'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Results'),
        'images' => $this->getImages($breed_id, $limit),
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('cat_api.search_cats_page', [
      'breed_id' => $form_state->getValue('breed_id'),
      'limit' => $form_state->getValue('limit'),
    ]);
  }

  /**
   * Get breeds as an options array.
   *
   * @return array
   */
  private function getBreedOptions() {
    $breeds = $this->catApiClient->get('breeds');
    $options = [];
    foreach ($breeds as $breed) {
      $cat_breed = $this->catBreedFactory->createFromBreedResult($breed);
      $options[$cat_breed->getId()] = $cat_breed->getName();
    }
    return $options;
  }

  /**
   * Get images for the given breed.
   *
   * @param string $breed_id
   * @param int $limit
   *
   * @return array
   */
  private function getImages($breed_id, $limit) {
    $results = $this->catApiClient->get('images/search', [
      'breed_ids' => $breed_id,
      'limit' => $limit,
    ]);

    $items = [];
    foreach ($results as $result) {
      $cat_breed = $this->catBreedFactory->createFromSearchResult($result);
      $items[] = Markup::create("<h3>{$cat_breed->getName()}</h3> {$cat_breed->getPicture()}");
    }

    return [
      '#theme' => 'item_list',
      '#items' => $items,
    ];
  }

}
