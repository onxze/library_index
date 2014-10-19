<?php

/**
 * @file
 * Library directory settings form.
 *
 * Last modified: 17.10.2014 Mika Hatakka
 */

/**
 * Set fields for module settings, shown to adminitrator.
 *
 * @return array field description for settings
 */
function library_index_admin() {
  $form = array();

  $form['library_index_api'] = array(
      '#type' => 'textfield',
      '#title' => t('Library Index Api address'),
      '#default_value' => variable_get('library_index_api', ''),
      '#description' => t("Address where all Library Index Api is found."),
      '#required' => TRUE,
  );
  
  return system_settings_form($form);
}
