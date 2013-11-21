<?php

/**
 * @file
 * This file is included by the agrovoc taxonomy module
 * 
 */

/**
 * Helper function for autocompletion
 */

function agrovoc_taxonomy_autocomplete($field_name, $tags_typed = '') {
  global $language;
  $field = field_info_field($field_name);

  // The user enters a comma-separated list of tags. We only autocomplete the last tag.
  $tags_typed = drupal_explode_tags($tags_typed);
  $tag_last = drupal_strtolower(array_pop($tags_typed));

  $matches = array();
  if ($tag_last != '') {

    // Part of the criteria for the query come from the field's own settings.
    $vids = array();
    $vocabularies = taxonomy_vocabulary_get_names();
    foreach ($field['settings']['allowed_values'] as $tree) {
      $vids[] = $vocabularies[$tree['vocabulary']]->vid;
    }

    $query = db_select('taxonomy_term_data', 't');
    $query->addTag('translatable');
    $query->addTag('term_access');

    // Do not select already entered terms.
    if (!empty($tags_typed)) {
      $query->condition('t.name', $tags_typed, 'NOT IN');
    }
    // Select rows that match by term name.
    $tags_return = $query
      ->fields('t', array('tid', 'name'))
      ->condition('t.vid', $vids)
      ->condition('t.name', '%' . db_like($tag_last) . '%', 'LIKE')
      ->range(0, 10)
      ->execute()
      ->fetchAllKeyed();

    $prefix = count($tags_typed) ? implode(', ', $tags_typed) . ', ' : '';
    
    $term_matches = array();
    
    if (strlen($tag_last) >= 3) {
      $vocabulary = taxonomy_vocabulary_load($vids[0]);
      if ($vocabulary->agrovoc) {
        // Fetch results from the agrovoc
        $mode = 'starting';
        if ($vocabulary->agrovoc_containing) {
          $mode = 'containing';
        }
        // Search the agrovoc
        $agrovoc_result = agrovoc_api_simple_search_by_mode2($tag_last, $mode, ',', TRUE, 10, $language->language);
        foreach ($agrovoc_result as $term) {
          $n = $term['term'];
          // Commas and quotes in terms are special cases, so encode 'em.
          if (strpos($term['term'], ',') !== FALSE || strpos($term['term'], '"') !== FALSE) {
            $n = '"'. str_replace('"', '""', $term['term']) .'"';
          }
          $term_matches[$prefix . $n] = check_plain($term['term']);
        }
      }
    }

    foreach ($tags_return as $tid => $name) {
      $n = $name;
      // Term names containing commas or quotes must be wrapped in quotes.
      if (strpos($name, ',') !== FALSE || strpos($name, '"') !== FALSE) {
        $n = '"' . str_replace('"', '""', $name) . '"';
      }
      else {
        $term_matches[$prefix . $n] = check_plain($name);
      }
    }
  }

  drupal_json_output($term_matches);
}

