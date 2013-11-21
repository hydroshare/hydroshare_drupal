<?php
/**
 * @file
 * hydroshare_timeseries.features.menu_links.inc
 */

/**
 * Implements hook_menu_default_menu_links().
 */
function hydroshare_timeseries_menu_default_menu_links() {
  $menu_links = array();

  // Exported menu link: navigation_time-series:node/add/hydroshare-time-series
  $menu_links['navigation_time-series:node/add/hydroshare-time-series'] = array(
    'menu_name' => 'navigation',
    'link_path' => 'node/add/hydroshare-time-series',
    'router_path' => 'node/add/hydroshare-time-series',
    'link_title' => 'Time Series',
    'options' => array(
      'attributes' => array(
        'title' => 'Support for Time Series CSV file format following the HydroDesktop specification',
      ),
      'identifier' => 'navigation_time-series:node/add/hydroshare-time-series',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => 0,
    'customized' => 0,
    'parent_identifier' => 'navigation_add-content:node/add',
  );
  // Translatables
  // Included for use with string extractors like potx.
  t('Time Series');


  return $menu_links;
}
