<?php
// $Id: views_jqfx_cycle.theme.inc $

/**
 * @file
 * Theme & preprocess functions for the Views jQFX: cycle module.
 */

/**
 * Implements template_preprocess_hook_THEMENAME().
 */
function template_preprocess_views_jqfx_cycle(&$vars) {
  $options = $vars['options'];
  $rows = $vars['rows'];
  $view = $vars['view'];
  $vss_id = $view->name . '-' . $view->current_display;
  $settings = $options['views_jqfx_cycle'];
  $skin_info = $settings['skin_info'];

  // Cast the strings into int or bool as necessary.
  $new_settings = array();
  foreach ($settings as $key => $value) {
    if (is_string($value)) {
      if (stristr($value, "\n")) {
        $value = str_replace("\n", ' ', $value);
      }
      $value = trim($value);

      if (is_numeric($value)) {
        $value = (int)$value;
      }
      elseif (strtolower($value) == 'true') {
        $value = TRUE;
      }
      elseif (strtolower($value) == 'false') {
        $value = FALSE;
      }
    }

    $new_settings[$key] = $value;
  }

  // Remove any unused advanced settings.
  foreach ($settings as $key => $value) {
    if (substr($key, 0, 13) == 'advanced_use_' && !$value) {
      $setting_name = str_replace('advanced_use_', '', $key);
      unset($new_settings[$key]);
      unset($new_settings['advanced_' . $setting_name]);
    }
  }

  $settings = array_merge(
    array(
      'num_divs' => sizeof($vars['rows']),
      'id_prefix' => '#views_jqfx_cycle_main_',
      'div_prefix' => '#views_jqfx_cycle_div_',
      'vss_id' => $vss_id,
    ),
    $new_settings
  );

  // We need to go through the current js setting values to make sure the one we
  // want to add is not already there. If it is already there then append -[num]
  // to the id to make it unique.
  $jqfx_count = 1;
  $current_settings = drupal_add_js();
  foreach ($current_settings['settings']['data'] AS $current_setting) {
    if (isset($current_setting['viewsJqfxCycle'])) {
      $current_keys = isset($current_setting['viewsJqfxCycle']) ? array_keys($current_setting['viewsJqfxCycle']) : array();
      if (stristr($current_keys[0], '#views_jqfx_cycle_main_' . $vss_id)) {
        $jqfx_count++;
      }
    }
  }

  if ($jqfx_count > 1) {
    $vss_id .= '-' . $jqfx_count;
    $settings['vss_id'] = $vss_id;
  }

  drupal_add_js(array('viewsJqfxCycle' => array('#views_jqfx_cycle_main_' . $vss_id => $settings)), 'setting');

  // Add the hoverIntent plugin.
  if (isset($settings['advanced_pagerevent']) && $settings['advanced_pagerevent'] == 'hoverIntent') {
    if (module_exists('jq')) {
      $loaded_plugins = jq_plugins();
      if (!empty($loaded_plugins['hoverIntent'])) {
        jq_add('hoverIntent');
      }
    }
    if (module_exists('hoverintent')) {
      hoverintent_add();
    }
  }

  // Enqueue any stylesheets set for the skin on this view are added.
  $skin_path = drupal_get_path('module', $skin_info['module']);
  if ($skin_info['path']) {
    $skin_path .= '/' . $skin_info['path'];
  }

  if (!empty($skin_info['stylesheets'])) {
    foreach ($skin_info['stylesheets'] as $stylesheet) {
      drupal_add_css($skin_path . '/' . $stylesheet);
    }
  }

  $hidden_elements = theme('views_jqfx_cycle_main_frame', array('view' => $view, 'rows' => $rows, 'vss_id' => $vss_id, 'mode' => $options['jqfx_type']));
  $vars['jqfx'] = theme('views_jqfx_main_section', array('id' => $vss_id, 'hidden_elements' => $hidden_elements, 'plugin' => 'views_jqfx_cycle'));

  $weight = array(
    'top' => array(),
    'bottom' => array(),
  );

  // Put our pager in the right location.
  $vars['pager_location'] = (isset($skin_info['pager_location'])) ? $skin_info['pager_location'] : $settings['pager'];
  $vars['pager'] = '';
  if ($vars['pager_location']) {
    $weight[$vars['pager_location']]['pager'] = (isset($skin_info['pager_weight'])) ? $skin_info['pager_weight'] : $settings['pager_weight'];
  }

  // Put our controls in the right location.
  // Only show controls when there is more than one result.
  $vars['controls_location'] = (isset($skin_info['controls_location'])) ? $skin_info['controls_location'] : $settings['controls'];
  $vars['controls_location'] = ($settings['num_divs'] > 1) ? $vars['controls_location'] : 0;
  $vars['controls'] = '';
  if ($vars['controls_location']) {
    $weight[$vars['controls_location']]['controls'] = (isset($skin_info['controls_weight'])) ? $skin_info['controls_weight'] : $settings['controls_weight'];
  }

  // Put our slide counter in the right location.
  $vars['slide_counter_location'] = (isset($skin_info['slide_counter_location'])) ? $skin_info['slide_counter_location'] : $settings['slide_counter'];
  $vars['slide_counter'] = '';
  if ($vars['slide_counter_location']) {
    $weight[$vars['slide_counter_location']]['slide_counter'] = (isset($skin_info['slide_counter_weight'])) ? $skin_info['slide_counter_weight'] : $settings['slide_counter_weight'];
  }

  // Build our widgets
  foreach ($weight as $location => $data) {
    // Build our top widgets
    if (!empty($data)) {
      asort($data);

      $vars[$location . '_widget_rendered'] = '';
      foreach ($data as $type => $order) {
        $vars[$type] = theme('views_jqfx_cycle_' . $type, array('vss_id' => $vss_id, 'view' => $view, 'options' => $options));
        $vars[$location . '_widget_rendered'] .= $vars[$type];
      }
    }
  }
}

