// $Id$

/**
 *  @file
 *  A simple jQuery Cycle Div Rotator.
 */
(function($) {
/**
 * This will set our initial behavior, by starting up each individual jqfx.
 */
Drupal.behaviors.viewsJqfxCycle = {
  attach: function (context) {
    $('.views_jqfx_cycle_main:not(.viewsJqfxCycle-processed)', context).addClass('viewsJqfxCycle-processed').each(function() {
      var fullId = '#' + $(this).attr('id');
      var settings = Drupal.settings.viewsJqfxCycle[fullId];
      settings.targetId = '#' + $(fullId + " :first").attr('id');
      settings.paused = false;

      settings.opts = {
        speed:settings.speed,
        timeout:settings.timeout,
        delay:settings.delay,
        sync:settings.sync,
        random:settings.random,
        pagerAnchorBuilder:function(idx, slide) {
          var classes = 'pager-item pager-num-' + (idx+1);
          if (idx == 0) {
            classes += ' first';
          }
          if ($(slide).siblings().length == idx) {
            classes += ' last';
          }

          if (idx % 2) {
            classes += ' odd';
          }
          else {
            classes += ' even';
          }

          // Call the theme function for the pager.
          var theme = 'viewsJqfxPager' + settings.pager_type;
          return Drupal.theme.prototype[theme] ? Drupal.theme(theme, classes, idx, slide, settings) : '';
        },
        allowPagerClickBubble:(settings.pager_hover),
        prev:(settings.controls != 0)?'#views_jqfx_cycle_prev_' + settings.vss_id:null,
        next:(settings.controls != 0)?'#views_jqfx_cycle_next_' + settings.vss_id:null,
        pager:(settings.pager != 0)?'#views_jqfx_cycle_pager_' + settings.vss_id:null,
        nowrap:settings.nowrap,
        after:function(curr, next, opts) {
          // Used for Slide Counter.
          if (settings.slide_counter) {
            $('#views_jqfx_cycle_slide_counter_' + settings.vss_id + ' span.num').html(opts.currSlide + 1);
            $('#views_jqfx_cycle_slide_counter_' + settings.vss_id + ' span.total').html(opts.slideCount);
          }
        },
        before:function(curr, next, opts) {
          // Remember last slide.
          if (settings.remember_slide) {
            createCookie(settings.vss_id, opts.currSlide + 1, settings.remember_slide_days);
          }

          // Make variable height.
          if (!settings.fixed_height) {
            //get the height of the current slide
            var $ht = $(this).height();
            //set the container's height to that of the current slide
            $(this).parent().animate({height: $ht});
          }
        },
        cleartype:(settings.cleartype)? true : false,
        cleartypeNoBg:(settings.cleartypenobg)? true : false,
        activePagerClass:'active-slide'
      }

      // Set the starting slide if we are supposed to remember the slide
      if (settings.remember_slide) {
        var startSlide = readCookie(settings.vss_id);
        if (startSlide == null) {
          startSlide = 0;
        }
        settings.opts.startingSlide =  startSlide;
      }

      if (settings.pager_hover) {
        settings.opts.pagerEvent = 'mouseover';
        settings.opts.pauseOnPagerHover = true;
      }

      if (settings.effect == 'none') {
        settings.opts.speed = 1;
      }
      else {
        settings.opts.fx = settings.effect;
      }

      // Pause on hover.
      if (settings.pause) {
        $('#views_jqfx_cycle_teaser_section_' + settings.vss_id).hover(function() {
          $(settings.targetId).cycle('pause');
        }, function() {
          if (!settings.paused) {
            $(settings.targetId).cycle('resume');
          }
        });
      }

      // Pause on clicking of the slide.
      if (settings.pause_on_click) {
        $('#views_jqfx_cycle_teaser_section_' + settings.vss_id).click(function() {
          viewsJqfxCyclePause(settings);
        });
      }

      // Allow pagers to override settings.
      if (settings.pager != 0) {
        var pagerAlter = 'viewsJqfxCyclePager' + settings.pager_type + 'SettingsAlter';
        if (typeof window[pagerAlter] == 'function') {
          settings = window[pagerAlter](settings);
        }
      }

      // Advanced Settings
      if (typeof(settings.advanced_fx) !== 'undefined') { settings.opts.fx = settings.advanced_fx; }

      if (typeof(settings.advanced_timeout) !== 'undefined') { settings.opts.timeout = settings.advanced_timeout; }

      if (typeof(settings.advanced_timeoutfn) !== 'undefined') {
        settings.opts.timeoutFn = function(currSlideElement, nextSlideElement, options, forwardFlag) {
          eval(settings.advanced_timeoutfn);
        }
      }

      // true to start next transition immediately after current one completes
      if (typeof(settings.advanced_continuous) !== 'undefined') { settings.opts.continuous = settings.advanced_continuous; }

      // speed of the transition (any valid fx speed value)
      if (typeof(settings.advanced_speed) !== 'undefined') { settings.opts.speed = settings.advanced_speed; }

      // speed of the 'in' transition
      if (typeof(settings.advanced_speedin) !== 'undefined') { settings.opts.speedIn = settings.advanced_speedin; }

      // speed of the 'out' transition
      if (typeof(settings.advanced_speedout) !== 'undefined') { settings.opts.speedOut = settings.advanced_speedout; }

      // selector for element to use as click trigger for next slide
      if (typeof(settings.advanced_next) !== 'undefined') { settings.opts.next = settings.advanced_next; }

      // selector for element to use as click trigger for previous slide
      if (typeof(settings.advanced_prev) !== 'undefined') { settings.opts.prev = settings.advanced_prev; }

      // callback fn for prev/next clicks:   function(isNext, zeroBasedSlideIndex, slideElement)
      if (typeof(settings.advanced_prevnextclick) !== 'undefined') {
        settings.opts.prevNextClick = function(isNext, zeroBasedSlideIndex, slideElement) {
          eval(settings.advanced_prevnextclick);
        }
      }

      // event which drives the manual transition to the previous or next slide
      if (typeof(settings.advanced_prevnextevent) !== 'undefined') { settings.opts.prevNextEvent = settings.advanced_prevnextevent; }

      // selector for element to use as pager container
      if (typeof(settings.advanced_pager) !== 'undefined') { settings.opts.pager = settings.advanced_pager; }

      // callback fn for pager clicks:    function(zeroBasedSlideIndex, slideElement)
      if (typeof(settings.advanced_pagerclick) !== 'undefined') {
        settings.opts.pagerClick = function(zeroBasedSlideIndex, slideElement) {
          eval(settings.advanced_pagerclick);
        }
      }

      // name of event which drives the pager navigation
      if (typeof(settings.advanced_pagerevent) !== 'undefined') { settings.opts.pagerEvent = settings.advanced_pagerevent; }

      // allows or prevents click event on pager anchors from bubbling
      if (typeof(settings.advanced_allowpagerclickbubble) !== 'undefined') { settings.opts.allowPagerClickBubble = settings.advanced_allowpagerclickbubble; }

       // callback fn for building anchor links:  function(index, DOMelement)
      if (typeof(settings.advanced_pageranchorbuilder) !== 'undefined') {
        settings.opts.pagerAnchorBuilder = function(index, DOMelement) {
          eval(settings.advanced_pageranchorbuilder);
        }
      }

      // transition callback (scope set to element to be shown):     function(currSlideElement, nextSlideElement, options, forwardFlag)
      if (typeof(settings.advanced_before) !== 'undefined') {
        settings.opts.before = function(currSlideElement, nextSlideElement, options, forwardFlag) {
          eval(settings.advanced_before);
        }
      }

      // transition callback (scope set to element that was shown):  function(currSlideElement, nextSlideElement, options, forwardFlag)
      if (typeof(settings.advanced_after) !== 'undefined') {
        settings.opts.after = function(currSlideElement, nextSlideElement, options, forwardFlag) {
          eval(settings.advanced_after);
        }
      }

      // callback invoked when the jqfx terminates (use with autostop or nowrap options): function(options)
      if (typeof(settings.advanced_end) !== 'undefined') {
        settings.opts.end = function(options) {
          eval(settings.advanced_end);
        }
      }

      // easing method for both in and out transitions
      if (typeof(settings.advanced_easing) !== 'undefined') { settings.opts.easing = settings.advanced_easing; }

      // easing for "in" transition
      if (typeof(settings.advanced_easein) !== 'undefined') { settings.opts.easeIn = settings.advanced_easein; }

      // easing for "out" transition
      if (typeof(settings.advanced_easeout) !== 'undefined') { settings.opts.easeOut = settings.advanced_easeout; }

      // coords for shuffle animation, ex: { top:15, left: 200 }
      if (typeof(settings.advanced_shuffle) !== 'undefined') { settings.opts.shuffle = settings.advanced_shuffle; }

      // properties that define how the slide animates in
      if (typeof(settings.advanced_animin) !== 'undefined') { settings.opts.animIn = settings.advanced_animin; }

      // properties that define how the slide animates out
      if (typeof(settings.advanced_animout) !== 'undefined') { settings.opts.animOut = settings.advanced_animout; }

      // properties that define the initial state of the slide before transitioning in
      if (typeof(settings.advanced_cssbefore) !== 'undefined') { settings.opts.cssBefore = settings.advanced_cssbefore; }

      // properties that defined the state of the slide after transitioning out
      if (typeof(settings.advanced_cssafter) !== 'undefined') { settings.opts.cssAfter = settings.advanced_cssafter; }

      // function used to control the transition: function(currSlideElement, nextSlideElement, options, afterCalback, forwardFlag)
      if (typeof(settings.advanced_fxfn) !== 'undefined') {
        settings.opts.fxFn = function(currSlideElement, nextSlideElement, options, afterCalback, forwardFlag) {
          eval(settings.advanced_fxfn);
        }
      }

      // container height
      if (typeof(settings.advanced_height) !== 'undefined') { settings.opts.height = settings.advanced_height; }

      // zero-based index of the first slide to be displayed
      if (typeof(settings.advanced_startingslide) !== 'undefined') { settings.opts.startingSlide = settings.advanced_startingslide; }

      // true if in/out transitions should occur simultaneously
      if (typeof(settings.advanced_sync) !== 'undefined') { settings.opts.sync = settings.advanced_sync; }

      // true for random, false for sequence (not applicable to shuffle fx)
      if (typeof(settings.advanced_random) !== 'undefined') { settings.opts.random = settings.advanced_random; }

      // force slides to fit container
      if (typeof(settings.advanced_fit) !== 'undefined') { settings.opts.fit = settings.advanced_fit; }

      // resize container to fit largest slide
      if (typeof(settings.advanced_containerresize) !== 'undefined') { settings.opts.containerResize = settings.advanced_containerresize; }

      // true to enable "pause on hover"
      if (typeof(settings.advanced_pause) !== 'undefined') { settings.opts.pause = settings.advanced_pause; }

      // true to pause when hovering over pager link
      if (typeof(settings.advanced_pauseonpagerhover) !== 'undefined') { settings.opts.pauseOnPagerHover = settings.advanced_pauseonpagerhover; }

      // true to end jqfx after X transitions (where X == slide count)
      if (typeof(settings.advanced_autostop) !== 'undefined') { settings.opts.autostop = settings.advanced_autostop; }

      // number of transitions (optionally used with autostop to define X)
      if (typeof(settings.advanced_autostopcount) !== 'undefined') { settings.opts.autostopCount = settings.advanced_autostopcount; }

      // additional delay (in ms) for first transition (hint: can be negative)
      if (typeof(settings.advanced_delay) !== 'undefined') { settings.opts.delay = settings.advanced_delay; }

      // expression for selecting slides (if something other than all children is required)
      if (typeof(settings.advanced_slideexpr) !== 'undefined') { settings.opts.slideExpr = settings.advanced_slideexpr; }

      // true if clearType corrections should be applied (for IE)
      if (typeof(settings.advanced_cleartype) !== 'undefined') { settings.opts.cleartype = settings.advanced_cleartype; }

      // set to true to disable extra cleartype fixing (leave false to force background color setting on slides)
      if (typeof(settings.advanced_cleartypenobg) !== 'undefined') { settings.opts.cleartypeNoBg = settings.advanced_cleartypenobg; }

      // true to prevent jqfx from wrapping
      if (typeof(settings.advanced_nowrap) !== 'undefined') { settings.opts.nowrap = settings.advanced_nowrap; }

      // force fast transitions when triggered manually (via pager or prev/next); value == time in ms
      if (typeof(settings.advanced_fastonevent) !== 'undefined') { settings.opts.fastOnEvent = settings.advanced_fastonevent; }

      // valid when multiple effects are used; true to make the effect sequence random
      if (typeof(settings.advanced_randomizeeffects) !== 'undefined') { settings.opts.randomizeEffects = settings.advanced_randomizeeffects; }

      // causes animations to transition in reverse
      if (typeof(settings.advanced_rev) !== 'undefined') { settings.opts.rev = settings.advanced_rev; }

      // causes manual transition to stop an active transition instead of being ignored
      if (typeof(settings.advanced_manualtrump) !== 'undefined') { settings.opts.manualTrump = settings.advanced_manualtrump; }

      // requeue the jqfx if any image slides are not yet loaded
      if (typeof(settings.advanced_requeueonimagenotloaded) !== 'undefined') { settings.opts.requeueOnImageNotLoaded = settings.advanced_requeueonimagenotloaded; }

      // ms delay for requeue
      if (typeof(settings.advanced_requeuetimeout) !== 'undefined') { settings.opts.requeueTimeout = settings.advanced_requeuetimeout; }

      // class name used for the active pager link
      if (typeof(settings.advanced_activepagerclass) !== 'undefined') { settings.opts.activePagerClass = settings.advanced_activepagerclass; }

      // callback fn invoked to update the active pager link (adds/removes activePagerClass style)
      if (typeof(settings.advanced_updateactivepagerlink) !== 'undefined') { settings.opts.updateActivePagerLink = eval(settings.advanced_updateactivepagerlink); }

      $(settings.targetId).cycle(settings.opts);

      // Start Paused
      if (settings.start_paused) {
        viewsJqfxCyclePause(settings);
      }

      // Pause if hidden.
      if (settings.pause_when_hidden) {
        var checkPause = function(settings) {
          // If the jqfx is visible and it is paused then resume.
          // otherwise if the jqfx is not visible and it is not paused then
          // pause it.
          var visible = viewsJqfxCycleIsVisible(settings.targetId, settings.pause_when_hidden_type, settings.amount_allowed_visible);
          if (visible && settings.paused) {
            viewsJqfxCycleResume(settings);
          }
          else if (!visible && !settings.paused) {
            viewsJqfxCyclePause(settings);
          }
        }

        // Check when scrolled.
        $(window).scroll(function() {
         checkPause(settings);
        });

        // Check when the window is resized.
        $(window).resize(function() {
          checkPause(settings);
        });
      }

      // Show image count for people who have js enabled.
      $('#views_jqfx_cycle_image_count_' + settings.vss_id).show();

      if (settings.controls != 0) {
        // Show controls for people who have js enabled browsers.
        $('#views_jqfx_cycle_controls_' + settings.vss_id).show();

        $('#views_jqfx_cycle_playpause_' + settings.vss_id).click(function(e) {
          if (settings.paused) {
            viewsJqfxCycleResume(settings);
          }
          else {
            viewsJqfxCyclePause(settings);
          }
          e.preventDefault();
        });
      }
    });
  }
}

// Pause the jqfx
viewsJqfxCyclePause = function (settings) {
  // Make Resume translatable
  var resume = Drupal.t('Resume');

  $(settings.targetId).cycle('pause');
  if (settings.controls != 0) {
    $('#views_jqfx_cycle_playpause_' + settings.vss_id)
      .addClass('views_jqfx_cycle_play')
      .addClass('views_jqfx_play')
      .removeClass('views_jqfx_cycle_pause')
      .removeClass('views_jqfx_pause')
      .text(resume);
  }
  settings.paused = true;
}

// Resume the jqfx
viewsJqfxCycleResume = function (settings) {
  // Make Pause translatable
  var pause = Drupal.t('Pause');

  $(settings.targetId).cycle('resume');
  if (settings.controls != 0) {
    $('#views_jqfx_cycle_playpause_' + settings.vss_id)
      .addClass('views_jqfx_cycle_pause')
      .addClass('views_jqfx_pause')
      .removeClass('views_jqfx_cycle_play')
      .removeClass('views_jqfx_play')
      .text(pause);
  }
  settings.paused = false;
}

// Theme the thumbnails type pager.
Drupal.theme.prototype.viewsJqfxPagerthumbnails = function (classes, idx, slide, settings) {
  var href = '#';
  if (settings.thumbnails_pager_click_to_page) {
    href = $(slide).find('a').attr('href');
  }
  var img = $(slide).find('img')
  return '<div class="' + classes + '"><a href="' + href + '"><img src="' + $(img).attr('src') + '" alt="' + $(img).attr('alt') + '" title="' + $(img).attr('title') + '"/></a></div>';
}

// Make some adjustments for thumbnails pagers.
function viewsJqfxCyclePagerthumbnailsSettingsAlter(settings) {
  if (settings.thumbnails_pager_click_to_page) {
    settings.opts.allowPagerClickBubble = true;
    settings.opts.pagerEvent = "mouseover";
  }
  return settings;
}

// Theme the numbered type pager.
Drupal.theme.prototype.viewsJqfxPagernumbered = function (classes, idx, slide, settings) {
  var href = '#';
  if (settings.numbered_pager_click_to_page) {
    href = $(slide).find('a').attr('href');
  }
  return '<div class="' + classes + '"><a href="' + href + '">' + (idx+1) + '</a></div>';
}

// Make some adjustments for numbered pagers.
function viewsJqfxCyclePagernumberedSettingsAlter(settings) {
  if (settings.numbered_pager_click_to_page) {
    settings.opts.allowPagerClickBubble = true;
    settings.opts.pagerEvent = "mouseover";
  }
  return settings;
}

// Theme the fields type pager.
Drupal.theme.prototype.viewsJqfxPagerfields = function (classes, idx, slide, settings) {
  return '#views_jqfx_cycle_div_pager_item_' + settings.vss_id + '_' + idx;
}

// Verify that the value is a number.
function IsNumeric(sText) {
  var ValidChars = "0123456789";
  var IsNumber=true;
  var Char;

  for (var i=0; i < sText.length && IsNumber == true; i++) {
    Char = sText.charAt(i);
    if (ValidChars.indexOf(Char) == -1) {
      IsNumber = false;
    }
  }
  return IsNumber;
}

/**
 * Cookie Handling Functions
 */
function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else {
    var expires = "";
  }
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) {
      return c.substring(nameEQ.length,c.length);
    }
  }
  return null;
}

