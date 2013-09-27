<?php
// $Id$

/**
 * @file
 * The theme system, which controls the output of views jqfx.
 *
 * This just adds a wrapper div to the jqfx.
 */

/**
 * The current element of the jqfx.
 *
 * @ingroup themeable
 */
function theme_views_jqfx_main_section($variables) {
  $attributes['id'] = "{$variables['plugin']}_main_{$variables['id']}";
  $attributes['class'] = array("{$variables['plugin']}_main views", "jqfx_main");
  $attributes = drupal_attributes($attributes);

  return "<div$attributes>{$variables['hidden_elements']}</div>";
}
