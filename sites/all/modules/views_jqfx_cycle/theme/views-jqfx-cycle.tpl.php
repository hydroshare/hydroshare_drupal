<?php
// $Id: views-jqfx-cycle.tpl.php $

/**
 * @file
 * Views jQFX: Cycle template file.
 */
?>

<div class="skin-<?php print $options['views_jqfx_cycle']['skin']; ?>">
  <?php if (isset($top_widget_rendered)): ?>
    <div class="views-jqfx-controls-top clearfix">
      <?php print $top_widget_rendered; ?>
    </div>
  <?php endif; ?>
  
  <?php print $jqfx; ?>
  
  <?php if (isset($bottom_widget_rendered)): ?>
    <div class="views-jqfx-controls-bottom clearfix">
      <?php print $bottom_widget_rendered; ?>
    </div>
  <?php endif; ?>
</div>
