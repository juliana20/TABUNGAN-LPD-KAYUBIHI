
"use strict";

(function($) {
		function from_css(elem, props) {
			var sum = 0;
			props.forEach(function(p) {
					sum += parseInt(elem.css(p).match(/\d+/)[0]);
				});
			return sum;
		}
		
		function get_sizes(elem) {
			return {
				width: from_css(elem, ["margin-left", "margin-right", "padding-left", "padding-right", "border-left-width", "border-right-width"]),
				height: from_css(elem, ["margin-top", "margin-bottom", "padding-top", "padding-bottom", "border-top-width", "border-bottom-width"])
			};
		}
		
		function make_fullscreen(elem) {
			var win_h = $(window).innerHeight();
			var win_w = $(window).innerWidth();
			
			var dialog = elem.find(".modal-dialog");
			dialog.css("width", "initial");
			dialog.css("height", "initial");
			dialog.css("max-width", "initial");
			dialog.css("margin", "5px");
			
			var d = get_sizes(dialog);
			var d_header = elem.find(".modal-header");
			var d_footer = elem.find(".modal-footer");
			var d_body = elem.find(".modal-body");
			
			/*var body_h = win_h - (d_body.outerHeight() - d_body.height()) - d.height;
			if (d_header.size()){
				body_h -= d_header.outerHeight();
			}
			if (d_footer.size()){
				body_h -= d_footer.outerHeight();
			}
			d_body.css("overflow-y", "scroll");
			d_body.height(body_h);
			
			console.log(body_h);*/

			if (dialog.outerHeight() > win_h){
				d_body.css("overflow-y", "scroll");
				d_body.height((win_h - 27) - (d_header.size() ? d_header.outerHeight() : 0) - (d_footer.size() ? d_footer.outerHeight() : 0));
			}
			
			return elem;
		};
		
		$.fn.modal_fullscreen = function(){
				if (this.size()){
					make_fullscreen(this);
				}
				return this;
			};
		
		$.fn.drags = function(opt) {	
			opt = $.extend({
				handle: "",
				cursor: "move"
			}, opt);
	
			if (opt.handle === "") {
				var $el = this;
			} else {
				var $el = this.find(opt.handle);
			}
	
			return $el.css('cursor', opt.cursor).on("mousedown", function(e) {
				if (opt.handle === "") {
					var $drag = $(this).addClass('draggable');
				} else {
					var $drag = $(this).addClass('active-handle').parent().addClass('draggable');
				}
				var z_idx = $drag.css('z-index'),
					drg_h = $drag.outerHeight(),
					drg_w = $drag.outerWidth(),
					pos_y = $drag.offset().top + drg_h - e.pageY,
					pos_x = $drag.offset().left + drg_w - e.pageX;
				$drag.css('z-index', 1000).parents().on("mousemove", function(e) {
					$('.draggable').offset({
						top: e.pageY + pos_y - drg_h,
						left: e.pageX + pos_x - drg_w
					}).on("mouseup", function() {
						$(this).removeClass('draggable').css('z-index', z_idx);
					});
				});
				e.preventDefault(); // disable selection
			}).on("mouseup", function() {
				if (opt.handle === "") {
					$(this).removeClass('draggable');
				} else {
					$(this).removeClass('active-handle').parent().removeClass('draggable');
				}
			});	
		}
	})(jQuery);
	
/* ajax_modal: by tumasdan */
var ajax_modal = {
		init: function(){
				$( document ).on('click', 'a[data-toggle="ajax-modal"]', function(e) {
						e.preventDefault();
						
						var $this = $( this ),
							$remote = $this.data('remote') || $this.attr('href')
							;
							
						ajax_modal.show.call($this, $remote);
					});
					
				//$( '#ajax-modal' ).on("hide.bs.modal", function(e){ $( window ).trigger( "resize" ); });
			},
		show: function( remote, fn, scope ){
				ajax_modal.hide()
				
				var _opener = this;
				var _modal = $("<div class=\"modal\" \
						id=\"ajax-modal\" \
						role=\"dialog\" \
						tabindex=\"-1\" \
						aria-hidden=\"true\">\
							<div class=\"modal-dialog modal-sm\" \
								role=\"document\">\
								<div class=\"modal-content\">\
									<div class=\"modal-body\">\
										<center class=\"text-primary\">\
											<i class=\"fa fa-lg fa-circle-o-notch fa-spin\"></i> Memuat...\
										</center>\
									</div>\
								</div>\
							</div>\
						</div>");
				
				$("body").append(_modal);
				_modal.modal({
						backdrop: false,
						keyboard: true,
						show: false
					});
				
				_modal.on('shown.bs.modal', function (e) {
						setTimeout(function(){
								_modal.load(remote, function(response, status, xhr){
										//_modal.find('.modal-dialog').drags();
										
										try {
											if (_opener.data('modal-fullscreen') == true){
												if (!_modal.hasClass('modal-fullscreen')){
													_modal.addClass('modal-fullscreen');
												}
											}
										} catch(e){}
										if (_modal.hasClass('modal-fullscreen')){
											_modal.modal_fullscreen();
										}
										
										if ($.isFunction(fn)){
											setTimeout(function(){
													fn.call(scope || ajax_modal);
												}, 90);
										}
									});
							}, 90);
					});
				_modal.on('hidden.bs.modal', function (e) {
						ajax_modal.get_modal().remove();
						
						if ($('.modal:visible').size()){
							if (!$('body').hasClass('modal-open')){
								$('body').addClass('modal-open');
							}
						}
					});
				_modal.modal('show');
				
				return ajax_modal
			},
		hide: function( fn, scope ){
				ajax_modal.get_modal().modal('hide');
				
				if( $.isFunction(fn) ){
					setTimeout(function(){
							fn.call(scope || ajax_modal);
						}, 90);
				}
				
				return ajax_modal
			},
		get_modal: function(){
				return $('#ajax-modal');
			}
	};
