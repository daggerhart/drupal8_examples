<?php

namespace Drupal\most_simple\Entity;

use Drupal\Core\Entity\ContentEntityBase;

/**
 * Defines the Most Simple entity.
 *
 * @ContentEntityType(
 *   id = "most_simple",
 *   label = @Translation("Most Simple"),
 *   base_table = "most_simple",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "bundle",
 *   },
 *   fieldable = TRUE,
 *   admin_permission = "administer most_simple types",
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
 *     "access" = "Drupal\Core\Entity\EntityAccessControlHandler",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\Core\Entity\ContentEntityForm",
 *       "add" = "Drupal\Core\Entity\ContentEntityForm",
 *       "edit" = "Drupal\Core\Entity\ContentEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   links = {
 *     "canonical" = "/most_simple/{most_simple}",
 *     "add-page" = "/most_simple/add",
 *     "add-form" = "/most_simple/add/{most_simple_type}",
 *     "edit-form" = "/most_simple/{most_simple}/edit",
 *     "delete-form" = "/most_simple/{most_simple}/delete",
 *     "collection" = "/admin/content/most_simples",
 *   },
 *   bundle_entity_type = "most_simple_type",
 *   field_ui_base_route = "entity.most_simple_type.edit_form",
 * )
 */
class MostSimpleEntity extends ContentEntityBase {}
