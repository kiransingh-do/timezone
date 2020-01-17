<?php

namespace Drupal\timezone\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure form for location.
 */
class TimeZoneConfigForm extends ConfigFormBase {

  /**
   * Get editable config names of location.
   */
  protected function getEditableConfigNames() {
    return ['time_zone.settings'];
  }

  /**
   * Returns the form’s unique ID.
   */
  public function getFormId() {
    return 'timezone_form';
  }

  /**
   * Build form for Date-time wrt to timezone configurations.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('time_zone.settings');
    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country'),
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city'),
    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Select Timezone'),
      '#default_value' => $config->get('timezone'),
      '#options' => [
        'America/Chicago' => t('America/Chicago'),
        'Europe/London' => t('Europe/London'),
        'America/New_York' => t('America/New_York'),
        'Asia/Tokyo'  => t('Asia/Tokyo'),
        'Asia/Dubai' => t('Asia/Dubai'),
        'Asia/Kolkata' => t('Asia/Kolkata'),
        'Europe/Amsterdam' => t('Europe/Amsterdam'),
        'Europe/Oslo' => t('Europe/Oslo'),
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Submit form for location config.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('time_zone.settings')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
    parent::submitForm($form, $form_state);
    drupal_flush_all_caches();
  }

}
