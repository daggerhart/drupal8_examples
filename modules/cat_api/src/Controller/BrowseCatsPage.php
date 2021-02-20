<?php

namespace Drupal\cat_api\Controller;

use Drupal\cat_api\Service\CatApiClientInterface;
use Drupal\cat_api\Service\CatBreedFactory;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Link;
use Drupal\Core\Render\Markup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class SearchPage.
 *
 * This demonstrates Dependency Injection in a Controller.
 *
 * @package Drupal\cat_api\Controller
 */
class BrowseCatsPage implements ContainerInjectionInterface {

  /**
   * Cat Api Client.
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
   * Current request.
   *
   * @var \Symfony\Component\HttpFoundation\Request|null
   */
  private $request;

  /**
   * SearchPage constructor.
   *
   * @param \Drupal\cat_api\Service\CatApiClientInterface $cat_api_client
   * @param \Drupal\cat_api\Service\CatBreedFactory $cat_breed_factory
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   */
  public function __construct(CatApiClientInterface $cat_api_client, CatBreedFactory $cat_breed_factory, RequestStack $request_stack) {
    $this->catApiClient = $cat_api_client;
    $this->catBreedFactory = $cat_breed_factory;
    $this->request = $request_stack->getCurrentRequest();
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cat_api.client'),
      $container->get('cat_api.breed_factory'),
      $container->get('request_stack')
    );
  }

  /**
   * Handle the cat browser page route.
   *
   * @param null $breed_id
   *
   * @return array
   */
  public function page($breed_id = NULL) {
    if (empty($breed_id)) {
      return $this->getBreedLinks();
    }

    return [
      'back' => [
        '#markup' => Link::createFromRoute('Back', 'cat_api.browse_cats_page')->toString(),
      ],
      'details' => $this->getBreedDetails($breed_id),
    ];
  }

  /**
   * Get a list of links for all breeds.
   *
   * @return array
   */
  private function getBreedLinks() {
    $breeds = $this->catApiClient->get('breeds');
    $links = [];
    foreach ($breeds as $breed) {
      $links[] = Link::createFromRoute($breed['name'], 'cat_api.browse_cats_page', ['breed_id' => $breed['id']]);
    }
    return [
      '#theme' => 'item_list',
      '#items' => $links,
    ];
  }

  /**
   * Get details about a specific cat breed.
   *
   * @param string $breed_id
   *
   * @return array[]
   */
  private function getBreedDetails(string $breed_id) {
    $results = $this->catApiClient->get('images/search', [
      'breed_ids' => $breed_id,
    ]);

    $cat_breed = $this->catBreedFactory->createFromSearchResult($results[0]);

    return [
      'name' => [
        '#type' => 'html_tag',
        '#tag' => 'h2',
        '#value' => $cat_breed->getName(),
      ],
      'details' => [
        '#theme' => 'item_list',
        '#items' => [
          Markup::create("<strong>Temperament</strong>: {$cat_breed->getTemperament()}"),
          Markup::create("<strong>Description</strong>: {$cat_breed->getDescription()}"),
        ],
      ],
      'image' => [
        '#markup' => $cat_breed->getPicture(),
      ],
    ];
  }

}
