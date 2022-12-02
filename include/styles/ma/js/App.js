(function ($) {
	"use strict";

	var App = function () {
		var o = this; // Create reference to this instance
		$(document).ready(function () {
			o.initialize();
		}); // Initialize app when document is ready

	};
	var p = App.prototype;

	// =========================================================================
	// MEMBERS
	// =========================================================================

	// Constant
	App.SCREEN_XS = 480;
	App.SCREEN_SM = 768;
	App.SCREEN_MD = 992;
	App.SCREEN_LG = 1200;

	// Private
	p._callFunctions = null;
	p._resizeTimer = null;

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function () {
		// Init events
		this._enableEvents();

		// Init base
		this._initBreakpoints();

		// Init components
		this._initInk();

		// Init accordion
		this._initAccordion();
	};

	// =========================================================================
	// EVENTS
	// =========================================================================

	// events
	p._enableEvents = function () {
		var o = this;

		// Window events
		$(window).on('resize', function (e) {
			clearTimeout(o._resizeTimer);
			o._resizeTimer = setTimeout(function () {
				o._handleFunctionCalls(e);
			}, 300);
		});
	};

	// =========================================================================
	// JQUERY-KNOB
	// =========================================================================

	p.getKnobStyle = function (knob) {
		var holder = knob.closest('.knob');
		var options = {
			width: Math.floor(holder.outerWidth()),
			height: Math.floor(holder.outerHeight()),
			fgColor: holder.css('color'),
			bgColor: holder.css('border-top-color'),
			draw: function () {
				if (knob.data('percentage')) {
					$(this.i).val(this.cv + '%');
				}
			}
		};
		return options;
	};

	// =========================================================================
	// ACCORDION
	// =========================================================================

	p._initAccordion = function () {
		$('.panel-group .card .in').each(function () {
			var card = $(this).parent();
			card.addClass('expanded');
		});


		$('.panel-group').on('hide.bs.collapse', function (e) {
			var content = $(e.target);
			var card = content.parent();
			card.removeClass('expanded');
		});

		$('.panel-group').on('show.bs.collapse', function (e) {
			var content = $(e.target);
			var card = content.parent();
			var group = card.closest('.panel-group');

			group.find('.card.expanded').removeClass('expanded');
			card.addClass('expanded');
		});
	};

	// =========================================================================
	// INK EFFECT
	// =========================================================================

	p._initInk = function () {
		var o = this;

		$('.ink-reaction').on('click', function (e) {
			var bound = $(this).get(0).getBoundingClientRect();
			var x = e.clientX - bound.left;
			var y = e.clientY - bound.top;

			var color = o.getBackground($(this));
			var inverse = (o.getLuma(color) > 183) ? ' inverse' : '';
			
			var ink = $('<div class="ink' + inverse + '"></div>');
			var btnOffset = $(this).offset();
			var xPos = e.pageX - btnOffset.left;
			var yPos = e.pageY - btnOffset.top;

			ink.css({
				top: yPos,
				left: xPos
			}).appendTo($(this));

			window.setTimeout(function () {
				ink.remove();
			}, 1500);
		});
	};

	p.getBackground = function (item) {
		// Is current element's background color set?
		var color = item.css("background-color");
		var alpha = parseFloat(color.split(',')[3], 10);

		if ((isNaN(alpha) || alpha > 0.8) && color !== 'transparent') {
			// if so then return that color if it isn't transparent
			return color;
		}

		// if not: are you at the body element?
		if (item.is("body")) {
			// return known 'false' value
			return false;
		} else {
			// call getBackground with parent item
			return this.getBackground(item.parent());
		}
	};

	p.getLuma = function (color) {
		var rgba = color.substring(4, color.length - 1).split(',');
		var r = rgba[0];
		var g = rgba[1];
		var b = rgba[2];
		var luma = 0.2126 * r + 0.7152 * g + 0.0722 * b; // per ITU-R BT.709
		return luma;
	};

	// =========================================================================
	// DETECT BREAKPOINTS
	// =========================================================================

	p._initBreakpoints = function (alias) {
		var html = '';
		html += '<div id="device-breakpoints">';
		html += '<div class="device-xs visible-xs" data-breakpoint="xs"></div>';
		html += '<div class="device-sm visible-sm" data-breakpoint="sm"></div>';
		html += '<div class="device-md visible-md" data-breakpoint="md"></div>';
		html += '<div class="device-lg visible-lg" data-breakpoint="lg"></div>';
		html += '</div>';
		$('body').append(html);
	};

	p.isBreakpoint = function (alias) {
		return $('.device-' + alias).is(':visible');
	};
	p.minBreakpoint = function (alias) {
		var breakpoints = ['xs', 'sm', 'md', 'lg'];
		var breakpoint = $('#device-breakpoints div:visible').data('breakpoint');
		return $.inArray(alias, breakpoints) < $.inArray(breakpoint, breakpoints);
	};

	// =========================================================================
	// UTILS
	// =========================================================================

	p.callOnResize = function (func) {
		if (this._callFunctions === null) {
			this._callFunctions = [];
		}
		this._callFunctions.push(func);
		func.call();
	};

	p._handleFunctionCalls = function (e) {
		if (this._callFunctions === null) {
			return;
		}
		for (var i = 0; i < this._callFunctions.length; i++) {
			this._callFunctions[i].call();
		}
	};

	// =========================================================================
	// DEFINE NAMESPACE
	// =========================================================================

	window.materialadmin = window.materialadmin || {};
	window.materialadmin.App = new App;
}(jQuery)); // pass in (jQuery):