/* ./ajax_modal: by tumasdan */

/* lookup_ajax_modal: by tumasdan */
var lookup_ajax_modal = {
		init: function(){
				$( document ).on('click', 'a[data-toggle="lookup-ajax-modal"]', function(e) {
						e.preventDefault();
						
						var $this = $( this ),
							$remote = $this.data('remote') || $this.attr('href')
							;
							
						lookup_ajax_modal.show.call($this, $remote)
					});
			},
		show: function( remote, fn, scope ){
				lookup_ajax_modal.hide();
				
				var _opener = this;
				var _modal = $("<div class=\"modal\" \
						id=\"lookup-ajax-modal\" \
						role=\"dialog\" \
						tabindex=\"-1\" \
						aria-hidden=\"true\">\
							<div class=\"modal-dialog modal-sm\" \
								role=\"document\">\
								<div class=\"modal-content\">\
									<div class=\"modal-body\">\
										<center class=\"text-primary\">\
											<i class=\"fa fa-lg fa-circle-o-notch fa-spin\"></i> Memuat...\
										</center>\
									</div>\
								</div>\
							</div>\
						</div>");
				
				$("body").append(_modal);
				_modal.modal({
						backdrop: false,
						keyboard: true,
						show: false
					});
				
				_modal.on('shown.bs.modal', function (e) {
						setTimeout(function(){
								_modal.load(remote, function(response, status, xhr){
										//_modal.find('.modal-dialog').drags();
										
										try {
											if (_opener.data('modal-fullscreen') == true){
												if (!_modal.hasClass('modal-fullscreen')){
													_modal.addClass('modal-fullscreen');
												}
											}
										} catch(e){}
										if (_modal.hasClass('modal-fullscreen')){
											_modal.modal_fullscreen();
										}
										
										lookup_ajax_modal.dev_init.call(lookup_ajax_modal);
										
										if ($.isFunction(fn)){
											setTimeout(function(){
													fn.call(scope || lookup_ajax_modal);
												}, 90);
										}
									});
							}, 90);
					});
				_modal.on('hidden.bs.modal', function (e) {
						lookup_ajax_modal.get_modal().remove();
						
						if ($('.modal:visible').size()){
							if (!$('body').hasClass('modal-open')){
								$('body').addClass('modal-open');
							}
						}
					});
				_modal.modal('show');
				
				return lookup_ajax_modal
			},
		hide: function( fn, scope ){
				lookup_ajax_modal.get_modal().modal('hide');
				
				if( $.isFunction(fn) ){
					setTimeout(function(){
							fn.call(scope || lookup_ajax_modal);
						}, 90);
				}
				
				return lookup_ajax_modal
			},
		get_modal: function(){
				return $('#lookup-ajax-modal');
			},
		dev_init: function(){
				try {
					dev_panels.init();
					dev_accordion.init();
					tabs.init();
					dev_forms.init();
					datatables.init();    
					scroll.init();
				} catch(e){
					alert("ERROR\n" + e.message);
				}
				
				return lookup_ajax_modal;
			}
	};
/* ./lookup_ajax_modal: by tumasdan */

