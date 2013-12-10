<?php
/**
 * Copyright (c) 2010, iPlant Collaborative, University of Arizona, Cold Spring Harbor Laboratories, University of Texas at Austin
 * This software is licensed under the CC-GNU GPL version 2.0 or later.
 * License: http://creativecommons.org/licenses/GPL/2.0/
 */
?>
function(adj){
	if (adj.nodeFrom.selected && adj.nodeTo.selected) {
		adj.data.$color = window.thejit_spacetree['<?php echo $tree_id; ?>'].settings['selected_edge_color'];
		adj.data.$lineWidth = 4;
	}
	else {
		delete adj.data.$color;
		delete adj.data.$lineWidth;
	}
}