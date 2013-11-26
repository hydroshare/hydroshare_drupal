<?php

/**
 * @file
 * Hooks provided by the rest_auth module.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Implements hook_rest_auth_user_alter().
 *
 * Provides a way to modify the user account information before it is saved to
 * the database.
 *
 * @param $info
 *   User information array
 * @param $data
 *   Data from response JSON object
 * @param $context
 *   Contains user object when updating an existing user
 */
function hook_rest_auth_user_alter(&$info, $data, $context) {
  // Set user's signature
  $info['signature'] = $data['user']['sig'];
  $info['signature_format'] = 'filtered_html';
}

/**
 * @} End of "addtogroup hooks".
 */
