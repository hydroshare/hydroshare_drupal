<?php
/**
 * @file
 * hydroshare_blocks.features.fe_block_settings.inc
 */

/**
 * Implements hook_default_fe_block_settings().
 */
function hydroshare_blocks_default_fe_block_settings() {
  $export = array();

  $export['version'] = '2.0';

  $export['block-qcl_announcements'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_announcements',
    'module' => 'block',
    'node_types' => array(),
    'pages' => 'dashboard',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'contentbottom',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => -19,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => '<none>',
    'visibility' => 1,
  );

  $export['block-qcl_banner'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_banner',
    'module' => 'block',
    'node_types' => array(),
    'pages' => '<front>',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'banner',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => 0,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => '<none>',
    'visibility' => 1,
  );

  $export['block-qcl_collaborate_right'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_collaborate_right',
    'module' => 'block',
    'node_types' => array(),
    'pages' => 'collaborate*',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'right',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => -16,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => '<none>',
    'visibility' => 1,
  );

  $export['block-qcl_collaborate_subheader'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_collaborate_subheader',
    'module' => 'block',
    'node_types' => array(),
    'pages' => 'allgroups*',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'subheader',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => 0,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => '<none>',
    'visibility' => 1,
  );

  $export['block-qcl_dashboard_right'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_dashboard_right',
    'module' => 'block',
    'node_types' => array(),
    'pages' => 'node/1',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'right',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => -15,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => '<none>',
    'visibility' => 1,
  );

  $export['block-qcl_filter_groups'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_filter_groups',
    'module' => 'block',
    'node_types' => array(),
    'pages' => 'allgroups*',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'left',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => -16,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => 'FILTER GROUPS:',
    'visibility' => 1,
  );

  $export['block-qcl_footer'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_footer',
    'module' => 'block',
    'node_types' => array(),
    'pages' => '',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'footer',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => 0,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => '<none>',
    'visibility' => 0,
  );

  $export['block-qcl_menu'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_menu',
    'module' => 'block',
    'node_types' => array(),
    'pages' => '',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'menu',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => 0,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => '<none>',
    'visibility' => 0,
  );

  $export['block-qcl_resource_reccommendations'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_resource_reccommendations',
    'module' => 'block',
    'node_types' => array(),
    'pages' => 'dashboard',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'right',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => -18,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => '<none>',
    'visibility' => 1,
  );

  $export['block-qcl_support_right'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_support_right',
    'module' => 'block',
    'node_types' => array(),
    'pages' => 'node/2',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'right',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => -14,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => '<none>',
    'visibility' => 1,
  );

  $export['block-qcl_top_links'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_top_links',
    'module' => 'block',
    'node_types' => array(),
    'pages' => '',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'header',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => 0,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => '',
    'visibility' => 0,
  );

  $export['block-qcl_user_profile'] = array(
    'cache' => -1,
    'custom' => 0,
    'machine_name' => 'qcl_user_profile',
    'module' => 'block',
    'node_types' => array(),
    'pages' => 'dashboard',
    'roles' => array(),
    'themes' => array(
      'qcl_hydroshare' => array(
        'region' => 'right',
        'status' => 1,
        'theme' => 'qcl_hydroshare',
        'weight' => -19,
      ),
      'seven' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'seven',
        'weight' => 0,
      ),
    ),
    'title' => '<none>',
    'visibility' => 1,
  );

  return $export;
}
