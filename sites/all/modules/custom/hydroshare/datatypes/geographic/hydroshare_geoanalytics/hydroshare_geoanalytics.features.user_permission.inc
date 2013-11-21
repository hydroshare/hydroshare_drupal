<?php
/**
 * @file
 * hydroshare_geoanalytics.features.user_permission.inc
 */

/**
 * Implements hook_user_default_permissions().
 */
function hydroshare_geoanalytics_user_default_permissions() {
  $permissions = array();

  // Exported permission: 'create hydroshare_geoanalytics content'.
  $permissions['create hydroshare_geoanalytics content'] = array(
    'name' => 'create hydroshare_geoanalytics content',
    'roles' => array(
      'hydroshare author' => 'hydroshare author',
      'hydroshare manager' => 'hydroshare manager',
    ),
    'module' => 'node',
  );

  // Exported permission: 'delete any hydroshare_geoanalytics content'.
  $permissions['delete any hydroshare_geoanalytics content'] = array(
    'name' => 'delete any hydroshare_geoanalytics content',
    'roles' => array(),
    'module' => 'node',
  );

  // Exported permission: 'delete own hydroshare_geoanalytics content'.
  $permissions['delete own hydroshare_geoanalytics content'] = array(
    'name' => 'delete own hydroshare_geoanalytics content',
    'roles' => array(
      'hydroshare author' => 'hydroshare author',
    ),
    'module' => 'node',
  );

  // Exported permission: 'edit any hydroshare_geoanalytics content'.
  $permissions['edit any hydroshare_geoanalytics content'] = array(
    'name' => 'edit any hydroshare_geoanalytics content',
    'roles' => array(),
    'module' => 'node',
  );

  // Exported permission: 'edit own hydroshare_geoanalytics content'.
  $permissions['edit own hydroshare_geoanalytics content'] = array(
    'name' => 'edit own hydroshare_geoanalytics content',
    'roles' => array(
      'hydroshare author' => 'hydroshare author',
      'hydroshare manager' => 'hydroshare manager',
    ),
    'module' => 'node',
  );

  return $permissions;
}
