<?php

namespace Drupal\example_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Organisation type entity.
 *
 * @ConfigEntityType(
 *   id = "organisation_type",
 *   label = @Translation("Organisation type"),
 *   handlers = {
 *     "list_builder" = "Drupal\example_entity\OrganisationTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\example_entity\Form\OrganisationTypeForm",
 *       "edit" = "Drupal\example_entity\Form\OrganisationTypeForm",
 *       "delete" = "Drupal\example_entity\Form\OrganisationTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\example_entity\OrganisationTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "organisation_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "organisation",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/organisation_type/{organisation_type}",
 *     "add-form" = "/admin/structure/organisation_type/add",
 *     "edit-form" = "/admin/structure/organisation_type/{organisation_type}/edit",
 *     "delete-form" = "/admin/structure/organisation_type/{organisation_type}/delete",
 *     "collection" = "/admin/structure/organisation_type"
 *   }
 * )
 */
class OrganisationType extends ConfigEntityBundleBase implements OrganisationTypeInterface {

  /**
   * The Organisation type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Organisation type label.
   *
   * @var string
   */
  protected $label;

}
