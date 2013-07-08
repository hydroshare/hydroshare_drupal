<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

    <?php
    //print( "<B><H3>THIS IS THE PLAIN OLD NODE FILE</H3></B>");
    if( !empty( $content ) and 
        ( strpos( $node->type, "hydroshare_" ) !== false ) ) {
        // =-=-=-=-=-=-=-
        // get the file directory
        $real_path = ( $node->field_file['und'][0]['uri'] ); 
        $dir = drupal_dirname( $real_path );
        $dir = drupal_dirname( $dir );

        if( $teaser ) {
            //print $user_picture; 
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
                        // =-=-=-=-=-=-=-
                        // wire up export button
                        // NOTE:: this was extraced from printing the $content variable.
                        //        there HAS to be a better way....
                        $real_path = drupal_realpath( $node->field_file['und'][0]['uri'] ); 
     
                        // =-=-=-=-=-=-=-
                        // extract the metadata and display it 
                        $creator_name = "";
                        $tmp_arr = $node->field_name;
                        if( !empty( $tmp_arr ) ) {
                            $creator_name = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $creator_email = "";
                        $tmp_arr = $node->field_email;
                        if( !empty( $tmp_arr ) ) {
                            $creator_email = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $creator_organization = "";
                        $tmp_arr = $node->field_organization;
                        if( !empty( $tmp_arr ) ) {
                            $creator_organization = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $creator_address = "";
                        $tmp_arr = $node->field_address;
                        if( !empty( $tmp_arr ) ) {
                            $creator_address = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $creator_phone_number = "";
                        $tmp_arr = $node->field_phone_number;
                        if( !empty( $tmp_arr ) ) {
                            $creator_phone_number = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $contributor_name = "";
                        $tmp_arr = $node->field_contributor_name;
                        if( !empty( $tmp_arr ) ) {
                            $contributor_name = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $contributor_email = "";
                        $tmp_arr = $node->field_contributor_email;
                        if( !empty( $tmp_arr ) ) {
                            $contributor_email = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $contributor_organization = "";
                        $tmp_arr = $node->field_contributor_organization;
                        if( !empty( $tmp_arr ) ) {
                            $contributor_organization = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $contributor_address = "";
                        $tmp_arr = $node->field_contributor_address;
                        if( !empty( $tmp_arr ) ) {
                            $contributor_address = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $contributor_phone_number = "";
                        $tmp_arr = $node->field_contributor_phone;
                        if( !empty( $tmp_arr ) ) {
                            $contributor_phone_number = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $contributor_contribution = "";
                        $tmp_arr = $node->field_contribution;
                        if( !empty( $tmp_arr ) ) {
                            $contributor_contribution = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $subject = "";
                        $tmp_arr = $node->field_subject;
                        if( !empty( $tmp_arr ) ) {
                            $subject = $tmp_arr['und'][0]['safe_value']; 
                        }
                        
                        $references = "";
                        $tmp_arr = $node->field_references;
                        if( !empty( $tmp_arr ) ) {
                            $references = $tmp_arr['und'][0]['safe_value']; 
                        }
                        
                        $source_name = "";
                        $tmp_arr = $node->field_source_name;
                        if( !empty( $tmp_arr ) ) {
                            $source_name = $tmp_arr['und'][0]['safe_value']; 
                        }
  
                        $source_comments = "";
                        $tmp_arr = $node->field_source_comments;
                        if( !empty( $tmp_arr ) ) {
                            $source_comments = $tmp_arr['und'][0]['safe_value']; 
                        }
   
                        $source_id = "";
                        $tmp_arr = $node->field_source_id;
                        if( !empty( $tmp_arr ) ) {
                            $source_id = $tmp_arr['und'][0]['safe_value']; 
                        }                     
                         
                        $rights = "";
                        $tmp_arr = $node->field_rights;
                        if( !empty( $tmp_arr ) ) {
                            $rights = $tmp_arr['und'][0]['safe_value']; 
                        }

                        $coverage_spatial = "";
                        $tmp_arr = $node->field_coverage_spatial;
                        if( !empty( $tmp_arr ) ) {
                            $coverage_spatial = $tmp_arr['und'][0]['safe_value']; 
                        }
                         
                        $coverage_temporal = "";
                        $tmp_arr = $node->field_coverage_temporal;
                        if( !empty( $tmp_arr ) ) {
                            $coverage_temporal = $tmp_arr['und'][0]['safe_value']; 
                        }            
                                  
                        $file = NULL;
                        data_model_get_file_from_node( $node, $file );
                        $format = $file->filemime;

                        // =-=-=-=-=-=-=-
                        // get the file directory
                        $dir = drupal_dirname( $real_path );
                        $dir = drupal_dirname( $dir );

                        // =-=-=-=-=-=-=-
                        // get the zip name of the directory
                        $zip_file = NULL;
                        if( data_model_zip_file_name( $dir, $zip_file ) == false ) {
                            error_log( "data_model_node_view :: data_model_zip_file_name failed for $dir" );
                            return NULL;

                        }
                        
                        // =-=-=-=-=-=-=-
                        // build the java script operation
                        $hostname = $_SERVER['SERVER_NAME'];
                        $op = "http://$hostname/export.php?file=" . $zip_file;
     
                        $edit_url = "http://$hostname/?q=node/" . $node->nid . "/edit";
                        $delete_url = "http://$hostname/?q=node/" . $node->nid . "/delete";
                        print( '<div class="contentListWrapper">');
                            print( '<a href="" class="greyButton">EXECUTE</a>');
                            print( '<a href="" class="greyButton">SHARE</a>');
                            print( '<a href="'.$op.'" class="greyButton">EXPORT</a>');
                            print( '<a href="'.$edit_url.'" class="greyButton">EDIT</a>');
                            print( '<a href="'.$delete_url.'" class="greyButton">DELETE</a>');
                        print( '</div> <!-- contentListWrapper --> ');


                        $render = render( $content );
                        if( strpos( $render, "hydroshare_vizualization" ) != false ) {
                            $matches = NULL;
                            print( '<div id="hydroshare_vizualization" style="height:340px"></div>' );
                            $ret = preg_match( '/<script>hydroshare_viz_script.*<\/script>/i', $render, $matches );
                            if( $ret ) {
                                print( $matches[0] );
                            } 
                        }

                        $type = node_type_get_name( $node ); 
                        $user = user_load(array('uid' => $node->uid));
                        $created_date = date("D, j M Y", $created);

                        print('<div style="clear:left"><br /><br /><br /></div>');

                        print( '<div class="half-column">' );
                            print( '<p><span class="bold">Resource Type:</span><span style="float:right">'.$type.'</span></p>');
                            print( '<p><span class="bold">Created by:</span><span style="float:right">'.$user->name.'</span></p>');
                            print( '<p><span style="float:right">'.$creator_email.'</span></p><br>');
                            print( '<p><span style="float:right">'.$creator_organization.'</span></p><br>');
                            print( '<p><span style="float:right">'.$creator_address.'</span></p><br>');
                            print( '<p><span style="float:right">'.$creator_phone_number.'</span></p><br>');
                            print( '<p><span class="bold">Created: </span>'.$created_date.'</p>');
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
                            print( '<p><span class="bold">Contributor:</span><span style="float:right">'.$contributor_name.'</span></p>');
                            print( '<p><span style="float:right">'.$contributor_email.'</span></p><br>');
                            print( '<p><span style="float:right">'.$contributor_organization.'</span></p><br>');
                            print( '<p><span style="float:right">'.$contributor_address.'</span></p><br>');
                            print( '<p><span style="float:right">'.$contributor_phone_number.'</span></p><br>');
                            print( '<p><span style="float:right">'.$contributor_contribution.'</span></p><br>');

                            print( '<p><span class="bold">Subject:</span><span style="float:right">'.$subject.'</span></p>');
                            print( '<p><span class="bold">References:</span><span style="float:right">'.$references.'</span></p>');
                            print( '<p><span class="bold">Source: </span><span style="float:right">'.$source_name.'</span></p>');
                            print( '<p><span style="float:right">'.$source_comments.'</span></p><br>');
                            print( '<p><span style="float:right">'.$source_id.'</span></p><br>');
                            #print( '<p><span class="bold">Relation: </span><span style="float:right">'.$relation.'</span></p>');
                            print( '<p><span class="bold">Rights: </span><span style="float:right">'.$rights.'</span></p>');
                            print( '<p><span class="bold">Coverage:</span></p>');
                            print( '<p><span style="float:right">'.$coverage_spatial.'</span></p><br>');
                            print( '<p><span style="float:right">'.$coverage_temporal.'</span></p><br>');
                            print( '<p><span class="bold">Format:</span><span style="float:right">'.$format.'</span></p>');
                        print( '</div> <!-- half-column-right -->' );
          
                        print('<div style="clear:both"></div>');

                        print('<div class="full-column">');
                            print('<h2>Resource Description</h2>');
                            print( render( $content['body'] ) );
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

        } // else if $teaser

    } else {
	  print( '<div class = "content clearfix">');// . $content_attributes.' >');
	      print( render( $content[ 'comments' ] ) ); 
	  print( '</div>' );

	  print( render($title_suffix) );
          print( '<div class="content clearfix">');// . $content_attributes . ' >');
              //if( !empty( $content['comments'] ) {
	      //    print( hide($content['comments']) );
              //}
              //if( !empty( $content['links'] ) {
	      //    print( hide($content['links']) );
              //}
	      print( render($content) );
	  print( '</div>' );

	  print( '<div class="clearfix">');
	      if (!empty($content['links'])) { 
	           print( ' <div class="links">' );
                   print render($content['links']); 
                   print( '</div>');
	      }

	      print( render($content['comments']) ); 
	  print( '</div>' );

    } 
?>
   
</div>
