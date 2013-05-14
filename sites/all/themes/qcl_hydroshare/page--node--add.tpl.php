<section id="console">
		<?php if($page['header']): print render($page['header']); endif;?>
</section>

<div id="container">
    <!-- header -->
    <header class="ep-outline" role="banner">
        <div class="mainNav">
            <a href="<?php print base_path(); ?>" class="logo"><img src="<?php print base_path().path_to_theme();?>/images/hydroshare_logo.png" alt="HydroShare. Share and Collaborate"></a>
            
            <?php if($page['menu']): print render($page['menu']); endif; ?>
        </div>
    </header>

    <div class="subHeader">
            <h1>Create Content</h1>
            <p>Publish New Content</p>
    </div><!-- subHeader -->

    <div class="pageWrapper">
    <div class="myContentHome">
    <div class="contentListWrapper">
            <?php
                if( array_key_exists( 'content', $page ) and 
                    array_key_exists( 'system_main', $page['content'] ) and 
                    array_key_exists( 'main', $page['content']['system_main'] ) and
                    array_key_exists( "#markup", $page['content']['system_main']['main'] ) ) {
		print( '<div class="contentList">' ); 
		print( '<div class="contentTable">' ); 
		$markup = render( $page['content'] );
		$final_len = strlen( $markup ); 

		$p0 = strpos( $markup, "<dt>" );
		$p1 = strpos( $markup, "</dd>" );

		print("<table>" );
		$done = false;
		while( $done == false ) {
		   $item = substr( $markup, $p0, $p1-$p0+5 ); 
		   $is_hs = strpos( $item, "hydroshare-" );
		   if( $is_hs ) { 
		       $end_dt = strpos( $item, "</dt>" );
		       $title = substr( $item, 4, $end_dt-4 );

		       $start_dd = strpos( $item, "<dd>" );
		       $end_dd   = strpos( $item, "</dd>" );
		       $descr    = substr( $item, $start_dd+4, $end_dd-$start_dd-4 );

		       print( '<tr> <td><span class="bold">'.$title.'</span></td><td>'.$descr.'</td></p>');

		   }

		   $p0 = strpos( $markup, "<dt>", $p0+4 );
		   $p1 = strpos( $markup, "</dd>", $p1+5 );

		   if( $p0 == false or $p1 == false ) {
		       $done = true;
		   }

		} // while
		print("</table>" );

		print( '</div> <!-- contentTable -->' );
		print( '</div> <!-- contentList -->' );
                } else {
		    if($page['content']){ print (render($page['content']) ); }
		    if($page['contentbottom']){ print render($page['contentbottom']); }
		    if($page['subheader']){ print render($page['subheader']); }
		    if($page['left']){ print render($page['left']); }
		    if($page['right']){ print render($page['right']); }

                } // else
            ?>
    </div> <!-- contentListWrapper -->
    </div> <!-- myContentHome -->
    </div> <!-- pageWrapper -->
        
    </div>
</div>
<!-- footer -->
<footer>
    <?php if($page['footer']): print render($page['footer']); endif; ?>
</footer>
