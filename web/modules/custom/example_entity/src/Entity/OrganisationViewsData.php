<?php

namespace Drupal\example_entity\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Organisation entities.
 */
class OrganisationViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
