<?php

/**
 * Provides a ctools plugin to display a spacetree visualization of clades in a panel
 */
/**
 * Plugins are described by creating a $plugin array which will be used
 * by the system that includes this file.
 */
$plugin = array(
  'title' => t('JIT Force Directed content type'),
  'description' => t('JIT Force Directed content type.'),
  'single' => TRUE,
  'content_types' => array('thejit_forcedirected_content_type'),
  'render callback' => 'thejit_forcedirected_content_type_render',
  'defaults' => array(),
  'edit form' => 'thejit_forcedirected_content_type_edit_form',
  'admin title' => 'thejit_forcedirected_content_type_admin_title',
  'admin info' => 'thejit_forcedirected_content_type_admin_info',
  'icon' => 'icon_example.png',
  'category' => array(t('JIT'), -9),
);

function thejit_forcedirected_content_type_admin_title($subtype, $conf, $context = NULL) {
  $output = t('JIT Force Directed');
  if ($conf['override_title'] && !empty($conf['override_title_text'])) {
    $output = filter_xss_admin($conf['override_title_text']);
  }
  return $output;
}

/**
 * Callback to provide administrative info (the preview in panels when building
 * a panel).
 *
 * In this case we'll render the content with a dummy argument and
 * a dummy context.
 */
function thejit_forcedirected_content_type_admin_info($subtype, $conf, $context = NULL) {
  $block = new stdClass();
  $block->title = 'JIT Force Directed';
  $block->content = sprintf("<dl><dt><strong>Override Title</strong></dt><dd>%s</dd><dt><strong>JSON data function call</strong></dt><dd>%s</dd><dt><strong>Options data function call</strong></dt><dd>%s</dd></dl>"
      , $conf['override_title'] ? $conf['override_title_text'] : 'Default'
      , $conf['json_function_name'] ? $conf['json_function_name'] : '_thejit_forcedirected_debug_generate'
      , $conf['options_function_name'] ? $conf['options_function_name'] : 'n/a'
  );
  return $block;
}

/**
 * Run-time rendering of the body of the block (content type)
 *
 * @param $subtype
 * @param $conf
 *   Configuration as done at admin time
 * @param $args
 * @param $context
 *   Context - in this case we don't have any
 *
 * @return
 *   An object with at least title and content members
 */
function thejit_forcedirected_content_type_render($subtype, $conf, $args, $context) {
  $block = new stdClass();

  $block->title = $conf['override_title'] ? $conf['override_title_text'] : 'JIT Force Directed';

  if ($conf['options_function_name']) {
    $options = call_user_func($conf['options_function_name']);
  }
  else {
    $options = array();
    $options['id'] = uniqid('thejit_fd_');
  }
  $json = call_user_func($conf['json_function_name']);
  $block->content = theme('thejit_forcedirected', $json, $options);

  return $block;
}

/**
 * 'Edit' callback for the content type.
 * This example just returns a form.
 *
 */
function thejit_forcedirected_content_type_edit_form(&$form, &$form_state) {
  $conf = $form_state['conf'];
  $form['json_function_name'] = array(
    '#type' => 'textfield',
    '#title' => t('Force Directed JSON Data function call'),
    '#size' => 50,
    '#description' => t('The function to call to retreive the JSON data to visualize.'),
    '#default_value' => $conf['json_function_name'],
    '#prefix' => '<div class="clear-block no-float">',
    '#suffix' => '</div>',
  );
  $form['options_function_name'] = array(
    '#type' => 'textfield',
    '#title' => t('Force Directed JSON Data function call'),
    '#size' => 50,
    '#description' => t('The function to call to retreive the JSON data to visualize.'),
    '#default_value' => $conf['json_function_name'],
    '#prefix' => '<div class="clear-block no-float">',
    '#suffix' => '</div>',
  );
  return $form;
}

function thejit_forcedirected_content_type_edit_form_submit(&$form, &$form_state) {
  if (!empty($form_state['values']['json_function_name'])) {
    $form_state['conf']['json_function_name'] = $form_state['values']['json_function_name'];
  }
  else {
    $form_state['conf']['json_function_name'] = '_thejit_forcedirected_debug_generate';
  }

  $form_state['conf']['options_function_name'] = $form_state['values']['options_function_name'];
}
