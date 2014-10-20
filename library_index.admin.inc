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
    $libraries = library_index_get_list('kyyti');
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
