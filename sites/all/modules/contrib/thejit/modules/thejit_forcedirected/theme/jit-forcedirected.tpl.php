<?php
/**
 * Copyright (c) 2010, iPlant Collaborative, University of Arizona, Cold Spring Harbor Laboratories, University of Texas at Austin
 * This software is licensed under the CC-GNU GPL version 2.0 or later.
 * License: http://creativecommons.org/licenses/GPL/2.0/
 */
?>
<div class="jit jit-forcedirected" style="display:inline-block">
  <div class="forcedirected-wrapper">
    <div <?php echo $options['attributes']; ?> class="forcedirected">
    </div>
  </div>
</div>
<script type="text/javascript">
  Drupal.behaviors.thejit_forceDirected_<?php echo $options['id']; ?> = {
    attach : function (context) {
      if (! window.thejit_forceDirected) {
        window.thejit_forceDirected = {};
      }
      if (! window.thejit_forceDirected['<?php echo $options['id']; ?>']) {
        var my_jit = new Drupal.jit.forceDirected(<?php echo json_encode($options); ?>);
        window.thejit_forceDirected['<?php echo $options['id']; ?>'] = my_jit;
	
<?php if ($json): ?>
        window.thejit_forceDirected['<?php echo $options['id']; ?>'].render(<?php echo json_encode($json); ?>);
<?php endif; ?>
              }
            }
          };
</script>