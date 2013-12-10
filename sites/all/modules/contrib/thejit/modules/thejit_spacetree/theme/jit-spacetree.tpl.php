<?php
/**
 * Copyright (c) 2010, iPlant Collaborative, University of Arizona, Cold Spring Harbor Laboratories, University of Texas at Austin
 * This software is licensed under the CC-GNU GPL version 2.0 or later.
 * License: http://creativecommons.org/licenses/GPL/2.0/
 */
?>
<div class="jit jit-spacetree">
  <?php if ($options['before']) : ?>
    <div class="jit-before">
      <?php print $options['before']; ?>
    </div>
  <?php endif; ?>
  <?php if ($options['enable_full_screen'] || $options['enable_search'] || $options['enable_hiding']) : ?>
    <div class="jit-controls">
      <?php if ($options['enable_hiding']) : ?>
        <div class="jit-control jit-hide" title="Hide visualization"></div>
      <?php endif; ?>
      <?php if ($options['enable_full_screen']) : ?>
        <div class="jit-control jit-full" title="Fullscreen"></div>
      <?php endif; ?>
      <?php if ($options['enable_search']) : ?>
        <div class="jit-control jit-search spacetree-search" title="Search"></div>
        <?php if ($options['search_path']) { ?>
          <div class="spacetree-search-form"><?php echo drupal_get_form('thejit_spacetree_node_search_form', $options['search_path']); ?></div>
        <?php }
        else if (variable_get('thejit_enable_debug', 0)) { ?>
          <?php drupal_set_message('JIT: Missing parameter "search_path" in spacetree configuration.', 'warning'); ?>
        <?php } ?>
    <?php endif; ?>
    </div>
<?php endif; ?>
  <div class="spacetree-wrapper">

    <div id="<?php echo $options['id']; ?>" class="spacetree <?php echo $options['init_orient']; ?>" style="height: <?php echo $options['height'] ?>px">

      <?php if ($options['enable_node_info']) : ?>
        <?php if ($options['node_info_path']) { ?>
          <?php
          if (strrpos($options['node_info_path'], '/', strlen($options['node_info_path']) - 1) === FALSE) {
            $options['node_info_path'] .= '/';
          }
          ?>
          <div class='jit-node-info'>
            <div class='header'><div class='title'></div><div class='closer'></div></div>
            <div class='content'></div>
          </div>
        <?php }
        else if (variable_get('thejit_enable_debug', 0)) { ?>
          <?php drupal_set_message('JIT: Missing parameter "node_info_path" in spacetree configuration.', 'warning'); ?>
        <?php } ?>
      <?php endif; ?>

<?php if ($options['enable_help']) : ?>
        <div class="jit-help">
          <div class="header"><div class="title"></div></div>
          <div class="content">
            <?php if (function_exists($options['help_function_name'])) { ?>
              <?php echo call_user_func($options['help_function_name']); ?>
            <?php }
            else if (variable_get('thejit_enable_debug', 0)) { ?>
          <?php drupal_set_message('JIT: Parameter "help_function_name" is missing or invalid in spacetree configuration.', 'warning'); ?>
        <?php } ?>
          </div>
        </div><div class="jit-help-shadow"></div>
    <?php endif; ?>

    </div>

<?php if ($options['enable_orient']) : ?>
      <ul id='<?php echo $options['id']; ?>-orient' class='orient'>
        <li class='orient'><label><input name='orient' value='bottom' type='radio' <?php echo ($options['init_orient'] === 'bottom' ? 'checked' : ''); ?>/><?php echo t('Tree Grows Up'); ?></label></li>
        <li class='orient'><label><input name='orient' value='top' type='radio' <?php echo ($options['init_orient'] === 'top' ? 'checked' : ''); ?>/><?php echo t('Tree Grows Down'); ?></label></li>
        <li class='orient'><label><input name='orient' value='left' type='radio' <?php echo ($options['init_orient'] === 'left' ? 'checked' : ''); ?>/><?php echo t('Tree Grows Right'); ?></label></li>
        <li class='orient'><label><input name='orient' value='right' type='radio' <?php echo ($options['init_orient'] === 'right' ? 'checked' : ''); ?>/><?php echo t('Tree Grows Left'); ?></label></li>
      </ul>
      <div class='clearing'></div>
      <?php endif; ?>

    <?php if ($options['after']) : ?>
      <div class="jit-after">
  <?php print $options['after']; ?>
      </div>
<?php endif; ?>
  </div>
</div>
<script type="text/javascript">
  Drupal.behaviors.thejit_spacetree_<?php echo $options['id']; ?> = {
    attach : function (context) {
      if (! window.thejit_spacetree) {
        window.thejit_spacetree = {};
      }
      if (! window.thejit_spacetree['<?php echo $options['id']; ?>']) {
        window.thejit_spacetree['<?php echo $options['id']; ?>'] = new Drupal.jit.spacetree(<?php echo drupal_json_encode($options); ?>);
	
<?php if ($controller['onBeforeCompute']) : ?>
                window.thejit_spacetree['<?php echo $options['id']; ?>'].st.config.onBeforeCompute = <?php echo $controller['onBeforeCompute']; ?>;
<?php endif; ?>
			
<?php if ($controller['onAfterCompute']) : ?>
                window.thejit_spacetree['<?php echo $options['id']; ?>'].st.config.onAfterCompute = <?php echo $controller['onAfterCompute']; ?>;
<?php endif; ?>
		
<?php if ($controller['onCreateLabel']) : ?>
                window.thejit_spacetree['<?php echo $options['id']; ?>'].st.config.onCreateLabel = <?php echo $controller['onCreateLabel']; ?>;
<?php endif; ?>
		
<?php if ($controller['onPlaceLabel']) : ?>
                window.thejit_spacetree['<?php echo $options['id']; ?>'].st.config.onPlaceLabel = <?php echo $controller['onPlaceLabel']; ?>;
<?php endif; ?>
		
<?php if ($controller['onComplete']) : ?>
                window.thejit_spacetree['<?php echo $options['id']; ?>'].st.config.onComplete = <?php echo $controller['onComplete']; ?>;
<?php endif; ?>
		
<?php if ($controller['onBeforePlotLine']) : ?>
                window.thejit_spacetree['<?php echo $options['id']; ?>'].st.config.onBeforePlotLine = <?php echo $controller['onBeforePlotLine']; ?>;
<?php endif; ?>
		
<?php if ($controller['onAfterPlotLine']) : ?>
                window.thejit_spacetree['<?php echo $options['id']; ?>'].st.config.onAfterPlotLine = <?php echo $controller['onAfterPlotLine']; ?>;
<?php endif; ?>
		
<?php if ($controller['onBeforePlotNode']) : ?>
                window.thejit_spacetree['<?php echo $options['id']; ?>'].st.config.onBeforePlotNode = <?php echo $controller['onBeforePlotNode']; ?>;
<?php endif; ?>
		
<?php if ($controller['onAfterPlotNode']) : ?>
                window.thejit_spacetree['<?php echo $options['id']; ?>'].st.config.onAfterPlotNode = <?php echo $controller['onAfterPlotNode']; ?>;
<?php endif; ?>
		
<?php if ($controller['request']) : ?>
                window.thejit_spacetree['<?php echo $options['id']; ?>'].st.config.request = <?php echo $controller['request']; ?>;
<?php endif; ?>
			
<?php if ($tree): ?>
                window.thejit_spacetree['<?php echo $options['id']; ?>'].render(<?php echo drupal_json_encode($tree); ?>);
<?php endif; ?>
            }
          }
        };
</script>
