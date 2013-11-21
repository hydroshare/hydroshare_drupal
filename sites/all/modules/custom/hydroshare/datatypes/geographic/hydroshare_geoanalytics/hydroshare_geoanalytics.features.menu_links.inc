<?php
/**
 * @file
 * hydroshare_geoanalytics.features.menu_links.inc
 */

/**
 * Implements hook_menu_default_menu_links().
 */
function hydroshare_geoanalytics_menu_default_menu_links() {
  $menu_links = array();

  // Exported menu link: navigation_geoanalytics:node/add/hydroshare-geoanalytics
  $menu_links['navigation_geoanalytics:node/add/hydroshare-geoanalytics'] = array(
    'menu_name' => 'navigation',
    'link_path' => 'node/add/hydroshare-geoanalytics',
    'router_path' => 'node/add/hydroshare-geoanalytics',
    'link_title' => 'Geoanalytics',
    'options' => array(
      'attributes' => array(
        'title' => 'RENCI Geoanalytics content type.  Connects HydroShare with GIS data sources.',
      ),
      'identifier' => 'navigation_geoanalytics:node/add/hydroshare-geoanalytics',
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
  t('Geoanalytics');


  return $menu_links;
}
