<?php

/**
 * @file
 * Documentation for hooks defined by Migrate.
 */

/**
 * Registers your module as an implementor of Migrate-based classes.
 */
function hook_migrate_api() {
  $api = array(
    'api' => 2,
    'migrations' => array(
      'HookExample' => array('class_name' => 'HookExampleMigration'),
    ),
  );
  return $api;
}

/**
 * Alter information from all implementations of hook_migrate_api().
 *
 * @param array $info
 *   An array of results from hook_migrate_api(), keyed by module name.
 */
function hook_migrate_api_alter(array &$info) {
  if (isset($info['MODULE_NAME']['migrations']['HookExample'])) {
    $info['MODULE_NAME']['migrations']['HookExample']['class_name'] = 'MyBetterHookMigration';
  }
}

/**
 * Provides text to be displayed at the top of the dashboard page (migrate_ui).
 */
function hook_migrate_overview() {
  return t('<p>Listed below are all the migration processes defined for migration
    of our old site to Drupal. Open issues applying to specific migrations
    can be viewed by clicking the migration name. Also, details on how each
    migration will behave when incrementally migrated are provided.</p>
    <p><a href="http://issuetracker.example.com/?project=migration&status=open">Open migration tickets</a></p>');
}
