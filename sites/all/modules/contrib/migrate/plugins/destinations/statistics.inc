<?php

/**
 * @file
 * Support for node_counter statistics in core Drupal nodes.
 */

class MigrateStatisticsEntityHandler extends MigrateDestinationHandler {
  public function __construct() {
    $this->registerTypes(array('node'));
  }

  public function fields() {
    if (module_exists('statistics')) {
      $fields = array(
        'totalcount' => t('The total number of times the node has been viewed.'),
        'daycount' => t('The total number of times the node has been viewed today.'),
        'timestamp' => t('The most recent time the node has been viewed.'),
      );
    }
    else {
      $fields = array();
    }
    return $fields;
  }

  public function complete($node, stdClass $row) {
    if (module_exists('statistics') && isset($node->nid)) {
      $totalcount = is_numeric($node->totalcount) ? $node->totalcount : 0;
      $daycount = is_numeric($node->daycount) ? $node->daycount : 0;
      $timestamp = is_numeric($node->timestamp) ? $node->timestamp : 0;
      db_merge('node_counter')
        ->key(array('nid' => $node->nid))
        ->fields(array(
          'totalcount' => $totalcount,
          'daycount' => $daycount,
          'timestamp' => $timestamp,
        ))
        ->execute();
    }
  }
}
