<?php

namespace Drupal\example_route\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 *
 * @package Drupal\example_route\Form
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'example_route.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('example_route.settings');

    $form['test'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Test'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('test'),
    ];

    $form['other'] = [
      '#type' => 'select',
      '#title' => $this->t('Select something'),
      '#default_value' => $config->get('other'),
      '#options' => [
        0 => 'No',
        1 => 'Yes',
      ]
    ];



    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('example_route.settings')
      ->set('test', $form_state->getValue('test'))
      ->set('other', $form_state->getValue('other'))
      ->save();
  }

}
