<?php
/**
 * @file
 * hydroshare_timeseries.features.user_permission.inc
 */

/**
 * Implements hook_user_default_permissions().
 */
function hydroshare_timeseries_user_default_permissions() {
  $permissions = array();

  // Exported permission: 'create hydroshare_time_series content'.
  $permissions['create hydroshare_time_series content'] = array(
    'name' => 'create hydroshare_time_series content',
    'roles' => array(
      'hydroshare author' => 'hydroshare author',
      'hydroshare manager' => 'hydroshare manager',
    ),
    'module' => 'node',
  );

  // Exported permission: 'delete any hydroshare_time_series content'.
  $permissions['delete any hydroshare_time_series content'] = array(
    'name' => 'delete any hydroshare_time_series content',
    'roles' => array(),
    'module' => 'node',
  );

  // Exported permission: 'delete own hydroshare_time_series content'.
  $permissions['delete own hydroshare_time_series content'] = array(
    'name' => 'delete own hydroshare_time_series content',
    'roles' => array(
      'hydroshare author' => 'hydroshare author',
      'hydroshare manager' => 'hydroshare manager',
    ),
    'module' => 'node',
  );

  // Exported permission: 'edit any hydroshare_time_series content'.
  $permissions['edit any hydroshare_time_series content'] = array(
    'name' => 'edit any hydroshare_time_series content',
    'roles' => array(),
    'module' => 'node',
  );

  // Exported permission: 'edit own hydroshare_time_series content'.
  $permissions['edit own hydroshare_time_series content'] = array(
    'name' => 'edit own hydroshare_time_series content',
    'roles' => array(
      'hydroshare author' => 'hydroshare author',
      'hydroshare manager' => 'hydroshare manager',
    ),
    'module' => 'node',
  );

  return $permissions;
}
