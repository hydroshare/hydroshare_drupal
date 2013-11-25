<?php
/**
 * @file
 * hydroshare_timeseries.features.inc
 */

/**
 * Implements hook_node_info().
 */
function hydroshare_timeseries_node_info() {
  $items = array(
    'hydroshare_time_series' => array(
      'name' => t('Time Series'),
      'base' => 'node_content',
      'description' => t('Support for Time Series CSV file format following the HydroDesktop specification'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
