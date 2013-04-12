<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print $user_picture; ?>

  <?php print render($title_prefix); ?>

    <div class="subHeader">
        <h1<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h1>
        <p>Resource Details</p>
    </div>
<BR><BR><BR>
        <div class="myContentSub">
            <div class="myContentSubInner">
                <?php
                    // =-=-=-=-=-=-=-
                    // wire up export button
                    // NOTE:: this was extraced from printing the $content variable.
                    //        there HAS to be a better way....
                    $real_path = drupal_realpath( $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_file['und'][0]['uri'] ); 
                    
                    
                    // =-=-=-=-=-=-=-
                    // extract the metadata and display it 
                    $contrib = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_contributor['und'][0]['safe_value']; 
                    $subject = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_subject['und'][0]['safe_value']; 
                    $relation = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_relation['und'][0]['safe_value']; 
                    $source = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_source['und'][0]['safe_value']; 
                    $type = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_type['und'][0]['safe_value']; 
                    $coverage = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_coverage['und'][0]['safe_value']; 
                    $rights = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_rights['und'][0]['safe_value']; 
                    $format = $content[ 'comments' ][ 'comment_form' ][ '#node' ]->field_format['und'][0]['safe_value']; 

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
 
                    $edit_url = "http://$hostname/?q=node/" . $content[ 'comments' ][ 'comment_form' ][ '#node' ]->nid . "/edit";
                    print( '<div class="contentListWrapper">');
                        print( '<a href="" class="greyButton">EXECUTE</a>');
                        print( '<a href="" class="greyButton">SHARE</a>');
                        print( '<a href="'.$op.'" class="greyButton">EXPORT</a>');
                        print( '<a href="'.$edit_url.'" class="greyButton">EDIT</a>');
                        print( '<a href="" class="greyButton">DELETE</a>');
                    print( '</div> <!-- contentListWrapper --> ');


                    $render = render( $content );
                    $matches = NULL;
                    print( '<div id="hydroshare_vizualization"></div>' );
                    $ret = preg_match( '/<script>render_single_time_series.*<\/script>/i', $render, $matches );
                    if( $ret ) {
                        print( $matches[0] );
                    } 

                    $pos0 = strpos( $submitted, "Submitted by " );
                    $pos1 = strpos( $submitted, " on " );

                    $type    = "Time Series";
                    $author  = substr( $submitted, $pos0, $pos1 - $pos0 );
                    $created = substr( $submitted, $pos1, strlen( $submitted ) - $pos1 );
                    print( '<BR><BR>' );
                    print( '<div class="half-column">' );
                        print( '<p><span class="bold">Resource Type:</span> '.$type.'</p>');
                        print( '<p><span class="bold">Created by:</span> '.$author.'</p>');
                        print( '<p><span class="bold">Created: </span>'.$created.'</p>');
                    print( '</div> <!-- half-column -->' );
                    print( '<div class="half-column-right">' );
                        print( '<p><span class="bold">Contributors: </span>'.$contrib.'</p>');
                        print( '<p><span class="bold">Subject: </span>'.$subject.'</p>');
                        print( '<p><span class="bold">Relation: </span>'.$relation.'</p>');
                        print( '<p><span class="bold">Source: </span>'.$source.'</p>');
                        print( '<p><span class="bold">Type: </span>'.$type.'</p>');
                        print( '<p><span class="bold">Coverage: </span>'.$coverage.'</p>');
                        print( '<p><span class="bold">Rights: </span>'.$rights.'</p>');
                        print( '<p><span class="bold">Format: </span>'.$format.'</p>');
                    print( '</div> <!-- half-column -->' );
                ?>


                <div class="full-column">
                    <div class="starWrapper">
                        <?php print( render( $content['field_rating'] ) ); ?>
                    </div>
                    <h2>Resource Description</h2>
                    <?php print( render( $content['body'] ) ); ?>
                </div> <!-- full-column -->

            </div> <!-- myContentSubInner -->

        </div> <!-- mycontentSub -->


<!--
  <div class = "content clearfix"<?php print $content_attributes; ?>>
      <?php print( render( $content[ 'comments' ] ) ); ?>
  </div>

  <?php print render($title_suffix); ?>
  <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      hide($content['comments']);
      hide($content['links']);
      print render($content);
    ?>
  </div>

  <div class="clearfix">
    <?php if (!empty($content['links'])): ?>
      <div class="links"><?php print render($content['links']); ?></div>
    <?php endif; ?>

    <?php print render($content['comments']); ?>
  </div>
-->
</div>
