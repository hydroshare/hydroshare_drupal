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

                        
                        //******************
                        //* Add Model Plot *
                        //******************
                        
                        $render = render( $content );
                        if( strpos( $render, "hydrology_model_plot_single" ) != false ) {
                            $matches = NULL;
                            print( '<div id="hydroshare_vizualization" style="height:340px"></div>' );
                            $ret = preg_match( '/<script>hydrology_model_plot_single.*<\/script>/i', $render, $matches );
                            if( $ret ) {
                                print( $matches[0] );
                            } 
                        }
          
                        $type    = node_type_get_name( $node ); 
                        $user = user_load(array('uid' => $node->uid));

                        
                        //************************
                        //* Add Metadata to Page *
                        //************************
                        
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
