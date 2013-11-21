<?php
/**
 * @file
 * hydroshare_geoanalytics.features.inc
 */

/**
 * Implements hook_node_info().
 */
function hydroshare_geoanalytics_node_info() {
  $items = array(
    'hydroshare_geoanalytics' => array(
      'name' => t('Geoanalytics'),
      'base' => 'node_content',
      'description' => t('RENCI Geoanalytics content type.  Connects HydroShare with GIS data sources.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
