<?php

namespace Drupal\example_widget\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\OptionsSelectWidget;
use Drupal\Core\Form\FormStateInterface;


/**
 * Custom plugin implementation of the 'options_select' widget.
 *
 * @FieldWidget(
 *   id = "my_options_select",
 *   label = @Translation("My custom Select list"),
 *   field_types = {
 *     "entity_reference",
 *     "list_integer",
 *     "list_float",
 *     "list_string"
 *   },
 *   multiple_values = TRUE
 * )
 */
class MyOptionsSelectWidget extends OptionsSelectWidget {

  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $build = parent::formElement($items, $delta, $element, $form, $form_state);

    $build['#description'] = $this->t('Enter something here');

    return $build;
  }
}