(function (namespace, $) {
	"use strict";

	var AppOffcanvas = function () {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function () {
			o.initialize();
		});

	};
	var p = AppOffcanvas.prototype;
	// =========================================================================
	// MEMBERS
	// =========================================================================

	p._timer = null;
	p._useBackdrop = null;

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function () {
		this._enableEvents();
	};

	// =========================================================================
	// EVENTS
	// =========================================================================

	p._enableEvents = function () {
		var o = this;

		// Window events
		$(window).on('resize', function (e) {
			o._handleScreenSize(e);
		});

		// Offcanvas events
		$('.offcanvas').on('refresh', function (e) {
			o.evalScrollbar(e);
		});
		$('[data-toggle="offcanvas"]').on('click', function (e) {
			e.preventDefault();
			o._handleOffcanvasOpen($(e.currentTarget));
		});$('[data-dismiss="offcanvas"]').on('click', function (e) {
			o._handleOffcanvasClose();
		});
		$('#base').on('click', '> .backdrop', function (e) {
			o._handleOffcanvasClose();
		});

		// Open active offcanvas buttons
		$('[data-toggle="offcanvas-left"].active').each(function () {
			o._handleOffcanvasOpen($(this));
		});
		$('[data-toggle="offcanvas-right"].active').each(function () {
			o._handleOffcanvasOpen($(this));
		});
	};

	// handlers
	p._handleScreenSize = function (e) {
		this.evalScrollbar(e);
	};

	// =========================================================================
	// HANDLERS
	// =========================================================================

	p._handleOffcanvasOpen = function (btn) {
		// When the button is active, the off-canvas is already open and sould be closed
		if (btn.hasClass('active')) {
			this._handleOffcanvasClose();
			return;
		}

		var id = btn.attr('href');

		// Set data variables
		this._useBackdrop = (btn.data('backdrop') === undefined) ? true : btn.data('backdrop');

		// Open off-canvas
		this.openOffcanvas(id);
		this.invalidate();
	};

	p._handleOffcanvasClose = function (e) {
		this.closeOffcanvas();
		this.invalidate();
	};

	// =========================================================================
	// OPEN OFFCANVAS
	// =========================================================================

	p.openOffcanvas = function (id) {
		// First close all offcanvas panes
		this.closeOffcanvas();

		// Activate selected offcanvas pane
		$(id).addClass('active');

		// Check if the offcanvas is on the left
		var leftOffcanvas = ($(id).closest('.offcanvas:first').length > 0);

		// Remove offcanvas-expanded to enable body scrollbar
		if (this._useBackdrop)
			$('body').addClass('offcanvas-expanded');

		// Define the width
		var width = $(id).width();
		if (width > $(document).width()) {
			width = $(document).width() - 8;
			$(id + '.active').css({'width': width});
		}
		width = (leftOffcanvas) ? width : '-' + width;

		// Translate position offcanvas pane
		var translate = 'translate(' + width + 'px, 0)';
		$(id + '.active').css({
			'-webkit-transform': translate,
			'-ms-transform': translate,
			'-o-transform': translate,
			'transform': translate
		});
	};

	// =========================================================================
	// CLOSE OFFCANVAS
	// =========================================================================

	p.closeOffcanvas = function () {
		// Remove expanded on all offcanvas buttons
		$('[data-toggle="offcanvas"]').removeClass('expanded');

		// Remove offcanvas active state
		$('.offcanvas-pane').removeClass('active');//.removeAttr('style');
		$('.offcanvas-pane').css({
			'-webkit-transform': '',
			'-ms-transform': '',
			'-o-transform': '',
			'transform': ''
		});
	};

	// =========================================================================
	// OFFCANVAS BUTTONS
	// =========================================================================

	p.toggleButtonState = function () {
		// Activate the active offcanvas pane
		var id = $('.offcanvas-pane.active').attr('id');
		$('[data-toggle="offcanvas"]').removeClass('active');
		$('[href="#' + id + '"]').addClass('active');
	};

	// =========================================================================
	// BACKDROP
	// =========================================================================

	p.toggleBackdropState = function () {
		// Clear the timer that removes the keyword
		if ($('.offcanvas-pane.active').length > 0 && this._useBackdrop) {
			this._addBackdrop();
		}
		else {
			this._removeBackdrop();
		}
	};

	p._addBackdrop = function () {
		if ($('#base > .backdrop').length === 0 && $('#base').data('backdrop') !== 'hidden') {
			$('<div class="backdrop"></div>').hide().appendTo('#base').fadeIn();
		}
	};

	p._removeBackdrop = function () {
		$('#base > .backdrop').fadeOut(function () {
			$(this).remove();
		});
	};

	// =========================================================================
	// BODY SCROLLING
	// =========================================================================

	p.toggleBodyScrolling = function () {
		clearTimeout(this._timer);
		if ($('.offcanvas-pane.active').length > 0 && this._useBackdrop) {
			// Add body padding to prevent visual jumping
			var scrollbarWidth = this.measureScrollbar();
			var bodyPad = parseInt(($('body').css('padding-right') || 0), 10);
			if (scrollbarWidth !== bodyPad) {
				$('body').css('padding-right', bodyPad + scrollbarWidth);
				$('.headerbar').css('padding-right', bodyPad + scrollbarWidth);
			}
		}
		else {
			this._timer = setTimeout(function () {
				// Remove offcanvas-expanded to enable body scrollbar
				$('body').removeClass('offcanvas-expanded');
				$('body').css('padding-right', '');
				$('.headerbar').removeClass('offcanvas-expanded');
				$('.headerbar').css('padding-right', '');
			}, 330);
		}
	};

	// =========================================================================
	// INVALIDATE
	// =========================================================================

	p.invalidate = function () {
		this.toggleButtonState();
		this.toggleBackdropState();
		this.toggleBodyScrolling();
		this.evalScrollbar();
	};

	// =========================================================================
	// SCROLLBAR
	// =========================================================================

	p.evalScrollbar = function () {
		if (!$.isFunction($.fn.nanoScroller)) {
			return;
		}
		
		// Check if there is a menu
		var menu = $('.offcanvas-pane.active');
		if (menu.length === 0)
			return;

		// Get scrollbar elements
		var menuScroller = $('.offcanvas-pane.active .offcanvas-body');
		var parent = menuScroller.parent();

		// Add the scroller wrapper
		if (parent.hasClass('nano-content') === false) {
			menuScroller.wrap('<div class="nano"><div class="nano-content"></div></div>');
		}
		
		// Set the correct height
		var height = $(window).height() - menu.find('.nano').position().top;
		var scroller = menuScroller.closest('.nano');
		scroller.css({height: height});

		// Add the nanoscroller
		scroller.nanoScroller({preventPageScrolling: true});
	};

	// =========================================================================
	// UTILS
	// =========================================================================

	p.measureScrollbar = function () {
		var scrollDiv = document.createElement('div');
		scrollDiv.className = 'modal-scrollbar-measure';
		$('body').append(scrollDiv);
		var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
		$('body')[0].removeChild(scrollDiv);
		return scrollbarWidth;
	};

	// =========================================================================
	// DEFINE NAMESPACE
	// =========================================================================

	window.materialadmin.AppOffcanvas = new AppOffcanvas;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):


