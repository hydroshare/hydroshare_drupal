/**
 * Copyright (c) 2010, iPlant Collaborative, University of Arizona, Cold Spring Harbor Laboratories, University of Texas at Austin
 * This software is licensed under the CC-GNU GPL version 2.0 or later.
 * License: http://creativecommons.org/licenses/GPL/2.0/
 */
Drupal.jit.spacetree = function(options) {
	var that = this;
	that.thisid = options['id'];
	that.jitctxt = jQuery('#' + that.thisid);
	
	var resize = function(width, height) {
		that.st.canvas.resize(width, height);
		var lts = Math.floor(height / (that.st.config.levelDistance + that.st.config.Node.height + that.st.config.Node.height));
		that.st.config.levelsToShow = lts;
		if (that.st.clickedNode) {
			jQuery('#' + that.st.clickedNode.id).trigger('click');
		} else {
			jQuery('#' + that.st.root).trigger('click');
		}
		if (options['enable_node_info'])
			moveNodeInfo();
	};
	
	jQuery(window).resize(function() {
		resize(
				parseInt(that.jitctxt.innerWidth()),
				that.jitctxt.height()
			);
		});
	
	if (options['enable_hiding']) {
		that.jitctxt.parent().parent().find('.jit-hide').click(  // TODO this is not a properly namespaced selector
			function() {
				var clicked = jQuery(this);
				clicked.parent().next('.spacetree-wrapper:first').animate(
						{'height':'toggle', 'opacity':'toggle'},
						400,
						jQuery.easing['easeOutExpo'] ? 'easeOutExpo' : 'swing',
						function() {
							clicked.toggleClass('jit-show');
							if (clicked.hasClass('jit-show')) {
								clicked.attr('title','Show visualization');
							} else {
								clicked.attr('title','Hide visualization');
								resize(that.jitctxt.width(), that.jitctxt.height());
							}
						}
					);
			
			});
	}
	
	if (options['enable_full_screen']) {
		var fullScreen = that.fullScreen = function(fs) {
			if (fs) {
				// create overlay modal and full screen effect
				var modal = jQuery('<div class="jit jit-modal tozoom"/>').appendTo('body');
				var mtree = jQuery('<div>').addClass(that.jitctxt.attr('class')).appendTo(modal);
				var overlay = jQuery('<div class="jit-overlay"/>').hide().appendTo('body');
				overlay.fadeIn('fast',
					function() {
						modal.animate(
								{'height':'90%','width':'90%','left':'5%','top':'5%'},
								500,
								jQuery.easing['easeInOutExpo'] ? 'easeInOutExpo' : 'swing',
								function() {
									jQuery('<div class="jit-modal-close"><div class="button"/></div>')
										.appendTo('body')
										.click(
											function() {
												fullScreen(false);
											}
										);
									that.jitctxt.children().appendTo(mtree);
									if (options['enable_node_info'] || options['enable_help']) {
										clearMouseEvents(that.jitctxt);
										that.jitctxt = mtree;
										setMouseEvents(that.jitctxt);
									} else {
										that.jitctxt = mtree;
									}
									resize(mtree.width(), mtree.height());
								}
							);
					}
				);
				// add events to dismiss full screen
				jQuery(document).bind('keyup.spacetree', function(e) {
					if (e.keyCode == 27) {
						fullScreen(false);
						jQuery(document).unbind('keyup.spacetree');
					}
				});
				overlay.click(function() {
					fullScreen(false);
				});
			} else {
				
				jQuery('.jit-overlay, .jit-modal, .jit-modal-close').fadeOut(
					function() {
						var stree = jQuery("#"+that.thisid);
						that.jitctxt.children().appendTo(stree);
						if (options['enable_node_info'] || options['enable_help']) {
							clearMouseEvents(that.jitctxt);
							that.jitctxt = stree;
							setMouseEvents(that.jitctxt);
						} else {
							that.jitctxt = stree;
						}
						resize(stree.width(), stree.height());
						jQuery(this).remove(); 
					});
			}
		};
			
		that.jitctxt.parent().parent().find('.jit-full').click(function() {
				fullScreen(true);
			});
	}
	
	/**
	 * Special behavior for node_info or help
	 */
	if (options['enable_node_info'] || options['enable_help']) {
		var mmfun = function() {

			var first = true;
			if (options['enable_node_info'])
				var bounds = getNodeInfoBounds();
			
			return function(e) {
				if (first) {
					first = false;
					if (options['enable_help']) disableHelp(true);
					if (options['enable_node_info']) fadeNodeInfo(0.2);
				}
				if (options['enable_node_info']) {
					if (
						e.pageX < (bounds.x2 + 100) &&
						e.pageY < (bounds.y2 + 100) &&
						e.pageX > (bounds.x1 - 100) &&
						e.pageY > (bounds.y1 - 100)
					) {
						hideNodeInfo(true);
					} else {
						hideNodeInfo(false);
					}
				}
			};
		};
		
		var setMouseEvents = function(context) {
			clearMouseEvents(context);
			context.bind('mousedown.spacetree',
				function() {
					jQuery('#' + that.thisid + '-canvaswidget').bind('mousemove.spacetree', new mmfun());
				}
			);
			
			context.bind('mouseup.spacetree',
				function() {
					jQuery('#' + that.thisid + '-canvaswidget').unbind('mousemove.spacetree');
					if (options['enable_node_info']) {
						fadeNodeInfo(1);
						hideNodeInfo(false);
					}
					if (options['enable_help'])
						disableHelp(false);
				}
			);
		};
		
		var clearMouseEvents = function(context) {
			context.unbind('.spacetree')
		};
		
		setMouseEvents(that.jitctxt);
		
		if (options['enable_node_info']) {
			var lookupNodeInfo = that.lookupNodeInfo = function(node, callback) {
				var id = node['id'].replace(that.thisid + '_','');
				var ni_url = Drupal.settings.basePath + options['node_info_path'] + id;
				jQuery.ajax({
					url: ni_url,
					dataType: 'json',
					success:
						function(resp) {
							if (options['cache_node_info']) {
								jQuery('#' + node['id']).data('node_info', resp);
							}
							that.jitctxt.find('.jit-node-info .header .title').html(resp.title);
							that.jitctxt.find('.jit-node-info .content').html(resp.body);
						},
					error: function(xml, error, errorObj) {
//						alert(error);
						},
					complete: function() { if (callback) { callback(); } }
					});
			};
			
			var getNodeInfo = that.getNodeInfo = function(node, callback) {
				if (options['cache_node_info']) {
					var cached_node_info = jQuery('#' + node['id']).data('node_info');
					if (cached_node_info) {
						that.jitctxt.find('.jit-node-info .header .title').html(cached_node_info['title']);
						that.jitctxt.find('.jit-node-info .content').html(cached_node_info['body']);
						if (callback) {
							callback();
						}
					} else {
						lookupNodeInfo(node, callback);
					}
				} else {
					lookupNodeInfo(node, callback);
				}
			};
			
			var getNodeInfoBounds = that.getNodeInfoBounds = function() {
				var ni = that.jitctxt.find('.jit-node-info');
				var bounds = ni.data('bounds');
				if (bounds === undefined) {
					var pos = ni.offset();
					var bounds = {};
					bounds.x1 = pos.left;
					bounds.y1 = pos.top;
					bounds.x2 = pos.left + ni.width();
					bounds.y2 = pos.top + ni.height();
					ni.data('bounds',bounds);
				}
				
				return bounds;
			};
			
			var fadeNodeInfo = that.fadeNodeInfo = function(opacity, callback) {
				that.jitctxt.find('.jit-node-info').animate({'opacity': opacity}, callback);
			};
			
			var hideNodeInfo = that.hideNodeInfo = function(hide, callback) {
				if (hide) {
					that.jitctxt.find('.jit-node-info').animate({'opacity': 'hide'}, 'fast', callback);
				} else {
					that.jitctxt.find('.jit-node-info').animate({'opacity': 'show'}, 'fast', callback);
				}
			};
			
			var moveNodeInfo = that.moveNodeInfo = function(callback) {
				var ni = that.jitctxt.find('.jit-node-info');
				var css = {top: '10px', left: '10px'};
				switch (that.st.config.orientation) {
					case 'bottom':
						css.top = (that.jitctxt.height() - ni.height() - 10) + 'px';
						break;
					case 'right':
						css.left = (that.jitctxt.width() - ni.width() - 10) + 'px';
						break;
				}
				ni.animate(css, callback);
				ni.removeData('bounds')
			};
		}

		if (options['enable_help']) {
			var showHelp = that.showHelp = function() {
				clearTimeout(hideHelp._t);
				showHelp._t = setTimeout(
					function() {
						that.jitctxt.find('.jit-help').animate({'right':'0px'}, 250, jQuery.easing['easeOutExpo'] ? 'easeOutExpo' : 'swing');
					},
					100);
			};
			
			var hideHelp = that.hideHelp = function() {
				clearTimeout(showHelp._t);
				hideHelp._t = setTimeout(
					function() {
						var w = that.jitctxt.find('.jit-help .content').outerWidth();
						that.jitctxt.find('.jit-help').animate({'right':'-' + w + 'px'}, 250, jQuery.easing['easeOutBack'] ? 'easeOutBack' : 'swing');
					},
					100);
			};
			
			var disableHelp = that.disableHelp = function(disable) {
				var help = that.jitctxt.find('.jit-help');
				if (disable) {
					var w = help.outerWidth();
					help.animate({'right':'-' + w + 'px'}, 250);
					help.next().hide(); // hide shadow
				} else {
					hideHelp();  // this adds the help tab back minimized
					setTimeout(function() {help.next().show();}, 200);
				}
			};
		
			hideHelp();
			that.jitctxt.find('.jit-help').hover(showHelp,hideHelp);
		}
	}
	
	if (options['enable_orient']) {
		that.jitctxt.parent().parent().find("input[name='orient']").click(
			function() {
				if (! that.st.busy) {
					that.jitctxt.parent().parent().find("input[name='orient']").attr('disabled','disabled');
					var orient = jQuery(this).val();
					that.jitctxt.removeClass('top right bottom left');
					that.jitctxt.addClass(orient);
					that.st.switchPosition(orient, 'animate', {
							onComplete: function() {
								if (options['enable_node_info'])
									moveNodeInfo();
								that.jitctxt.parent().parent().find("input[name='orient']").removeAttr('disabled');
							}
						});
				} else {
					return false;
				}
			}
		);
	}
	
	if (options['enable_search']) {
		that.jitctxt.parent().parent().find('.spacetree-search').click(function() {
				var clicked = jQuery(this);
				var pos = clicked.position();
				that.jitctxt.parent().parent().find('.spacetree-search-form').css({'top': (pos.top + clicked.height()) + 'px', 'right': '3px'}).fadeIn().find('input:first').focus();
				jQuery(document).bind('keyup.spacetree', function(e) {
					if (e.keyCode == 27) {
						that.jitctxt.parent().parent().find('.spacetree-search-form').fadeOut();
						jQuery('.spacetree-search-form-overlay').trigger('click');
						jQuery(document).unbind('keyup.spacetree');
					}
				});
				jQuery('<div class="spacetree-search-form-overlay">').appendTo('body').click(function() {
					that.jitctxt.parent().parent().find('.spacetree-search-form').fadeOut();
					jQuery(document).unbind('keyup.spacetree');
					jQuery(this).remove();
				});
			});
		
		var handler = function() {
				var val = that.jitctxt.parent().parent().find('.spacetree-search-form').find('input[type=text]:first').val();
				var node = that.st.graph.getByName(val);
				if (node) {
					that.st.canvas.translate(-that.st.canvas.translateOffsetX, -that.st.canvas.translateOffsetY);
					var open = function(n, callback) {
						if (!n.drawn) {
							open(n.getParents()[0], function() {open(n, callback)});
						} else {
							var oncomplete = {};
							if (callback) {
								oncomplete['onComplete'] = callback;
							}
							that.st.onClick(n.id, oncomplete);
						}
		
					}
					open(node, function() {jQuery('#'+node.id).trigger('click');});
					jQuery('.spacetree-search-form-overlay').trigger('click');
				}
				return false;
			};
		that.jitctxt.parent().parent().find('.spacetree-search-form input[type=submit]').click(handler);
		that.jitctxt.parent().parent().find('.spacetree-search-form form').submit(handler);
	}
	
	$jit.ST.Plot.NodeTypes.implement({
      'expanding': {
      	'curveW': 16,
      	'curveH': 16,
        'render': function(node, canvas) {
        	if (node.data.unexpanded) {
						var pos = node.pos.getc(true),
								h = node.getData('height'),
								w = node.getData('width'),
                algnPos = this.getAlignedPos(pos, w, h),
                x = algnPos.x + w/2,
                y = algnPos.y,
                cw = this.nodeTypes.expanding.curveW,
                ch = this.nodeTypes.expanding.curveH,
                orn = this.config.orientation,
                ctx = canvas.getCtx();
						
						if (orn == 'bottom' || orn == 'top') {
							if (orn == 'top') {
								y += h;
								ch = -ch;
							}
							var gx0 = 0, gy0 = y, gx1 = 0, gy1 = y - ch,
									cx0 = x - cw, cy0 = y - ch/4,
									cx1 = x, cy1 = y - ch/2,
									cx2 = x + cw, cy2 = y - ch/4,
									x0 = x - cw, y0 = y - ch,
									x1 = x, y1 = y,
									x2 = x + cw, y2 = y - ch;
						} else {
							if (orn == 'right') {
								w = -w;
								cw = -ch;
							} else {
								cw = ch;
							}
							x += w/2;
							y += h/2;
							ch = ch/2;
							
							var gx0 = x, gy0 = 0, gx1 = x + cw, gy1 = 0,
								cx0 = x + cw/4, cy0 = y - ch,
								cx1 = x + cw/2, cy1 = y,
								cx2 = x + cw/4, cy2 = y + ch,
								x0 = x + cw, y0 = y - ch,
								x1 = x, y1 = y,
								x2 = x + cw, y2 = y + ch;
						}
						ctx.save();						
						ctx.beginPath();
						
						var grad = ctx.createLinearGradient(gx0, gy0, gx1, gy1);
						grad.addColorStop(0, 'rgba(255,255,255,1)');
						grad.addColorStop(1, 'rgba(255,255,255,0)');
						
						ctx.fillStyle = grad;
						ctx.moveTo(x0, y0);
						ctx.bezierCurveTo(cx0, cy0, cx1, cy1, x1, y1);
						ctx.bezierCurveTo(cx1, cy1, cx2, cy2, x2, y2); 
						
						ctx.fill();
						ctx.restore();
					}
        },
        'contains': function(node, pos) {
					var width = node.getData('width'),
							height = node.getData('height'),
							npos = this.getAlignedPos(node.pos.getc(true), width, height);
					
					npos.x = npos.x + width / 2;
					npos.y = npos.y + (height + this.nodeTypes.expanding.curveH) / 2;
					
					return this.nodeHelper.rectangle.contains(npos, pos, width, height + this.nodeTypes.expanding.curveH);
				}
      }
    });
	
	var defaults = {
			height: 300,
			injectInto: that.thisid,
			duration: 250,
			transition: $jit.Trans.linear,
			Navigation: {
				enable: true,
				panning: true
			},
			orientation: options['init_orient'],
			levelsToShow: 3,
			levelDistance: 40,
			Node: {
				type: 'expanding',
				overridable: true,
				align: 'center'
			},
			Edge: {
				type: 'bezier',
				overridable: true,
				color: options['edge_color'],
				lineWidth: 2
			},
			offsetX: 0,
			offsetY: 0
		};
	
	// create scratch area for SpaceTree plot calculations for node width/height
	jQuery('body').append('<div id="thejit__spacetree__scratch__"><div id="thejit__spacetree__scratch__lbl__"></div></div>');
	
	that.settings = jQuery.extend({}, defaults, options);
	that.st = new $jit.ST(that.settings);
	that.st.graph._getByName = that.st.graph.getByName;
	that.st.graph.getByName =
		function(name) {
			for(var id in this.nodes) {
				var n = this.nodes[id];
				if(n.name.toLowerCase() == name.toLowerCase()) return n;
			}
			return false;
	  };
	
	that.render = function(newtree) {
			// clear labels and cached labels in st instance
			that.st.labels.clearLabels();
			
			// reload tree
			that.st.loadJSON(newtree);
			that.st.compute();
			if (that.settings.node_to_select_id === undefined || that.settings.node_to_select_id === null || that.settings.node_to_select_id === that.st.root) {
				that.st.geom.translate(new $jit.Complex(0, -150), "current");
				that.st.onClick(that.st.root, {
						onComplete: function() {
							jQuery('#' + that.st.root).trigger('click');
						}
					});
			} else {
				that.st.select(that.settings.node_to_select_id);
				that.st.refresh();
				jQuery('#' + that.settings.node_to_select_id).trigger('click');
			}
		};
	
	return that;
}