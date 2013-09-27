<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

    <?php
    drupal_add_js("/misc/jquery.cookie.js", 'file');
    if( !empty( $content ) ) {
        
      // add d3 javascript reference 
      drupal_add_js('http://d3js.org/d3.v3.js', 'external');
     
      
        // get the file directory
        $real_path = ( $node->field_file['und'][0]['uri'] ); 
        $dir = drupal_dirname( $real_path );

        if( $teaser ) {
          
            print render($title_prefix); 
        
            // =-=-=-=-=-=-=-
            // display the viz thumbnail
            $img_url = file_create_url( $dir.'/thumbnail.png' );
            $img_tag = '<a href="'.$node_url.'"><img src='.$img_url.' width=160 height=120 class=floatLeft ></a>';
            print( $img_tag );
        
            // =-=-=-=-=-=-=-
            // print the description and truncate the 
            // content to 1024 characters     
            $body = render( $content['body'] );
            print( substr( $body, 0, 1024 ) );

        } else {
            print $user_picture; 
            print render($title_prefix); 
            print( '<div class="subHeader">' );
            print( '<h1'. $title_attributes.'><a href="'.$node_url.'">'.$title.'</a></h1>');
            print('<p>Resource Details</p>
                   </div><!-- subHeader -->
            <BR><BR><BR>
            <div class="myContentSub">
                <div class="myContentSubInner">');

     
                        // ********************************
                        // * Get Model Metadata from Node *
                        // ********************************
                        $begin = $node->field_temporal_begin['und'][0]['safe_value']; 
                        $end = $node->field_temporal_end['und'][0]['safe_value']; 
                        $interval = $node->field_temporal_interval['und'][0]['safe_value']; 
                        $desc = $node->field_id_description['und'][0]['safe_value']; 
                        $version = $node->field_id_version['und'][0]['safe_value'];  
                        $create_dt = $node->field_dev_create_date['und'][0]['safe_value']; 
                        $contrib_dt = $node->field_dev_contrib_date['und'][0]['safe_value']; 
                        //$creator = $node->field_dev_creator['und'][0]['safe_value']; 
                        //$contrib = $node->field_dev_contributor['und'][0]['safe_value']; 
                        
                        // these text lists dont have 'safe_value'
                        $model_type = $node->field_id_type['und'][0]['value']; 
                        $level   = $node->field_dev_level['und'][0]['value']; 
                        

                        
      
                        // **************************
                        // * get the file directory *
                        // **************************

                        // get the zip name of the directory
                        $zip_file = file_create_url($real_path);
                        $zip_file = str_replace("http://hydroshare", ".", $zip_file);
                        $zip_file = str_replace('.local', '', $zip_file);
                        
                        // build the java script operation
                        $hostname = $_SERVER['SERVER_NAME'];
                        $op = "http://$hostname/export.php?file=" . $zip_file;
     
                        $edit_url = "http://$hostname/?q=node/" . $node->nid . "/edit";
                        $delete_url = "http://$hostname/?q=node/" . $node->nid . "/delete";
                        print( '<div class="contentListWrapper">');
                            //print( '<a href="" class="greyButton">EXECUTE</a>'); 
                            print( '<a href="" class="greyButton">SHARE</a>');
                            print( '<a href="'.$op.'" class="greyButton">EXPORT</a>');
                            print( '<a href="'.$edit_url.'" class="greyButton">EDIT</a>');
                            print( '<a href="'.$delete_url.'" class="greyButton">DELETE</a>');
                            // TODO: Add data visualization button
                        print( '</div> <!-- contentListWrapper --> ');


                        
                        
                        
                        
                        
                        //$fid =  $node->field_file['und'][0]['fid'];
                        //$f = file_load($fid);   
                        //$url = file_create_url($f->uri);
                        
                        // get the absolute path of the upload file
                        //$wrapper = file_stream_wrapper_get_instance_by_uri($f->uri);
                        //$real_path = $wrapper->realpath();
                        
                        $file = null;
                        $new_uri_path = null;
                        data_model_get_file_from_node( $node, $file );
                        
                        $title = $node->title;
                        $file_uri = $file->uri;
                        data_model_make_data_path( $title, $file_uri, $new_uri_path );
                        
                        $fid =  $node->field_file['und'][0]['fid'];
                        $f = file_load($fid);   
                        $url = file_create_url($f->uri);
                        $wrapper = file_stream_wrapper_get_instance_by_uri($file->uri);
                        $real_path = $wrapper->realpath();
                        $path_array = explode('/',$real_path);
                        
                        
                        
                        
//                        //-- Move the model into files folder
//
//                        // set the model path
//                        $model_path = join(array_slice(explode('/',$url),0,-1),'/').'/model';
//                        // TODO: Move this to hydrology_model_presave()
//                        if(!file_exists(join(array_slice($path_array,0,-1),'/').'/model')){
//                        
//                            $zip = new ZipArchive;
//                            $res = $zip->open($real_path);
//                            if ($res == TRUE){
//
//                              // get the model folder name by peeking into zip
//                              $z = zip_open($real_path);
//                              $zip_entry = zip_read($z);
//                              $model_folder = zip_entry_name($zip_entry);
//                              $model_folder = array_slice(explode('/',$model_folder),0,1);
//
//                              // create the unzip directory
//                              $unzip_dir = array_slice($path_array,0,-1);
//                              $unzip_dir = join($unzip_dir,'/');
//
//                              // extract the model contents
//                              $zip->extractTo($unzip_dir);
//                              $zip->close();
//
//                              // rename the model folder to something more standardized
//                              rename($unzip_dir.'/'.$model_folder[0], $unzip_dir.'/model');
//                              
//                            }
//                        }
                        
                        // plot model data                  
                        $render = render( $content );
                        if( strpos( $render, "hydrology_model_plot_single" ) != false ) {
                            $matches = NULL;
                            print( '<div id="hydroshare_vizualization" style="height:340px"></div>' );
                            $ret = preg_match( '/<script>hydrology_model_plot_single.*<\/script>/i', $render, $matches );
                            if( $ret ) {
                                print( $matches[0] );
                            } 
                        }
                        
                        
//                        // TODO: change the output read using listbox
//                        // read streamflow output
//                        $start_dt = datetime::createfromformat('m/d/Y H:i:s',$begin.' 00:00:00');
//                        $date = array();
//                        $values = array();
//                        $i = 1;
//                        $handle = @fopen($model_path . '/output.rch','r');
//                        if ($handle){
//                          while (($buffer = fgets($handle, 4096)) !== false){
//                            if($i >= 10){
//
//                              $name = trim(substr($buffer,0,10));                              
//                              $mon = trim(substr($buffer,22,3));
//                              $outflow = floatval(trim(substr($buffer,51,10)));
//                              
//                              // build date
//                              if ($interval == 'daily'){
//                                $dt = clone $start_dt;
//                                $dt->add(new DateInterval('P'.$mon.'D'));
//                              }
//                              
//                              // add values to array
//                              if (array_key_exists($name, $values)){
//                                array_push($values[$name]['vals'], $outflow);
//                                array_push($values[$name]['dates'],$dt);
//                              }
//                              else {
//                                $values[$name] = array();
//                                $values[$name]['vals'] = array($outflow);
//                                $values[$name]['dates'] = array($dt);
//                              }
//                              
//                              
//                            }
//                            $i++;
//                          }
//                        }
                        
//                        // Open the zip file and get the model folder name
//                        $model_folder = null;
//                        $zip = zip_open($real_path);
//                        if ($zip == TRUE){
//                          $zip_entry = zip_read($zip);
//                          $model_folder = zip_entry_name($zip_entry);
//                          zip_close($zip);
//                        }
//                        
//                        // move the unzipped file into the resource storage dir
//                        $unzip_dir = array_slice($path_array,0,-3);
//                        $unzip_dir = join($unzip_dir,'/');
//                        $d = $unzip_dir.'/'.$model_folder;
//                        $files = scandir($d);
//                        $source = $unzip_dir.'/';
//                        $destination = $real_path.'/model';
//                        if (!file_exists($destination)){
//                          mkdir($destination);
//                        }
//                        foreach($files as $file){
//                          if (in_array($file,array('.','..'))) continue;
//                          
//                          if (copy($source.$file, $destination.$file)) {
//                            $delete[] = $source.$file;
//                          }
//                        }
                        //foreach($delete as $file){
                        //  unlink($file);
                        //}
                        
                        
                        //$new_uri_path = $new_uri_path . "/data/" . drupal_basename( $file_uri );
                        //$wrapper = file_stream_wrapper_get_instance_by_uri($f->uri);
                        //$real_path = $wrapper->realpath();
                        
                        //$path_array = explode('/',$real_path);
                        //print( "<script>hydrology_model_plot('".$values."');</script>");
          
                        
                        $type    = node_type_get_name( $node ); 
                        $user = user_load(array('uid' => $node->uid));

                        print('<div style="clear:left"><br /><br /><br /></div>');

                        print( '<div class="half-column">' );
                            print( '<p><span class="bold">Resource Type:</span> '.$type.'</p>');
                            print( '<p><span class="bold">Model Type: </span>'.$model_type.'</p>');
                            print( '<p><span class="bold">Created by:</span> '.$user->name.'</p>');
                            print( '<p><span class="bold">Created: </span>'.$contrib_dt.'</p>');
                            // ratings
                            print( '<div class="starWrapper">');
                                print( render( $content['field_rating'] ) );
                            print('</div>');
                            // tags
                            $tags = $node->field_tags['und'];
                            print( '<p><span class="bold">Tags: </span>' );
                            foreach( $tags as $tag ) {
                                print( $tag['taxonomy_term']->name.', ');
                            }
                            print( '</p>' );
                        print( '</div> <!-- half-column -->' );
          
                        print( '<div class="half-column-right">' );

                         
                            print( '<p><span class="bold">Contributors: </span>'.$contrib.'</p>');
                            print( '<p><span class="bold">Model Begin: </span>'.$begin.'</p>');
                            print( '<p><span class="bold">Model End: </span>'.$end.'</p>');
                            print( '<p><span class="bold">Time Interval </span>'.$interval.'</p>');
                            print( '<p><span class="bold">Development Level: </span>'.$level.'</p>');
                            print( '<p><span class="bold">Version: </span>'.$version .'</p>');
                            print( '<p><span class="bold">Date Created: </span>'.$create_dt.'</p>');
                            print( '<p><span class="bold">Format: </span>'.'zip'.'</p>');
                        print( '</div> <!-- half-column-right -->' );
          
                        print('<div style="clear:both"></div>');

                        print('<div class="full-column">');
                            print('<h2>Resource Description</h2>');
                            //print( render( $content['body'] ) );
                            print( $desc );
                        print( '</div> <!-- full-column -->' );
                  
                        print( '<div class="half-column">');
                            if (!empty($content['links'])) {
                                print( ' <div class="links">' );
                                    print render($content['links']);            
                                print( '</div>');
                            }
                        print( '</div>' );

                    print( '</div> <!-- myContentSubInner -->');
             
              print('</div> <!-- mycontentSub -->');

              print('<div style="clear:both"></div>');
              print( render($content['comments']) ); 

        }

    } 
?>
   
</div>
