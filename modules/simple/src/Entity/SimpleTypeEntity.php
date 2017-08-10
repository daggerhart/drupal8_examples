<?php

namespace Drupal\simple\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Simple Type entity. A configuration entity used to manage
 * bundles for the Simple entity.
 *
 * @ConfigEntityType(
 *   id = "simple_type",
 *   label = @Translation("Simple Type"),
 *   bundle_of = "simple",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   config_prefix = "simple_type",
 *   config_export = {
 *     "id",
 *     "label",
 *   },
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\simple\SimpleTypeListBuilder",
 *     "form" = {
 *       "default" = "Drupal\simple\Form\SimpleTypeEntityForm",
 *       "add" = "Drupal\simple\Form\SimpleTypeEntityForm",
 *       "edit" = "Drupal\simple\Form\SimpleTypeEntityForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer simple types",
 *   links = {
 *     "canonical" = "/admin/structure/simple_type/{simple_type}",
 *     "add-form" = "/admin/structure/simple_type/add",
 *     "edit-form" = "/admin/structure/simple_type/{simple_type}/edit",
 *     "delete-form" = "/admin/structure/simple_type/{simple_type}/delete",
 *     "collection" = "/admin/structure/simple_type",
 *   }
 * )
 */
class SimpleTypeEntity extends ConfigEntityBundleBase {}
