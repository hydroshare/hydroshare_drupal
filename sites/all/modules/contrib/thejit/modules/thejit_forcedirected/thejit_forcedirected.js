Drupal.jit.forceDirected = function(options) {

	var that = this;
	
	that.thisid = options['id'];
	that.jitctxt = jQuery('#' + that.thisid);
	
	var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport && (typeof document.createElement('canvas').getContext('2d').fillText == 'function'),
			// I'm setting this based on the fact that ExCanvas provides text support for IE
			// and that as of today iPhone/iPad current text support is lame
			labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML',
			nativeTextSupport = labelType == 'Native',
			useGradients = nativeCanvasSupport,
			animate = !(iStuff || !nativeCanvasSupport);

	if (options['enable_node_info']) {
		that.node_info = {};
		that.node_info.div = jQuery('<div class="tip hidden">').attr('id', that.thisid + "_node_info");
		jQuery('body').append(that.node_info.div);
		
		that.node_info.setPositionInViz = function(pos, animate) {
			var canvas = jQuery(that.fd.canvas.getElement());
			var css = canvas.offset()
			css.top += pos.y * that.fd.canvas.scaleOffsetY +
									that.fd.canvas.translateOffsetY +
									canvas.height()/2 +
									that.fd.config.Tips.offsetY;
			css.left += pos.x * that.fd.canvas.scaleOffsetX +
									that.fd.canvas.translateOffsetX +
									canvas.width() / 2 +
									that.fd.config.Tips.offsetX;
			if (animate)
				that.node_info.div.animate(css);
			else
				that.node_info.div.css(css);
		}
	}
	
	var clickHandler = function(node) {
		highlightAdj(node);
		if (node && options['enable_node_info']) {
			if (that.node_info.div.hasClass('shown'))
				that.node_info.setPositionInViz(node.pos, true);
			else
				that.node_info.setPositionInViz(node.pos, false);
			var id = node['id'].replace(that.thisid + '_node_', '');
			var url = Drupal.settings.basePath + options['node_info_path'] + id;
			jQuery.ajax({
				url: url,
				dataType: 'json',
				beforeSend: function(resp) {
					that.node_info.node_id = node['id'];
					that.node_info.div.fadeIn().removeClass('hidden').addClass('shown');
					that.node_info.div.html("<div class='tip-title'>Loading...</div><div class='tip-text'></div>");
				},
				success: function(resp) {
					if (resp.success) {
						that.node_info.div.html("<div class='tip-title'>" + resp.title + "</div><div class='tip-text'>" + resp.body + "</div>");
					} else {
						that.node_info.div.html("<div class='tip-title'>Error!</div><div class='tip-text'>Unable to load node info</div>");
					}
				},
				error: function() {
					that.node_info.div.html("<div class='tip-title'>Error!</div><div class='tip-text'>Unable to load node info</div>");
				}
			});
		} else {
			that.node_info.div.fadeOut().removeClass('shown').addClass('hidden');
			that.node_info.node_id = '';
		}
	}
	
	var highlightAdj = function(node) {
		that.fd.graph.eachNode(function(n) {
			n.eachAdjacency(function(adj) {
				adj.removeData('lineWidth');
			});
		});
		if (node) {
			node.eachAdjacency(function(adj) {
				adj.setData('lineWidth', node.Edge.lineWidth + 1.6);
			});
		}
		that.fd.plot();
	};
	
	var defaults = {
		    //id of the visualization container
    injectInto: that.thisid,
    height: 300,
    //Enable zooming and panning
    //by scrolling and DnD
    Navigation: {
      enable: true,
      //Enable panning events only if we're dragging the empty
      //canvas (and not a node).
      panning: 'avoid nodes',
      zooming: 15 //zoom speed. higher is more sensible
    },
    // Change node and edge styles such as
    // color and width.
    // These properties are also set per node
    // with dollar prefixed data-properties in the
    // JSON structure.
    Node: {
      overridable: true
    },
    Edge: {
      overridable: true,
      color: options['edge_color'] ? options['edge_color'] : '#23A4FF',
      lineWidth: 0.4
    },
    //Native canvas text styling
    Label: {
      type: labelType, //Native or HTML
      size: 14,
      style: 'normal',
      color: options['label_color'] ? options['label_color'] : '#454545',
    },
    //Add Tips
//     Tips: {
//       enable: options['enable_node_info'],
//       onShow: function(tip, node) {
//       	if (options['node_info_path']) {
//       		var id = node['id'].replace(that.thisid + '_node_', '');
//       		var url = Drupal.settings.basePath + options['node_info_path'] + id;
//       		jQuery.ajax({
//       			url: url,
//       			dataType: 'json',
//       			beforeSend: function(resp) {
//       				tip.innerHTML = "<div class='tip-title'>Loading...</div><div class='tip-text'></div>";
//       			},
//       			success: function(resp) {
//       				if (resp.success) {
// 								tip.innerHTML = "<div class='tip-title'>" + resp.title + "</div><div class='tip-text'>" + resp.body + "</div>";
// 							} else {
// 								tip.innerHTML = "<div class='tip-title'>Error!</div><div class='tip-text'>Unable to load node info</div>";
// 							}
//       			},
//       			error: function() {
//       				tip.innerHTML = "<div class='tip-title'>Error!</div><div class='tip-text'>Unable to load node info</div>";
//       			}
//       		});
//       	} else { // default
// 					//count connections
// 					var count = 0;
// 					node.eachAdjacency(function() { count++; });
// 					//display node info in tooltip
// 					tip.innerHTML = "<div class=\"tip-title\">" + node.name + "</div>"
// 						+ "<div class=\"tip-text\"><b>connections:</b> " + count + "</div>";
// 				}
//       }
//     },
    // Add node events
    Events: {
      enable: true,
      //Change cursor style when hovering a node
      onMouseEnter: function() {
        that.fd.canvas.getElement().style.cursor = 'move';
      },
      onMouseLeave: function() {
        that.fd.canvas.getElement().style.cursor = '';
      },
      onMouseWheel: function() {
      	if (options['enable_node_info'] && that.node_info.node_id)
					that.node_info.setPositionInViz(that.fd.graph.getNode(that.node_info.node_id).pos, false);
      },
      //Update node positions when dragged
      onDragMove: function(node, eventInfo, e) {
          var pos = eventInfo.getPos();
          node.pos.setc(pos.x, pos.y);
          that.fd.plot();
          if (options['enable_node_info'] && that.node_info.node_id == node['id'])
          	that.node_info.setPositionInViz(node.pos, false);
      },
      //Implement the same handler for touchscreens
      onTouchMove: function(node, eventInfo, e) {
        $jit.util.event.stop(e); //stop default touchmove event
        this.onDragMove(node, eventInfo, e);
      },
      //Add also a click handler to nodes
      onClick: clickHandler,
      onDragStart: highlightAdj,
      onTouchStart: function(node, eventInfo, e) {
        $jit.util.event.stop(e); //stop default touch event
        this.onDragStart(node, eventInfo, e);
      }
    },
    //Number of iterations for the FD algorithm
    iterations: 200,
    //Edge length
    levelDistance: 150,
    // Add text to the labels. This method is only triggered
    // on label creation and only for DOM labels (not native canvas ones).
    onCreateLabel: function(domElement, node){
      domElement.innerHTML = node.name;
      var style = domElement.style;
      style.fontSize = "0.8em";
      style.color = "#454545";
    },
    // Change node styles when DOM labels are placed
    // or moved.
    onPlaceLabel: function(domElement, node){
      var style = domElement.style;
      var left = parseInt(style.left);
      var top = parseInt(style.top);
      var w = domElement.offsetWidth;
      style.left = (left - w / 2) + 'px';
      style.top = (top + 10) + 'px';
      style.display = '';
    }
	};
	
	that.settings = jQuery.extend({}, defaults, options);
	that.fd = new $jit.ForceDirected(that.settings);
	
	that.render = function(json) {
		that.fd.loadJSON(json);
		that.fd.computeIncremental({
			iter: 40,
			property: 'end',
			onStep: function(perc){
			},
			onComplete: function(){
				that.fd.animate({
					modes: ['linear'],
					transition: $jit.Trans.Back.easeOut,
					duration: 750
				});
			}
		});
	};
	
	
	that.jitctxt.bind('mouseenter', function() {
		that.fd.canvas.getPos(true);
	});
	
	jQuery(window).bind('resize', function() {
		var w = jQuery('#' + that.thisid).width(),
				h = jQuery('#' + that.thisid).height();
		that.fd.canvas.resize(w,h);
		that.fd.canvas.getPos(true);
	});
	
	//return that;
};