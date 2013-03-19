<?php

require 'data_model_file_ops.php';

$path = $_GET["file"];

// =-=-=-=-=-=-=-
// zip the data model directory to export it to
// the user per the request
if( !data_model_zip_dir( $path ) ) {
    error_log( "export.php - error in creating archive file for [$pat]" );
    return;
}

if (file_exists($path)) {
    // =-=-=-=-=-=-=- 
    // set up a file transfer for the zip file
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($path));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path));
    ob_clean();
    flush();
    readfile($path);
 
    // =-=-=-=-=-=-=- 
    // clean up the zip ( duplicate data )
    unlink( $path );  
}

