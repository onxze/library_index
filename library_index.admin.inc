<?php

/**
 * @file
 * Library directory settings form.
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

/**
 * Print library Id list.
 */
function library_index_list() {
  $form = array();
  $consortium = variable_get('library_index_consortium', '');
  $form['library_index_consortium'] = array(
      '#type' => 'textfield',
      '#title' => t('Library Index Consortium'),
      '#default_value' => $consortium,
      '#description' => t("Consortium to get library Ids."),
      '#required' => TRUE,
  );

  if (!empty($consortium)) {
    $header = array('Libarary name', 'Id');
    $rows = array();
    $libraries = library_index_get_list(variable_get('library_index_consortium', ''));
    foreach ($libraries as $value) {
      $rows[] = array($value->name->fi, $value->id);
    }
    $library_ids = theme('table', array('header' => $header, 'rows' => $rows));
    $form['contact_information'] = array(
        '#markup' => $library_ids,
    );
  }
  return system_settings_form($form);
}

/**
 * Library Index cache settings form.
 */
function library_index_cache() {
  $form = array();

  $form['li_cache_clear'] = array(
      '#type' => 'submit',
      '#value' => t('Clear Library Index cache'),
      '#submit' => array('library_index_cache_clear_submit'),
  );

  $form['library_index_cache_timeout'] = array(
      '#type' => 'textfield',
      '#title' => t('Cache timeout'),
      '#default_value' => variable_get('library_index_cache_timeout', 0),
      '#description' => t("Library Index cache timeout, hours. Time after data is again read from Kirjasto hakemisto. If 0 then no cache timeout. Cache is cleared only at system cache clear."),
      '#required' => TRUE,
  );

  return system_settings_form($form);
}

function library_index_cache_validate($form, &$form_state) {
  if (!is_numeric($form_state['values']['library_index_cache_timeout'])) {
    form_set_error('Cache timeout', t('Cache timeout has to be number between 0 - 1440.'));
  }
}

/**
 * Library Index cache clear function.
 */
function library_index_cache_clear_submit() {
  LibraryIndexApi::clearLibraryIndexCache();
  drupal_set_message(t('Library Index cache cleared.'));
}
