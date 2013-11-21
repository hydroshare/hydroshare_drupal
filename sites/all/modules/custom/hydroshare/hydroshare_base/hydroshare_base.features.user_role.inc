<?php
/**
 * @file
 * hydroshare_base.features.user_role.inc
 */

/**
 * Implements hook_user_default_roles().
 */
function hydroshare_base_user_default_roles() {
  $roles = array();

  // Exported role: administrator.
  $roles['administrator'] = array(
    'name' => 'administrator',
    'weight' => 2,
  );

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