(function(namespace, $) {
	"use strict";

	var AppCard = function() {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function() {
			o.initialize();
		});

	};
	var p = AppCard.prototype;

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function() {};

	// =========================================================================
	// CARD LOADER
	// =========================================================================

	p.addCardLoader = function (card) {
		
		card = (typeof card === 'object')?card:$('body');
		
		var container = $('<div class="card-loader"></div>').appendTo(card);
		container.hide().fadeIn();
		var opts = {
			lines: 20, // The number of lines to draw
			length: 2, // The length of each line
			width: 5, // The line thickness
			radius: 16, // The radius of the inner circle
			corners: 1, // Corner roundness (0..1)
			rotate: 13, // The rotation offset
			direction: 1, // 1: clockwise, -1: counterclockwise
			color: '#673ab7', // #rgb or #rrggbb or array of colors
			speed: 2, // Rounds per second
			trail: 76, // Afterglow percentage
			shadow: false, // Whether to render a shadow
			hwaccel: false, // Whether to use hardware acceleration
			className: 'spinner', // The CSS class to assign to the spinner
			zIndex: 2e9, // The z-index (defaults to 2000000000)
		};
		var spinner = new Spinner(opts).spin(container.get(0));
		$(card).data('card-spinner', spinner);
	};

	p.removeCardLoader = function (card) {

		card = (typeof card === 'object')?card:$('body');
		
		var spinner = $(card).data('card-spinner');
		var loader = $(card).find('.card-loader');
		loader.fadeOut(function () {
			spinner.stop();
			loader.remove();
		});
	};
	
	// =========================================================================
	// CARD COLLAPSE
	// =========================================================================

	p.toggleCardCollapse = function (card, duration) {
		duration = typeof duration !== 'undefined' ? duration : 400;
		var dispatched = false;
		card.find('.nano').slideToggle(duration);
		card.find('.card-body').slideToggle(duration, function () {
			if (dispatched === false) {
				$('#COLLAPSER').triggerHandler('card.bb.collapse', [!$(this).is(":visible")]);
				dispatched = true;
			}
		});
		card.toggleClass('card-collapsed');
	};

	// =========================================================================
	// CARD REMOVE
	// =========================================================================

	p.removeCard = function (card) {
		card.fadeOut(function () {
			card.remove();
		});
	};
	
	// =========================================================================
	// DEFINE NAMESPACE
	// =========================================================================

	window.materialadmin.AppCard = new AppCard;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):