function eraseCookie(name) {
  createCookie(name,"",-1);
}

/**
 * Checks to see if the slide is visible enough.
 * elem = element to check.
 * type = The way to calculate how much is visible.
 * amountVisible = amount that should be visible. Either in percent or px. If
 *                it's not defined then all of the slide must be visible.
 *
 * Returns true or false
 */
function viewsJqfxCycleIsVisible(elem, type, amountVisible) {
  // Get the top and bottom of the window;
  var docViewTop = $(window).scrollTop();
  var docViewBottom = docViewTop + $(window).height();
  var docViewLeft = $(window).scrollLeft();
  var docViewRight = docViewLeft + $(window).width();

  // Get the top, bottom, and height of the slide;
  var elemTop = $(elem).offset().top;
  var elemHeight = $(elem).height();
  var elemBottom = elemTop + elemHeight;
  var elemLeft = $(elem).offset().left;
  var elemWidth = $(elem).width();
  var elemRight = elemLeft + elemWidth;
  var elemArea = elemHeight * elemWidth;

  // Calculate what's hiding in the slide.
  var missingLeft = 0;
  var missingRight = 0;
  var missingTop = 0;
  var missingBottom = 0;

  // Find out how much of the slide is missing from the left.
  if (elemLeft < docViewLeft) {
    missingLeft = docViewLeft - elemLeft;
  }

  // Find out how much of the slide is missing from the right.
  if (elemRight > docViewRight) {
    missingRight = elemRight - docViewRight;
  }

  // Find out how much of the slide is missing from the top.
  if (elemTop < docViewTop) {
    missingTop = docViewTop - elemTop;
  }

  // Find out how much of the slide is missing from the bottom.
  if (elemBottom > docViewBottom) {
    missingBottom = elemBottom - docViewBottom;
  }

  // If there is no amountVisible defined then check to see if the whole slide
  // is visible.
  if (type == 'full') {
    return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom)
    && (elemBottom <= docViewBottom) &&  (elemTop >= docViewTop)
    && (elemLeft >= docViewLeft) && (elemRight <= docViewRight)
    && (elemLeft <= docViewRight) && (elemRight >= docViewLeft));
  }
  else if(type == 'vertical') {
    var verticalShowing = elemHeight - missingTop - missingBottom;

    // If user specified a percentage then find out if the current shown percent
    // is larger than the allowed percent.
    // Otherwise check to see if the amount of px shown is larger than the
    // allotted amount.
    if (amountVisible.indexOf('%')) {
      return (((verticalShowing/elemHeight)*100) >= parseInt(amountVisible));
    }
    else {
      return (verticalShowing >= parseInt(amountVisible));
    }
  }
  else if(type == 'horizontal') {
    var horizontalShowing = elemWidth - missingLeft - missingRight;

    // If user specified a percentage then find out if the current shown percent
    // is larger than the allowed percent.
    // Otherwise check to see if the amount of px shown is larger than the
    // allotted amount.
    if (amountVisible.indexOf('%')) {
      return (((horizontalShowing/elemWidth)*100) >= parseInt(amountVisible));
    }
    else {
      return (horizontalShowing >= parseInt(amountVisible));
    }
  }
  else if(type == 'area') {
    var areaShowing = (elemWidth - missingLeft - missingRight) * (elemHeight - missingTop - missingBottom);

    // If user specified a percentage then find out if the current shown percent
    // is larger than the allowed percent.
    // Otherwise check to see if the amount of px shown is larger than the
    // allotted amount.
    if (amountVisible.indexOf('%')) {
      return (((areaShowing/elemArea)*100) >= parseInt(amountVisible));
    }
    else {
      return (areaShowing >= parseInt(amountVisible));
    }
  }
}

})(jQuery)