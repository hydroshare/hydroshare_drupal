<?php
/**
 * @file
 * Implementation of OpenLayers behavior.
 */

/**
 * Ctools plugin definition.
 */
function openlayers_openlayers_behavior_attribution_openlayers_behaviors() {
  return array(
    'title' => t('Layer Attribution'),
    'description' => t('Allows layers to provide attribution to the map if it exists.  Most third-party layer will have some sort of attribution, but this may come with the actual tiles as well.'),
    'type' => 'layer',
    'behavior' => array(
      'file' => 'openlayers_behavior_attribution.inc',
      'class' => 'openlayers_behavior_attribution',
      'parent' => 'openlayers_behavior',
    ),
  );
}
/**
 * Attribution Behavior
 */
class openlayers_behavior_attribution extends openlayers_behavior {
  /**
   * Provide initial values for options.
   */
  function options_init() {
    return array(
      'separator' => '',
    );
  }

  function js_dependency() {
    return array('OpenLayers.Control.Attribution');
  }

  function options_form($defaults = array()) {
    return array(
      'separator' => array(
        '#type' => 'textfield',
        '#title' => t('separator'),
        '#description' => t('For multiple layers that need attribution, provide a separation string.'),
        '#default_value' => (isset($defaults['separator'])) ? $defaults['separator'] : FALSE,
      ),
    );
  }

  /**
   * Render.
   */
  function render(&$map) {
    drupal_add_js(drupal_get_path('module', 'openlayers') .
      '/plugins/behaviors/openlayers_behavior_attribution.js');
    return $this->options;
  }
}