/* lookup_ajax_modal: by tumasdan */
var form_ajax_modal = {
		init: function(){
				$( document ).on('click', 'a[data-toggle="form-ajax-modal"]', function(e) {
						e.preventDefault();
						
						var $this = $( this ),
							$remote = $this.data('remote') || $this.attr('href')
							;
							
						form_ajax_modal.show.call($this, $remote)
					});
			},
		show: function( remote, fn, scope ){
				
				form_ajax_modal.hide()
				
				var _opener = this;
				var _modal = $("<div class=\"modal\" \
						id=\"form-ajax-modal\" \
						role=\"dialog\" \
						tabindex=\"-1\" \
						aria-hidden=\"true\">\
							<div class=\"modal-dialog modal-sm\" \
								role=\"document\">\
								<div class=\"modal-content\">\
									<div class=\"modal-body\">\
										<center class=\"text-primary\">\
											<i class=\"fa fa-lg fa-circle-o-notch fa-spin\"></i> Memuat...\
										</center>\
									</div>\
								</div>\
							</div>\
						</div>");
				
				$("body").append(_modal);
				_modal.modal({
						backdrop: false,
						keyboard: true,
						show: false
					});
				
				/*
				_modal.on('shown.bs.modal', function (e) {
						setTimeout(function(){
								_modal.load(remote, function(response, status, xhr){
										//_modal.find('.modal-dialog').drags();
										
										try {
											if (_opener.data('modal-fullscreen') == true){
												if (!_modal.hasClass('modal-fullscreen')){
													_modal.addClass('modal-fullscreen');
												}
											}
										} catch(e){}
										if (_modal.hasClass('modal-fullscreen')){
											_modal.modal_fullscreen();
										}
										
										form_ajax_modal.dev_init.call(form_ajax_modal);
										
										if ($.isFunction(fn)){
											setTimeout(function(){
													fn.call(scope || form_ajax_modal);
												}, 90);
										}
									});
							}, 90);
					});
				*/
				_modal.on('shown.bs.modal', function (e) {
						try {
							if (_opener.data('modal-fullscreen') == true){
								if (!_modal.hasClass('modal-fullscreen')){
									_modal.addClass('modal-fullscreen');
								}
							}
						} catch(e){}
						
						if (_modal.hasClass('modal-fullscreen')){
							_modal.modal_fullscreen();
						} else {
							//_modal.find('.modal-dialog').drags();
						}
						
						form_ajax_modal.dev_init.call(form_ajax_modal);
						
						if ($.isFunction(fn)){
							setTimeout(function(){
									fn.call(scope || form_ajax_modal);
								}, 90);
						}
					});
				_modal.on('hidden.bs.modal', function (e) {
						form_ajax_modal.get_modal().remove();
						
						if ($('.modal:visible').size()){
							if (!$('body').hasClass('modal-open')){
								$('body').addClass('modal-open');
							}
						}
					});
				//_modal.modal('show');
				
				setTimeout(function(){
						if (!$('body').hasClass('modal-loading')){ $('body').addClass('modal-loading'); }
							
						$.get(remote).done(function(response, status, xhr){
								_modal.html(response);
								_modal.modal('show');
							}).fail(function(xhr, status, error){
								_modal.find(".modal-body").html(error);
								_modal.modal('show');
							}).always(function(xhr, status, error){
								$('body').removeClass('modal-loading');
							});
					}, 90);
				
				return form_ajax_modal
			},
		hide: function( fn, scope ){
				form_ajax_modal.get_modal().modal('hide');
				
				if( $.isFunction(fn) ){
					setTimeout(function(){
							fn.call(scope || form_ajax_modal);
						}, 90);
				}
				
				return form_ajax_modal;
			},
		post: function( fn, scope ){
				var _form = form_ajax_modal.get_modal().find("form");
				
				if (_form.size()){
					var remote = _form.attr( "action" );
					var data = _form.serialize();
					
					$.post(remote, data)
						.done(function(response, status, xhr){
							form_ajax_modal.get_modal().html(response);
							
							if (form_ajax_modal.get_modal().hasClass('modal-fullscreen')){
								form_ajax_modal.get_modal().modal_fullscreen();
							}							
							//form_ajax_modal.get_modal().find('.modal-dialog').drags();
							
							form_ajax_modal.dev_init.call(form_ajax_modal);
							
						}).fail(function(xhr, status, error){
							alert("ERROR\n" + error);
						}).always(function(xhr, status, error){
							if ($.isFunction(fn)){
								setTimeout(function(){
										fn.call(scope || form_ajax_modal);
									}, 90);
							}
						});
				}
				
				return form_ajax_modal;
			},
		get_modal: function(){
				return $('#form-ajax-modal');
			},
		dev_init: function(){
				try {
					dev_panels.init();
					dev_accordion.init();
					tabs.init();
					dev_forms.init();
					datatables.init();    
					scroll.init();
				} catch(e){
					alert("ERROR\n" + e.message);
				}
				
				return form_ajax_modal;
			}
	};
/* ./form_ajax_modal: by tumasdan */

(function($){
		$(document).ready(function(e) {
            ajax_modal.init();
			lookup_ajax_modal.init();
			form_ajax_modal.init();
        });
	})(jQuery);



