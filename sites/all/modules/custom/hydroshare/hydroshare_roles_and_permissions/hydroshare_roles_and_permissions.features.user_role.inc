<?php
/**
 * @file
 * hydroshare_roles_and_permissions.features.user_role.inc
 */

/**
 * Implements hook_user_default_roles().
 */
function hydroshare_roles_and_permissions_user_default_roles() {
  $roles = array();

  // Exported role: hydroshare author.
  $roles['hydroshare author'] = array(
    'name' => 'hydroshare author',
    'weight' => 3,
  );

  // Exported role: hydroshare manager.
  $roles['hydroshare manager'] = array(
    'name' => 'hydroshare manager',
    'weight' => 4,
  );

  return $roles;
}
