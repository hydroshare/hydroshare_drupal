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
            <p>Select a content type to create</p>
    </div><!-- subHeader -->
                            
    <div class="pageWrapper">
            <?php

                print( '<div class="myContentHome">' ); 
                print( '<div class="contentListWrapper">' ); 
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
                print( '</div> <!-- contentListWrapper -->' );
                print( '</div> <!-- contentHome -->' );
            ?>
            </div>
        <!-- content 
            <?php if($page['content']): print_r ($page['content']); endif; ?>
            <?php if($page['contentbottom']): print render($page['contentbottom']); endif;?>
            <?php if($page['subheader']): print render($page['subheader']); endif; ?>
            <?php if($page['left']): print render($page['left']); endif; ?>
            <?php if($page['right']): print render($page['right']); endif; ?>
        -->
    </div>
</div>
<!-- footer -->
<footer>
    <?php if($page['footer']): print render($page['footer']); endif; ?>
</footer>