/**
 * Views Jqfx: Theme the main frame wrapper.
 *
 * @ingroup themeable
 */

function template_preprocess_views_jqfx_cycle_main_frame(&$vars) {
  // Add the jqfx elements.
  $vars['attributes_array']['id'] = "views_jqfx_cycle_teaser_section_" . $vars['vss_id'];
  $vars['attributes_array']['class'] = array('views_jqfx_cycle_teaser_section', 'clearfix');

  $styles = '';
  if (isset($vars['view']->display_handler->display->display_options['style_options']['views_jqfx_cycle'])) {
    $styles = $vars['view']->display_handler->display->display_options['style_options']['views_jqfx_cycle'];
  }

  $styles_default = '';
  if (isset($vars['view']->display['default']->display_options['style_options']['views_jqfx_cycle'])) {
    $styles_default = $vars['view']->display['default']->display_options['style_options']['views_jqfx_cycle'];
  }

  // Retrive the number of items per frame
  if (isset($styles['items_per_slide']) && $styles['items_per_slide'] > 0) {
    $items_per_slide = $styles['items_per_slide'];
  }
  elseif (isset($styles_default['items_per_slide']) && $styles_default['items_per_slide'] > 0) {
    $items_per_slide = $styles_default['items_per_slide'];
  }
  else {
    $items_per_slide = 1;
  }

  $vars['items_per_slide'] = $items_per_slide;

  $items = array();
  $jqfx_count = 0;
  $rendered_rows = '';
  foreach ($vars['rows'] as $count => $item) {
    $items[] = $item;
    if (count($items) == $items_per_slide || $count == (count($rows)-1)) {
      $rendered_rows .= theme('views_jqfx_cycle_main_frame_row', array('items' => $items, 'vss_id' => $vars['vss_id'], 'count' => $jqfx_count));
      $items = array();
      $jqfx_count++;
    }
  }

  $vars['rendered_rows'] = $rendered_rows;
}

