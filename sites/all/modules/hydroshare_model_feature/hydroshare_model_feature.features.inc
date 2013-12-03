<?php
/**
 * @file
 * hydroshare_model_feature.features.inc
 */

/**
 * Implements hook_node_info().
 */
function hydroshare_model_feature_node_info() {
  $items = array(
    'hydroshare_hydrology_model' => array(
      'name' => t('Model'),
      'base' => 'node_content',
      'description' => t('This is a generic hydrology model resource type'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
