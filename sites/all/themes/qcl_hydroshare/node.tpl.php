<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

    <?php
    drupal_add_js("/misc/jquery.cookie.js", 'file');
    
    //print( "<B><H3>THIS IS THE PLAIN OLD NODE FILE</H3></B>");
    if( !empty( $content ) and 
        ( strpos( $node->type, "hydroshare_" ) !== false ) ) {
        // =-=-=-=-=-=-=-
        // get the file directory         
        $data_model_file = NULL;
        data_model_get_file_from_node( $node, $data_model_file );
        $format = $data_model_file->filemime;
        
        //$real_path = drupal_realpath( $data_model_file->uri );
        $real_path = file_create_url( $data_model_file->uri );
        $data_model_dir = drupal_dirname( $real_path );
        $data_model_dir = drupal_dirname( $data_model_dir );


        if( $teaser ) {
            //print $user_picture; 
            print render($title_prefix); 
        
            // =-=-=-=-=-=-=-
            // display the viz thumbnail
            $img_dir = drupal_dirname( $data_model_file->uri );
            $img_dir = drupal_dirname( $img_dir );
            $img_url = file_create_url( $img_dir.'/thumbnail.png' );
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

                        // =-=-=-=-=-=-=-
                        // get the zip name of the directory
                        $zip_file = NULL;
                        if( data_model_zip_file_name( $data_model_dir, $zip_file ) == false ) {
                            error_log( "data_model_node_view :: data_model_zip_file_name failed for $data_model_dir" );
                            return NULL;

                        }  
                                               
                        // =-=-=-=-=-=-=-
                        // build the java script operation
                        $hostname = $_SERVER['SERVER_NAME'];
                        $op = "http://$hostname/export.php?file=" . $zip_file;
     
                        $edit_url = "http://$hostname/?q=node/" . $node->nid . "/edit";
                        $delete_url = "http://$hostname/?q=node/" . $node->nid . "/delete";
                        print( '<div class="contentListWrapper">');
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
                            print( '<table border=0 valign=top cellpadding=5>' );
				    print( '<tr style="padding-bottom: 10px">' );
				    print( '<td align=left style="padding-right: 10px"><span class="bold">Resource Type:</span></td>');
                                    print( '<td><span style="float:left">'.$type.'</span></td>');
				    print( '<td><span class="bold">Subject:</span></td><td><span style="float:left">'.$subject.'</span></td>');
				    print( '</tr><tr>' );
				    print( '<td align=left valign=top><span class="bold">Created by:</span></td>' );
				    print( '<td>' );
					    print( '<span style="float:left">'.$user->name.'</span><br>');
					    print( '<span style="float:left">'.$creator_email.'</span><br>');
					    print( '<span style="float:left">'.$creator_organization.'</span><br>');
					    print( '<span style="float:left">'.$creator_address.'</span><br>');
					    print( '<span style="float:left">'.$creator_phone_number.'</span><br>');
				    print( '</td>' );
				    print( '<td align=left valign=top style="padding-right: 10px"><span class="bold">Contributor:</span></td>' );
			            print( '<td>' );
				        print( '<span style="float:left">'.$contributor_name.'</span>');
					print( '<span style="float:left">'.$contributor_email.'</span><br>');
					print( '<span style="float:left">'.$contributor_organization.'</span><br>');
					print( '<span style="float:left">'.$contributor_address.'</span><br>');
					print( '<span style="float:left">'.$contributor_phone_number.'</span><br>');
					print( '<span style="float:left">'.$contributor_contribution.'</span><br>');
				    print( '</td>' );

				    print( '</tr><tr valign=top>' );
				    print( '<td><span class="bold">Created: </span></td>' );
				    print( '<td><span style="float:left">'.$created_date.'</span></td>');
				    print( '<td><span class="bold">References:</span></td><td><span style="float:left">'.$references.'</span></td>');
				    print( '</tr>' );
				    
				    print( '<tr valign=top><td><div class="starWrapper">');
					    print( render( $content['field_rating'] ) );
				    print('</div></td><td></td>');
				    print( '<td><span class="bold">Source: </span></td>' );
				    print( '<td>' );
					print( '<span style="float:left">'.$source_name    .'</span><br>');
					print( '<span style="float:left">'.$source_comments.'</span><br>');
					print( '<span style="float:left">'.$source_id      .'</span>');
				    print( '</td>' );
				    print( '<tr valign=top><td><span class="bold">Tags: </span></td><td>' );
				        $tags = $node->field_tags['und'];
				        foreach( $tags as $tag ) {
					    print( $tag['taxonomy_term']->name.', ');
				        }
				    print( '</td>' );
				    print( '<td><span class="bold">Rights: </span></td><td><span style="float:left">'.$rights.'</span></td></tr>');
				    print( '<tr><td><span class="bold">Format:</span></td><td><span style="float:left">'.$format.'</span></td></tr>');
                            print( '</table>' );
                        print( '</div> <!-- half-column -->' );
          
                        print('<div style="clear:both"></div>');

                        print('<div class="full-column">');
                            print( '<p><span class="bold">Coverage:</span></p>');
                            print( '<p><span style="float:left">'.$coverage_spatial.'</span></p><br>');
                            print( '<p><span style="float:left">'.$coverage_temporal.'</span></p><br>');
                            print('<h2>Resource Description</h2>');
                            print( render( $content['body'] ) );
                        print( '</div> <!-- full-column -->' );
                  
                        print( '<div class="half-column">');
                            if (!empty($content['links'])) {
                                print( ' <div class="links">' );
                                    print render($content['links']);            
                                print( '</div><!-- links -->');
                            }
                        print( '</div><!--half-column-->' );

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
