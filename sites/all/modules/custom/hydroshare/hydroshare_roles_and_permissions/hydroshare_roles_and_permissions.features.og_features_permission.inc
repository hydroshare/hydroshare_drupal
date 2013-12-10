<?php
/**
 * @file
 * hydroshare_roles_and_permissions.features.og_features_permission.inc
 */

/**
 * Implements hook_og_features_default_permissions().
 */
function hydroshare_roles_and_permissions_og_features_default_permissions() {
  $permissions = array();

  // Exported og permission: 'node:hydroshare:add user'
  $permissions['node:hydroshare:add user'] = array(
    'roles' => array(
      'administrator member' => 'administrator member',
    ),
  );

  // Exported og permission: 'node:hydroshare:administer group'
  $permissions['node:hydroshare:administer group'] = array(
    'roles' => array(
      'administrator member' => 'administrator member',
    ),
  );

  // Exported og permission: 'node:hydroshare:approve and deny subscription'
  $permissions['node:hydroshare:approve and deny subscription'] = array(
    'roles' => array(
      'administrator member' => 'administrator member',
    ),
  );

  // Exported og permission: 'node:hydroshare:manage members'
  $permissions['node:hydroshare:manage members'] = array(
    'roles' => array(
      'administrator member' => 'administrator member',
    ),
  );

  // Exported og permission: 'node:hydroshare:manage permissions'
  $permissions['node:hydroshare:manage permissions'] = array(
    'roles' => array(
      'administrator member' => 'administrator member',
    ),
  );

  // Exported og permission: 'node:hydroshare:manage roles'
  $permissions['node:hydroshare:manage roles'] = array(
    'roles' => array(
      'administrator member' => 'administrator member',
    ),
  );

  // Exported og permission: 'node:hydroshare:subscribe'
  $permissions['node:hydroshare:subscribe'] = array(
    'roles' => array(
      'non-member' => 'non-member',
    ),
  );

  // Exported og permission: 'node:hydroshare:subscribe without approval'
  $permissions['node:hydroshare:subscribe without approval'] = array(
    'roles' => array(),
  );

  // Exported og permission: 'node:hydroshare:unsubscribe'
  $permissions['node:hydroshare:unsubscribe'] = array(
    'roles' => array(
      'member' => 'member',
    ),
  );

  // Exported og permission: 'node:hydroshare:update group'
  $permissions['node:hydroshare:update group'] = array(
    'roles' => array(
      'administrator member' => 'administrator member',
    ),
  );

  return $permissions;
}
