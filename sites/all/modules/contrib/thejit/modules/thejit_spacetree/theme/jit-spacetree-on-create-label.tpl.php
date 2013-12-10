<?php
/**
 * Copyright (c) 2010, iPlant Collaborative, University of Arizona, Cold Spring Harbor Laboratories, University of Texas at Austin
 * This software is licensed under the CC-GNU GPL version 2.0 or later.
 * License: http://creativecommons.org/licenses/GPL/2.0/
 */
?>
function(label, node) {
	var that = window.thejit_spacetree['<?php echo $tree_id; ?>'];
	var lbl = jQuery(label);
	lbl.bind('click.spacetree', function() {
			that.jitctxt.find('.selected').removeClass('selected');
			lbl.addClass('selected');
			that.st.onClick(node.id);
			if (that.settings['enable_node_info']) {
				that.getNodeInfo(node,
					function() {
						that.moveNodeInfo(function() {
							that.fadeNodeInfo(1.0);
						});
					});
			}
		});
		
	var scratch = jQuery('#thejit__spacetree__scratch__');
	var testLbl = jQuery('#thejit__spacetree__scratch__lbl__');

	// set current classes
	scratch.attr('class', that.jitctxt.attr('class'));
	testLbl.attr('class', 'node').attr('style', '');
	if (jQuery('#' + node.id).hasClass('selected')) {
		testLbl.addClass('selected');
	}
	
	// try to cause line wrap
	testLbl.width(node.getData('width')).html(node.name);
	var h = testLbl.outerHeight();
	if (h > node.getData('height')) {
		node.data.$height = h;
	}
	
	lbl.width(node.getData('width')).html(node.name);
}