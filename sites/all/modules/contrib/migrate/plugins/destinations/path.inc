<?php

/**
 * @file
 * Support for paths in core Drupal objects
 */

class MigratePathEntityHandler extends MigrateDestinationHandler {
  public function __construct() {
    $this->registerTypes(array('entity'));
  }

  public function fields($entity_type, $bundle) {
    if (module_exists('path')) {
      return array('path' => t('Path alias'));
    }
    return array();
  }

  public function prepare($entity, stdClass $row) {
    if (module_exists('path') && isset($entity->path)) {
      // Make sure the alias doesn't already exist
      $query = db_select('url_alias')
        ->condition('alias', $entity->path);
      $query->addExpression('1');
      $query->range(0, 1);
      if (!$query->execute()->fetchField()) {
        $path = $entity->path;
        $entity->path = array();
        $entity->path['alias'] = $path;
      }
      else {
        unset($entity->path);
      }
    }
  }
}