(function(namespace, $) {
	"use strict";

	var AppVendor = function() {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function() {
			o.initialize();
		});

	};
	var p = AppVendor.prototype;

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function() {
		this._initScroller();
		this._initTabs();
		this._initTooltips();
		this._initPopover();
		this._initSortables();
	};

	// =========================================================================
	// SCROLLER
	// =========================================================================

	p._initScroller = function () {
		if (!$.isFunction($.fn.nanoScroller)) {
			return;
		}

		$.each($('.scroll'), function (e) {
			var holder = $(this);
			materialadmin.AppVendor.addScroller(holder);
		});

		materialadmin.App.callOnResize(function () {
			$.each($('.scroll-xs'), function (e) {
				var holder = $(this);
				if(!holder.is(":visible")) return;
				
				if (materialadmin.App.minBreakpoint('xs')) {
					materialadmin.AppVendor.removeScroller(holder);
				}
				else {
					materialadmin.AppVendor.addScroller(holder);
				}
			});

			$.each($('.scroll-sm'), function (e) {
				var holder = $(this);
				if(!holder.is(":visible")) return;
				
				if (materialadmin.App.minBreakpoint('sm')) {
					materialadmin.AppVendor.removeScroller(holder);
				}
				else {
					materialadmin.AppVendor.addScroller(holder);
				}
			});

			$.each($('.scroll-md'), function (e) {
				var holder = $(this);
				if(!holder.is(":visible")) return;
				
				if (materialadmin.App.minBreakpoint('md')) {
					materialadmin.AppVendor.removeScroller(holder);
				}
				else {
					materialadmin.AppVendor.addScroller(holder);
				}
			});

			$.each($('.scroll-lg'), function (e) {
				var holder = $(this);
				if(!holder.is(":visible")) return;
				
				if (materialadmin.App.minBreakpoint('lg')) {
					materialadmin.AppVendor.removeScroller(holder);
				}
				else {
					materialadmin.AppVendor.addScroller(holder);
				}
			});
		});
	};

	p.addScroller = function (holder) {
		holder.wrap('<div class="nano"><div class="nano-content"></div></div>');

		var scroller = holder.closest('.nano');
		scroller.css({height: holder.outerHeight()});
		scroller.nanoScroller();

		holder.css({height: 'auto'});
	};

	p.removeScroller = function (holder) {
		if (holder.parent().parent().hasClass('nano') === false) {
			return;
		}

		holder.parent().parent().nanoScroller({destroy: true});

		holder.parent('.nano-content').replaceWith(holder);
		holder.parent('.nano').replaceWith(holder);
		holder.attr('style', '');
	};
	
	// =========================================================================
	// SORTABLE
	// =========================================================================

	p._initSortables = function () {
		if (!$.isFunction($.fn.sortable)) {
			return;
		}

		$('[data-sortable="true"]').sortable({
			placeholder: "ui-state-highlight",
			delay: 100,
			start: function (e, ui) {
				ui.placeholder.height(ui.item.outerHeight() - 1);
			}
		});

	};
	
	// =========================================================================
	// TABS
	// =========================================================================

	p._initTabs = function () {
		if (!$.isFunction($.fn.tab)) {
			return;
		}
		$('[data-toggle="tabs"] a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
	};
	
	// =========================================================================
	// TOOLTIPS
	// =========================================================================

	p._initTooltips = function () {
		if (!$.isFunction($.fn.tooltip)) {
			return;
		}
		$('[data-toggle="tooltip"]').tooltip({container: 'body'});
	};

	// =========================================================================
	// POPOVER
	// =========================================================================

	p._initPopover = function () {
		if (!$.isFunction($.fn.popover)) {
			return;
		}
		$('[data-toggle="popover"]').popover({container: 'body'});
	};
	
	// =========================================================================
	// DEFINE NAMESPACE
	// =========================================================================

	window.materialadmin.AppVendor = new AppVendor;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):


(function(namespace, $) {
	"use strict";

	var AppForm = function() {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function() {
			o.initialize();
		});

	};
	var p = AppForm.prototype;

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function() {
		// Init events
		this._enableEvents();
		
		this._initRadioAndCheckbox();
		this._initFloatingLabels();
		this._initValidation();
		this._initLabels();

	};
	
	// =========================================================================
	// EVENTS
	// =========================================================================

	// events
	p._enableEvents = function () {
		var o = this;

		// Link submit function
		$('[data-submit="form"]').on('click', function (e) {
			e.preventDefault();
			var formId = $(e.currentTarget).attr('href');
			$(formId).submit();
		});
		
		// Init textarea autosize
		$('textarea.autosize').on('focus', function () {
			$(this).autosize({append: ''});
		});
	};
	
	// =========================================================================
	// RADIO AND CHECKBOX LISTENERS
	// =========================================================================

	p._initRadioAndCheckbox = function () {
		// Add a span class the styled checkboxes and radio buttons for correct styling
		$('.checkbox-styled input, .radio-styled input').each(function () {
			if ($(this).next('span').length === 0) {
				$(this).after('<span></span>');
			}
		});
	};
	
	// =========================================================================
	// NORMAL LABELS cx 15 mei 2018
	// =========================================================================

	p._initLabels = function () {
		$('.form-control').on('focus',function(){
	        $(this).parents('.form-group').children('label').addClass('mycolor'); 
	    }).on('focusout',function(){
	        $(this).parents('.form-group').children('label').removeClass('mycolor'); 
	    });

	    $('.form-group').on('mouseover',function(){
	        if($(this).find('.form-control')){
	            $(this).children('label').addClass('mycolor');
	        }
	    }).on('mouseout',function(){
	        if($(this).find('.form-control')){
	            $(this).children('label').removeClass('mycolor');    
	        }
	    });
	};

	// =========================================================================
	// FLOATING LABELS
	// =========================================================================

	p._initFloatingLabels = function () {
		var o = this;

		$('.floating-label .form-control').on('keyup change', function (e) {
			var input = $(e.currentTarget);

			if ($.trim(input.val()) !== '') {
				input.addClass('dirty').removeClass('static');
			} else {
				input.removeClass('dirty').removeClass('static');
			}
		});

		$('.floating-label .form-control').each(function () {
			var input = $(this);

			if ($.trim(input.val()) !== '') {
				input.addClass('static').addClass('dirty');
			}
		});

		$('.form-horizontal .form-control').each(function () {
			$(this).after('<div class="form-control-line"></div>');
		});
	};
	
	// =========================================================================
	// VALIDATION
	// =========================================================================

	p._initValidation = function () {
		if (!$.isFunction($.fn.validate)) {
			return;
		}
		$.validator.setDefaults({
			highlight: function (element) {
				$(element).closest('.form-group').addClass('has-error');
			},
			unhighlight: function (element) {
				$(element).closest('.form-group').removeClass('has-error');
			},
			errorElement: 'span',
			errorClass: 'help-block',
			errorPlacement: function (error, element) {
				if (element.parent('.input-group').length) {
					error.insertAfter(element.parent());
				}
				else if (element.parent('label').length) {
					error.insertAfter(element.parent());
				}
				else {
					error.insertAfter(element);
				}
			}
		});

		$('.form-validate').each(function () {
			var validator = $(this).validate();
			$(this).data('validator', validator);
		});
	};

	p.loadPostData = function(url,data,target,card){
        //card = (card.length)?card:target;

        materialadmin.AppCard.addCardLoader(card);
        $(target).load(url,data,function(response, status, xhr){
        	
            if ( status == "error" )  console.log(xhr.status + " " + xhr.statusText );
            materialadmin.AppCard.removeCardLoader(card);
        });
    }
	
	// =========================================================================
	// DEFINE NAMESPACE
	// =========================================================================

	window.materialadmin.AppForm = new AppForm;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):


(function($){
    "use strict";

    var App = function () {
        var o = this; // Create reference to this instance
        $(document).ready(function () {
            o.initialize();
        }); // Initialize app when document is ready

    };
    var p = App.prototype;

    p.initialize = function () { };


    p.loadData = function(Options){

        var Settings = {
            url: location.href,
            type: "POST",
            data:{},
            target: document.getElementsByTagName("BODY")[0],
            area: document.getElementsByTagName("BODY")[0]
        };
        
        Options = Options || {};

        $.extend( Settings, Options );

        materialadmin.AppCard.addCardLoader(Settings.area);
        $(Settings.target).load(Settings.url,Settings.data,function(response, status, xhr){

            if ( status == "error" )  console.log(xhr.status + " " + xhr.statusText );

            materialadmin.AppCard.removeCardLoader(Settings.area);
        });
    }

    p.popup = function(Options){
        
        var Settings = {
            url: location.href,
            type: "POST",
            data:{},
            modal:$('#popupcx'),
            target: $('#bodycx'),
            popup_type: 1,
            mode:'',
            title:'Popup window',
            area: document.getElementsByTagName("BODY")[0],
        };
        
        Options = Options || {};

        $.extend( Settings, Options );
       
        if(Settings.popup_type==2 && Settings.modal.attr('id')=='popupcx'){
            Settings.modal = $('#popupcx2');
            Settings.target = $('#bodycx2');
        }

        Settings.modal.find('.modal-title').text(Settings.title);

        if(Settings.mode=='md' && (Settings.modal.attr('id')=='popupcx' || Settings.modal.attr('id')=='popupcx2'))
            Settings.modal.children('.modal-dialog').removeClass('modal-lg modal-md').addClass('modal-md');
        else if(Settings.mode=='lg' && (Settings.modal.attr('id')=='popupcx' || Settings.modal.attr('id')=='popupcx2'))
            Settings.modal.children('.modal-dialog').removeClass('modal-lg modal-md').addClass('modal-lg');
        else if(Settings.popup_type==2  && Settings.modal.attr('id')=='popupcx2')
            Settings.modal.children('.modal-dialog').removeClass('modal-lg modal-md').addClass('modal-lg');
        else if(Settings.popup_type==2  && Settings.modal.attr('id')=='popupcx')
            Settings.modal.children('.modal-dialog').removeClass('modal-lg modal-md');

        materialadmin.AppCard.addCardLoader(Settings.area);
        $(Settings.target).load(Settings.url,Settings.data,function(response, status, xhr){

            if ( status == "error" )  console.log(xhr.status + " " + xhr.statusText );

            $(Settings.modal).modal({show:true});

            materialadmin.AppCard.removeCardLoader(Settings.area);
        });
    }

    window.atmedic = window.atmedic || {};
    window.atmedic.App = new App;

}(jQuery));

(function(){

    $(window).load(function() {
        setTimeout(function() {
            $("body").addClass("loaded")
        }, 200)
    });

    if(typeof(Waves) !== 'undefined'){
        Waves.attach('.btn:not(.btn-icon):not(.btn-float)');
        Waves.attach('.btn-icon, .btn-float', ['waves-circle', 'waves-float']);
        Waves.init();
    }
})();