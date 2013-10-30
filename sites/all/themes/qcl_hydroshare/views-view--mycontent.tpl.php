<section id="console">
		<?php if($page['header']): print render($page['header']); endif;?>
</section>

<div id="container">

    <div class="subHeader">
        <h1>My Resources</h1>
        <p>All your resources in one place</p>
    </div><!-- subHeader -->

    <div class="mycontentHome">
        <div class="contentListWrapper">
           <?php 
		   $hostname = $_SERVER['SERVER_NAME'];
                   $add_url  = '/?q=node/add';
		   print( '<a href="' . $add_url .'" class="greyButton">UPLOAD</a>' );
           ?>


            <div class="contentList">
                <div class="contentTable">
                    <?php
		        $hostname = $_SERVER['SERVER_NAME'];
                        $ts_icon='<img src="http://'.  $hostname . '/sites/all/themes/qcl_hydroshare/images/excel_icon.jpg"></td>';
                        $ot_icon='<img src="http://'.  $hostname . '/sites/all/themes/qcl_hydroshare/images/gear_icon.jpg"></td>';
                        $ga_icon='<img src="http://' . $hostname . '/sites/all/themes/qcl_hydroshare/images/globe_icon.jpg"></td>';
                        $rows = str_replace( "Time Series          </td>",  $ts_icon, $rows );
                        $rows = str_replace( "Geoanalytics          </td>", $ga_icon, $rows );
                        $rows = str_replace( "Other          </td>",        $ot_icon, $rows );
                        print( $rows );   
                    ?>
                </div> <!-- contentTable -->

            </div> <!-- contentList -->

        </div> <!-- contentListWrapper -->

    </div> <!-- mycontentHome -->

</div><!-- container -->

<!-- footer -->
<footer>
    <?php if($page['footer']): print render($page['footer']); endif; ?>
</footer>
