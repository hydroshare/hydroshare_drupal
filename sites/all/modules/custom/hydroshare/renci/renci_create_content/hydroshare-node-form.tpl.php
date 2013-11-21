<?php echo "<h2>Hydroshare Custom Add Group Form</h2>"?>

<div class="node-add-wrapper clear-block">

  <div class="node-column-main">
    <?php if($form): ?>
    	<?php

    	  // Render all form elements with the exception of the option tabs
		  $output = '';
    	  $children_keys = element_children($form);
		  foreach ($children_keys as $key) {
		    if (!empty($form[$key])) {
		      //if (!($key == 'additional_settings')) {
		      	 $output .= drupal_render($form[$key]);
		      //}

		    }
		  }
		  print $output;
     ?>
    <?php endif; ?>

  </div>
  <div class="clear"></div>
</div>