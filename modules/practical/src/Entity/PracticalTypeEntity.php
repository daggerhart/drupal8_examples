<?php

namespace Drupal\practical\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Practical Type entity. A configuration entity used to manage
 * bundles for the Practical entity.
 *
 * @ConfigEntityType(
 *   id = "practical_type",
 *   label = @Translation("Practical Type"),
 *   bundle_of = "practical",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   config_prefix = "practical_type",
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *   },
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\practical\PracticalTypeListBuilder",
 *     "form" = {
 *       "default" = "Drupal\practical\Form\PracticalTypeEntityForm",
 *       "add" = "Drupal\practical\Form\PracticalTypeEntityForm",
 *       "edit" = "Drupal\practical\Form\PracticalTypeEntityForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer practical types",
 *   links = {
 *     "canonical" = "/admin/structure/practical_type/{practical_type}",
 *     "add-form" = "/admin/structure/practical_type/add",
 *     "edit-form" = "/admin/structure/practical_type/{practical_type}/edit",
 *     "delete-form" = "/admin/structure/practical_type/{practical_type}/delete",
 *     "collection" = "/admin/structure/practical_type",
 *   }
 * )
 */
class PracticalTypeEntity extends ConfigEntityBundleBase implements PracticalTypeEntityInterface {

  /**
   * The machine name of the practical type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the practical type.
   *
   * @var string
   */
  protected $label;

  /**
   * A brief description of the practical type.
   *
   * @var string
   */
  protected $description;
  
  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

}
