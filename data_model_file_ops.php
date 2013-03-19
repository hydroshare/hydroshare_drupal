<?php

// =-=-=-=-=-=-=-
// build the name of the zip file for a given Data Model Directory
function data_model_zip_file_name( $dir, &$file_name ) {
    // =-=-=-=-=-=-=-
    // peel of the last dir in the path as it
    // should be our Data Model Directory
    $base = basename( $dir, "/" );
    $dir  = dirname ( $dir );

    // =-=-=-=-=-=-=-
    // build a zip file name from the base name
    $zip_file = $base . ".zip";

    // =-=-=-=-=-=-=-
    // set the outvariable with the whole path to the zip
    $file_name = $dir . "/" . $zip_file;

    return true;

} // data_model_zip_file_name

// =-=-=-=-=-=-=-
// helper fcn to recursively zip a directory
function data_model_recur_zip_dir( $source, $destination, $include_dir = false ) {

    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    if (file_exists($destination)) {
        unlink ($destination);
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }
    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        if ($include_dir) {
            $arr = explode("/",$source);
            $maindir = $arr[count($arr)- 1];

            $source = "";
            for ($i=0; $i < count($arr) - 1; $i++) { 
                $source .= '/' . $arr[$i];
            }

            $source = substr($source, 1);
            $zip->addEmptyDir($maindir);
        }

        foreach ($files as $file) {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                continue;

            $file = realpath($file);

            if (is_dir($file) === true) {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            } else if (is_file($file) === true) {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    } else if (is_file($source) === true) {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();

} // data_model_recur_zip_dir

// =-=-=-=-=-=-=-
// zip a data model directory into a bagit archive
function data_model_zip_dir( $file_name ) {
    // =-=-=-=-=-=-=-
    // get just the dir name and the name minus 
    // the zip extension ( data model dir name )
    $zip_name = basename( $file_name, ".zip" );
    $zip_dir  = dirname ( $file_name );

    // =-=-=-=-=-=-=-
    // get the current directory 
    $curr_dir = getcwd();

    // =-=-=-=-=-=-=-
    // change to that dir to add the files
    chdir( $zip_dir );

    // =-=-=-=-=-=-=-
    // recursively zip the whole directory
    $ret = data_model_recur_zip_dir( $zip_name, $file_name );
    if( ZIPARCHIVE::ER_OK != $ret ) {
        if( $arch->status != ZIPARCHIVE::ER_OK ) {
            error_log( "Failed to write files to zip\n" );
        }
    }

    // =-=-=-=-=-=-=-
    // go back to our orig dir
    chdir( $curr_dir );

    // =-=-=-=-=-=-=-
    // and... were done.
    return true;

} // data_model_zip_dir



