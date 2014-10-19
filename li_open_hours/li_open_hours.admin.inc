<?php

/**
 * @file
 * Library index Open Hours settings form.
 */

/**
 * Set fields for module settings, shown to adminitrator.
 *
 * @return array field description for settings
 */
function li_open_hours_admin() {
  $form = array();

  $form['ldb_block'] = array(
      '#type' => 'fieldset',
      '#title' => t('Library Index Open Hours settings for block')
  );
  // System content types
  $content_types = node_type_get_types();
  $ct_option = array('none' => t('Select content type'));
  foreach ($content_types as $value) {
    $ct_option[$value->type] = $value->name;
  }
  $selected_option = variable_get('lioh_content_type', 'none');
  $form['ldb_block']['lioh_content_type'] = array(
      '#title' => t('System Content types'),
      '#type' => 'select',
      '#description' => (t('Content type to which block is tied.')),
      '#options' => $ct_option,
      '#default_value' => $selected_option,
  );
  // Fields for selected content type
  if ($selected_option != 'none') {
    $ctf_option = array('none' => t('Select field'));
    $fields = field_info_instances('node', $selected_option);
    foreach ($fields as $value) {
      $ctf_option[$value['field_name']] = $value['label'];
    }
    $selected_field = variable_get('lioh_lid_field', 'none');
    $form['ldb_block']['lioh_lid_field'] = array(
        '#title' => t('Library Id field'),
        '#type' => 'select',
        '#description' => (t('Field that gives the library Id.')),
        '#options' => $ctf_option,
        '#default_value' => $selected_field,
    );
  }

  return system_settings_form($form);
}
