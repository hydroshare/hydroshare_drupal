<?php
/**
 * @file
 * hydroshare_other.features.inc
 */

/**
 * Implements hook_node_info().
 */
function hydroshare_other_node_info() {
  $items = array(
    'hydroshare_other_content' => array(
      'name' => t('Other'),
      'base' => 'node_content',
      'description' => t('This is a catch all for other resources which do not correspond to existing Hydroshare Resource Types'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
