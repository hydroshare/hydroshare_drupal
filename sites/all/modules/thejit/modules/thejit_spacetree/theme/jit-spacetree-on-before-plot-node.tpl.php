<?php
/**
 * Copyright (c) 2010, iPlant Collaborative, University of Arizona, Cold Spring Harbor Laboratories, University of Texas at Austin
 * This software is licensed under the CC-GNU GPL version 2.0 or later.
 * License: http://creativecommons.org/licenses/GPL/2.0/
 */
?>
function(node) {
	node.data.unexpanded = false;
	if (!node.anySubnode('exist')) {
		var c = 0;
		node.eachSubnode(function(n) { c++; });
		if (c > 0) {
			node.data.unexpanded = true;
		}
	}
}