/**
 * Views Jqfx jqfx rows.
 *
 * @ingroup themeable
 */
function template_preprocess_views_jqfx_cycle_main_frame_row(&$vars) {
  $current = $vars['count'] + 1;
  $classes = array(
    'views_jqfx_cycle_slide',
    "views_jqfx_slide views-row-$current",
  );
  if ($vars['count']) {
    $classes[] = 'views_jqfx_cycle_hidden';
  }
  $classes[] = ($vars['count'] % 2) ? 'views-row-even' : 'views-row-odd';

  $vars['attributes_array']['class'] = $classes;
  $vars['attributes_array']['id'] = "views_jqfx_cycle_div_" . $vars['vss_id'] . "_" . $vars['count'];

  $vars['rendered_items'] = '';
  foreach ($vars['items'] as $item_count => $item) {
    $vars['rendered_items'] .= theme('views_jqfx_cycle_main_frame_row_item', array('item' => $item, 'item_count' => $item_count));
  }
}

function template_preprocess_views_jqfx_cycle_main_frame_row_item(&$vars) {
  $classes = array('views-row views-row-' . $vars['item_count']);
  if (!$vars['item_count']) {
    $classes[] = 'views-row-first';
  }
  if ($vars['item_count'] % 2) {
    $classes[] = 'views-row-even';
  }
  else {
    $classes[] = 'views-row-odd';
  }
  $vars['attributes_array']['class'] = $classes;
}

/**
 * The jqfx controls.
 *
 * @ingroup themeable
 */
function template_preprocess_views_jqfx_cycle_controls(&$vars) {
  $classes = array(
    'views_jqfx_cycle_controls',
    'views_jqfx_controls',
  );

  $vars['attributes_array']['class'] = $classes;
  $vars['attributes_array']['id'] = "views_jqfx_cycle_controls_" . $vars['vss_id'];

  $vars['rendered_control_previous'] = theme('views_jqfx_cycle_control_previous', array('vss_id' => $vars['vss_id'], 'view' => $vars['view'], 'options' => $vars['options']));

  $vars['rendered_control_pause'] = '';
  if ($vars['options']['views_jqfx_cycle']['timeout']) {
    $vars['rendered_control_pause'] = theme('views_jqfx_cycle_control_pause', array('vss_id' => $vars['vss_id'], 'view' => $vars['view'], 'options' => $vars['options']));
  }

  $vars['rendered_control_next'] = theme('views_jqfx_cycle_control_next', array('vss_id' => $vars['vss_id'], 'view' => $vars['view'], 'options' => $vars['options']));
}

/**
 * Views Jqfx: "previous" control.
 *
 * @ingroup themeable
 */
function template_preprocess_views_jqfx_cycle_control_previous(&$vars) {
  $vars['rendered_previous_link'] = l(t('Previous'), '#', array(
    'attributes' => array(
      'class' => array('views_jqfx_cycle_previous', 'views_jqfx_previous'),
      'id' => "views_jqfx_cycle_prev_" . $vars['vss_id'],
    ),
    'fragment' => ' ',
    'external' => TRUE,
  ));
}

/**
 * Views Jqfx: "pause" control.
 *
 * @ingroup themeable
 */
function template_preprocess_views_jqfx_cycle_control_pause(&$vars) {
  $vars['rendered_pause_link'] = l(t('Pause'), '', array(
    'attributes' => array(
      'class' => array('views_jqfx_cycle_pause', 'views_jqfx_pause'),
      'id' => "views_jqfx_cycle_playpause_" . $vars['vss_id'],
    ),
    'fragment' => ' ',
    'external' => TRUE,
  ));
}

/**
 * Views Jqfx: "next" control.
 *
 * @ingroup themeable
 */
function template_preprocess_views_jqfx_cycle_control_next(&$vars) {
  $vars['rendered_next_link'] = l(t('Next'), '#', array(
    'attributes' => array(
      'class' => array('views_jqfx_cycle_next', 'views_jqfx_next'),
      'id' => "views_jqfx_cycle_next_" . $vars['vss_id'],
    ),
    'fragment' => ' ',
    'external' => TRUE,
  ));
}

