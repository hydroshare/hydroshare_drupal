<?php

include_once 'sites/all/libraries/prods/Prods.inc.php';

define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';

// need to load drupal variables since they are not loaded yet here
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

header('Content-Type: application/json');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
print( json_encode(node_type_get_names()));

