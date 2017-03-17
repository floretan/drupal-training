<?php

/**
 * @file
 * Contains organisation.page.inc.
 *
 * Page callback for Organisation entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Organisation templates.
 *
 * Default template: organisation.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_organisation(array &$variables) {
  // Fetch Organisation Entity Object.
  $organisation = $variables['elements']['#organisation'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
