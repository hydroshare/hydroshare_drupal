------------------------------------------------------------------------

The Javascript InfoVis Toolkit (JIT) Module for Drupal 6.x
author:	Matthew R Hanlon mrhanlon (at) tacc (dot) utexas (dot) edu
date:		2010.10.14

Copyright (c) 2010, iPlant Collaborative, University of Arizona, Cold
Spring Harbor Laboratories, University of Texas at Austin
This software is licensed under the CC-GNU GPL version 2.0 or later.
License: http://creativecommons.org/licenses/GPL/2.0/

------------------------------------------------------------------------

This module implements the JIT javascript visualization library
(http://thejit.org) as a Drupal module that can be integrated into other
modules to provide javascript visualizations of Drupal data–nodes,
taxonomy, users, etc.

This module additionally builds some additional, optional functionality
on top of the JIT visualizations to provide a richer module with
features desirable in a Drupal web site.

------------------------------------------------------------------------

INSTALLATION

Before enabling this module, you will need to download the JIT libraries
and excanvas.  The currently supported version of JIT is 2.0.1.

The JIT library can be downloaded here: http://thejit.org
Direct link: http://thejit.org/downloads/Jit-2.0.1.zip

The JIT comes packaged with excanvas: http://code.google.com/p/explorercanvas

Extract the ZIP archive into the sites/all/libraries directory. The
resulting directory structure should be (note the lowercase name jit):

	sites/
		all/
			libraries/
				jit/
					Examples/
					Extras/
						excanvas.js
					jit-yc.js
					jit.js

The Examples directory can be deleted, if desired.

Next, simply go to administer -> site building ->
modules and enable the JIT module under the group Visualizations.  This
module requires the jquery_update module
(http://drupal.org/project/jquery_update) to provide at least jQuery
1.3.2.

Optionally, you can also install the jquery_ui module to enable advanced
animations (easing) for certain (http://drupal.org/project/jquery_ui).

------------------------------------------------------------------------

DEPENDENCIES

Libraries API: http://drupal.org/project/libraries
jQuery Update: http://drupal.org/project/jquery_update
jQuery UI (optional): http://drupal.org/project/jquery_ui

------------------------------------------------------------------------

CONFLICTS

No known conflicts.

------------------------------------------------------------------------

TODO

See TODO.txt.
