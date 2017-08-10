<?php

namespace Drupal\most_simple\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Most Simple Type entity. A configuration entity used to manage
 * bundles for the Most Simple entity.
 *
 * @ConfigEntityType(
 *   id = "most_simple_type",
 *   label = @Translation("Most Simple Type"),
 *   bundle_of = "most_simple",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   config_prefix = "most_simple_type",
 *   config_export = {
 *     "id",
 *     "label",
 *   },
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
 *     "form" = {
 *       "default" = "Drupal\most_simple\Form\MostSimpleTypeEntityForm",
 *       "add" = "Drupal\most_simple\Form\MostSimpleTypeEntityForm",
 *       "edit" = "Drupal\most_simple\Form\MostSimpleTypeEntityForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer most_simple types",
 *   links = {
 *     "canonical" = "/admin/structure/most_simple_type/{most_simple_type}",
 *     "add-form" = "/admin/structure/most_simple_type/add",
 *     "edit-form" = "/admin/structure/most_simple_type/{most_simple_type}/edit",
 *     "delete-form" = "/admin/structure/most_simple_type/{most_simple_type}/delete",
 *     "collection" = "/admin/structure/most_simple_type",
 *   }
 * )
 */
class MostSimpleTypeEntity extends ConfigEntityBundleBase {}