/**
 * Views Jqfx: pager.
 *
 * @ingroup themeable
 */
function theme_views_jqfx_cycle_pager($vars) {
  $output = '';
  $vss_id = $vars['vss_id'];
  $view = $vars['view'];
  $options = $vars['options'];
  // Create some attributes
  $attributes['class'] = array('views_jqfx_cycle_pager');
  $attributes['id'] = 'views_jqfx_cycle_pager_' . $vss_id;

  // Allow other modules change the output
  // Using foreach instead of module_invoke_all because module_invoke_all
  // doesn't support pass by reference.
  foreach (module_implements('views_jqfx_cycle_pager_theme') as $module) {
    $hook = $module . '_views_jqfx_cycle_pager_theme';
    $hook($output, $vss_id, $view, $options['views_jqfx_cycle'], $attributes);
  }

  return $output;
}

/**
 * Implements hook_views_jqfx_cycle_pager_theme().
 */
function views_jqfx_cycle_views_jqfx_cycle_pager_theme(&$output, $vss_id, $view, $options, $attributes) {

  switch ($options['pager_type']) {
    case 'numbered':
      $attributes['class'][] = 'views_jqfx_pager_numbered';
      $output = theme('views_jqfx_cycle_pager_numbered', array('view' => $view, 'attributes_array' => $attributes, 'options' => $options));
      break;

    case 'thumbnails':
      $attributes['class'][] = 'views_jqfx_pager_thumbnails';
      $output = theme('views_jqfx_cycle_pager_thumbnails', array('view' => $view, 'attributes_array' => $attributes, 'options' => $options));
      break;

    case 'fields':
      $output = theme('views_jqfx_cycle_pager_field', array('vss_id' => $vss_id, 'view' => $view, 'attributes_array' => $attributes, 'options' => $options));
      break;
  }
  
}

function template_preprocess_views_jqfx_cycle_pager_field(&$vars) {
  $vars['attributes_array']['class'][] = ' views_jqfx_pager_field';
  $vars['rendered_field_items'] = '';
  foreach ($vars['view']->result as $count => $node) {
    $rendered_fields = '';
    foreach ($vars['options']['pager_fields'] as $field => $use) {
      if ($use !== 0 && is_object($vars['view']->field[$field])) {
        $rendered_fields .= theme('views_jqfx_cycle_pager_field_field', array('view' => $vars['view'], 'field' => $field, 'count' => $count));
      }
    }
    $vars['rendered_field_items'] .= theme('views_jqfx_cycle_pager_field_item', array('item' => $rendered_fields, 'vss_id' => $vars['vss_id'], 'count' => $count));
  }
}

/**
 * Views Jqfx: pager item.
 *
 * @ingroup themeable
 */
function template_preprocess_views_jqfx_cycle_pager_field_item(&$vars) {
  $current = $vars['count'] + 1;
  $count = $vars['count'];
  $classes = array(
    'views_jqfx_cycle_div_pager_item',
  );
  if (!$count) {
    $classes[] = 'views_jqfx_cycle_active_pager_item';
  }
  $classes[] = ($vars['count'] % 2) ? 'views-row-even' : 'views-row-odd';

  $vars['attributes_array']['class'] = $classes;
  $vars['attributes_array']['id'] = 'views_jqfx_cycle_div_pager_item_' . $vars['vss_id'] . '_' . $vars['count'];
}

/**
 * Views Jqfx: slide counter.
 *
 * @ingroup themeable
 */
function template_preprocess_views_jqfx_cycle_slide_counter(&$vars) {
  $vars['attributes_array']['class'] = array('views_jqfx_cycle_slide_counter', 'views_jqfx_slide_counter');
  $vars['attributes_array']['id'] = "views_jqfx_cycle_slide_counter_" . $vars['vss_id'];
}
