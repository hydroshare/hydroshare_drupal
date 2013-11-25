<?php

require 'data_model_file_ops.php';
include_once 'sites/all/libraries/prods/Prods.inc.php';
$path = $_GET["file"];

// TODO: is getcwd ok for finding this path? - DRUPAL_ROOT
define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';

// need to load drupal variables since they are not loaded yet here
drupal_bootstrap(DRUPAL_BOOTSTRAP_VARIABLES);

// since the path is an url - need to contruct real path
$url_parts=parse_url($path);
//$root = dirname(DRUPAL_ROOT);
$root = DRUPAL_ROOT;
$real_path = $root . $url_parts['path'];

if (!download_bagit_zip_from_irods($real_path)) {
    error_log( "export.php - error in downloading archive from iRODS for [$path]" );
}

if (file_exists($real_path)) {
    // =-=-=-=-=-=-=- 
    // set up a file transfer for the zip file
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($real_path));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($real_path));
    ob_clean();
    flush();
    readfile($real_path);
 
    // =-=-=-=-=-=-=- 
    // clean up the zip ( duplicate data )
    unlink( $real_path );  
}

function download_bagit_zip_from_irods($bagit_zip_file) {

    $host = trim(variable_get('irods_host_name'));
    $port = intval(variable_get('irods_host_port'));
    $user = trim(variable_get('irods_user_name'));
    $passwd = trim(variable_get('irods_user_password'));
    $zone = trim(variable_get('irods_host_zone'));
    $resource = trim(variable_get('irods_resource'));
    $auth_type = trim(variable_get('irods_auth_type'));

    // figure out where to get file in irods grid
    $irods_file_path = "/" . $zone . "/home/" . $user . "/" . basename($bagit_zip_file);

    // create irods account
    $account = new RODSAccount($host,
				 $port,
				 $user,
				 $passwd,
				 $zone,
				 $resource,
				 $auth_type);

    // create ProdsDir - handle to irods collection
    try {
        $irods_file = new ProdsFile($account, $irods_file_path);
    }
    catch(Exception $ex) {
        error_log("download_bagit_zip_from_irods :: caught exception while trying to create new irods file, ex=$ex->getMessage()");
        return false;
    }

    // open local file
    $local_file = fopen($bagit_zip_file, "w+");
    if ($local_file === false) {
        error_log("download_bagit_zip_from_irods :: cannot create local file to download to: $bagit_zip_file");
        return false;
    }

    // open remote file - in irods to upload to
    $irods_file->open("r", $resource);

    // read & write
    while($str = $irods_file->read(1048576)) {
	fwrite($local_file, $str);
    }

    // close both files
    $irods_file->close();
    fclose($local_file);

    return true;
}

