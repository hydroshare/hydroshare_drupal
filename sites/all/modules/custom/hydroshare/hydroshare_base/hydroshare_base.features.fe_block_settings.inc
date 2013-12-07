<?php
/**
 * @file
 * hydroshare_base.features.fe_block_settings.inc
 */

/**
 * Implements hook_default_fe_block_settings().
 */
function hydroshare_base_default_fe_block_settings() {
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
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
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
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
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
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
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
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
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
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
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
      'bartik' => array(
        'region' => 'sidebar_first',
        'status' => 1,
        'theme' => 'bartik',
        'weight' => -16,
      ),
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
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
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
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
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
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
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
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
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
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
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
    'title' => 'Top Links',
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
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
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

  $export['views--exp-allgroups-page'] = array(
    'cache' => -1,
    'custom' => 0,
    'delta' => '-exp-allgroups-page',
    'module' => 'views',
    'node_types' => array(),
    'pages' => 'allgroups*',
    'roles' => array(),
    'themes' => array(
      'bartik' => array(
        'region' => 'sidebar_first',
        'status' => 1,
        'theme' => 'bartik',
        'weight' => -15,
      ),
      'qcl_hydroshare' => array(
        'region' => 'left',
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
    'title' => 'SEARCH GROUPS:',
    'visibility' => 1,
  );

  $export['views-og_members-block_1'] = array(
    'cache' => -1,
    'custom' => 0,
    'delta' => 'og_members-block_1',
    'module' => 'views',
    'node_types' => array(),
    'pages' => 'node/9',
    'roles' => array(),
    'themes' => array(
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
      'qcl_hydroshare' => array(
        'region' => 'content',
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
    'visibility' => 1,
  );

  $export['views-og_members_admin-block_1'] = array(
    'cache' => -1,
    'custom' => 0,
    'delta' => 'og_members_admin-block_1',
    'module' => 'views',
    'node_types' => array(),
    'pages' => '',
    'roles' => array(),
    'themes' => array(
      'bartik' => array(
        'region' => '',
        'status' => 0,
        'theme' => 'bartik',
        'weight' => 0,
      ),
      'qcl_hydroshare' => array(
        'region' => '',
        'status' => 0,
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

  return $export;
}
