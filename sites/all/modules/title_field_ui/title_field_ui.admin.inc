<?php

function title_field_ui_edit_form($form, &$form_state, $entity_type, $bundle) {
  $title_field = title_field_ui_load($entity_type, $bundle);
  $admin_path = _field_ui_bundle_admin_path($entity_type, $bundle);

  $breadcrumb = drupal_get_breadcrumb();
  $entity_info = entity_get_info($entity_type);
  $breadcrumb[] = l($entity_info['bundles'][$bundle]['label'], $admin_path);
  $breadcrumb[] = l(t('Manage fields'), $admin_path . '/fields');
  drupal_set_breadcrumb($breadcrumb);

  if (!empty($title_field['label'])) {
    drupal_set_title($title_field['label']);
  }

  // Build the configurable instance values.
  $form['label'] = array(
    '#type' => 'textfield',
    '#title' => t('Label'),
    '#default_value' => !empty($title_field['label']) ? $title_field['label'] : 'Title',
    '#required' => TRUE,
  );
  $form['description'] = array(
    '#type' => 'textarea',
    '#title' => t('Help text'),
    '#default_value' => !empty($title_field['description']) ? $title_field['description'] : '',
    '#rows' => 5,
    '#description' => t('Instructions to present to the user below this field on the editing form.<br />Allowed HTML tags: @tags', array('@tags' => _field_filter_xss_display_allowed_tags())),
  );
  $form['size'] = array(
    '#type' => 'textfield',
    '#title' => t('Size of textfield'),
    '#default_value' => isset($title_field['size']) ? $title_field['size'] : 60,
    '#required' => TRUE,
    '#element_validate' => array('_element_validate_integer_positive'),
    '#size' => 3,
  );

  $form['#entity_type'] = $entity_type;
  $form['#bundle'] = $bundle;

  $form['actions'] = array('#type' => 'actions');
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
  );
  $form['actions']['cancel'] = array(
    '#type' => 'link',
    '#href' => $admin_path . '/fields',
    '#title' => t('Cancel'),
  );
  return $form;
}

function title_field_ui_edit_form_submit($form, &$form_state) {
  $title_field = array_intersect_key($form_state['values'], drupal_map_assoc(array('label', 'description', 'size')));
  $entity_type = $form['#entity_type'];
  $bundle = $form['#bundle'];
  title_field_ui_save($entity_type, $bundle, $title_field);

  $form_state['redirect'] = title_field_ui_next_destination($entity_type, $bundle);
}

function title_field_ui_disable_form($form, &$form_state, $entity_type, $bundle) {
  $title_field = title_field_ui_load($entity_type, $bundle);
  $admin_path = _field_ui_bundle_admin_path($entity_type, $bundle);

  $breadcrumb = drupal_get_breadcrumb();
  $entity_info = entity_get_info($entity_type);
  $breadcrumb[] = l($entity_info['bundles'][$bundle]['label'], $admin_path);
  $breadcrumb[] = l(t('Manage fields'), $admin_path . '/fields');
  $breadcrumb[] = $breadcrumb[4];
  unset($breadcrumb[4]);
  drupal_set_breadcrumb($breadcrumb);

  $form['entity_type'] = array(
    '#type' => 'value',
    '#value' => $entity_type,
  );
  $form['bundle'] = array(
    '#type' => 'value',
    '#value' => $bundle,
  );

  return confirm_form(
    $form,
    t('Are you sure you want to disable the title field?'),
    $admin_path . '/fields',
    t('Existing title data will be kept but the form element will be disabled.'),
    t('Disable')
  );
}

function title_field_ui_disable_form_submit($form, &$form_state) {
  $entity_type = $form_state['values']['entity_type'];
  $bundle = $form_state['values']['bundle'];
  title_field_ui_disable($entity_type, $bundle);
  $admin_path = _field_ui_bundle_admin_path($entity_type, $bundle);
  $form_state['redirect'] = title_field_ui_get_destinations(array($admin_path . '/fields'));
}

function title_field_ui_next_destination($entity_type, $bundle) {
  $destinations = !empty($_REQUEST['destinations']) ? $_REQUEST['destinations'] : array();
  if (!empty($destinations)) {
    unset($_REQUEST['destinations']);
    return title_field_ui_get_destinations($destinations);
  }
  $admin_path = _field_ui_bundle_admin_path($entity_type, $bundle);
  return $admin_path . '/fields';
}

function title_field_ui_get_destinations($destinations) {
  $path = array_shift($destinations);
  $options = drupal_parse_url($path);
  if ($destinations) {
    $options['query']['destinations'] = $destinations;
  }
  return array($options['path'], $options);
}
