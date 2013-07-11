<?php 


/**
 * Add javascript files for front-page jquery slideshow.
 */
if (drupal_is_front_page()) {
drupal_add_js(drupal_get_path('theme', 'bluemasters') . '/js/bluemasters.js');
}

function qcl_hydroshare_form_alter(&$form, &$form_state, $form_id) {
    drupal_set_message("This is the form id : $form_id");
}

?>
