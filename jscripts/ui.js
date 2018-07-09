var UI = new function() {
    var self = this;
    this.last_tip_id = null;
    this.initPopUpWindow = function(settings) {
    	//alert(typeof settings['classes']);
    	// удаляем старые окошки
    	$('#ui_modal_window_container').remove();
    	$('#ui_modal_window_background').remove();
    	
        // initiating background
        var modal_background = $('<div>').attr('id','ui_modal_window_background')
        .css('display','none').addClass('ui_modal_window_background').css('position','fixed').css('height','100%')
        .css('width','100%').css('background', '#000').css('opacity','0.7')
        .css('top', '0px').css('z-index', '999').prependTo('BODY');

        // контейнер для блока
        var modal_window_container = $('<div>').attr('id', 'ui_modal_window_container')
        .css('display','none');//.css('z-index','1000').css('width','100%').css('top','5%').css('position','fixed');
    //	alert(settings.classes);

        if(settings.classes != '') {
        	if(typeof settings.classes == 'string') {
        		var classes = [settings.classes];
        	} else if ( typeof settings.classes == 'object') {
        		var classes = settings.classes;
        	}
        	if(classes != undefined) {
        		for(var num in classes) {
        			modal_background.addClass('ui_modal_window_background_' + classes[num]);
        			modal_window_container.addClass('ui_modal_window_container_' + classes[num]);
        		}
        	}
        }
        var modal_window_block = $('<div>').attr('id', 'ui_modal_window_block');
        var modal_window_content = $('<div>').attr('id','ui_modal_window_content');
        var modal_window_header = $('<div>').attr('id','ui_modal_window_header');
        if(settings.full_page_button != undefined && settings.full_page_url != undefined ) {
        	$('<IMG>').attr('src',settings.full_page_button).click(function(){
        		window.open(settings.full_page_url);
        		return false;
        	}).appendTo(modal_window_header);
        }
        if(settings.close_button != undefined ) {
        	$('<IMG>').attr('src',settings.close_button).click(self.popup_close).appendTo(modal_window_header);
        }
        var modal_window_control = $('<div>').attr('id','ui_modal_window_control');
        // добавляем обработчик клика по фону
        modal_background.click(function() {
            UI.popup_close();
        });
        modal_window_container.click(function(event){
        	var container_offset = modal_window_block.offset();
        	if(event.pageX < container_offset.left || event.pageX > container_offset.left + modal_window_block.width() ) {
        		self.popup_close();
        	}
        });
        $('BODY').append(modal_background).append(
            modal_window_container.append(
                modal_window_block
                .append(modal_window_header)
                .append(modal_window_content)
                .append(modal_window_control)
            )
        );
    };

    this.popup = function(content, settings) {
    	//this.popup_close();
        var settings = self.getSettingsFromDefaults(settings, {'classes': ''});
        this.initPopUpWindow(settings);
        if(content != undefined) {
            $('#ui_modal_window_content').html(content);
        }
        $('#ui_modal_window_background').fadeIn(600);
        var container = $('#ui_modal_window_container');
        // after container becomes visible we need to update it position
        container.fadeIn(600, function() {
            // find offset of our container
            var offset = container.offset();
            container.css('top', offset.top).css('left',offset.left).css('position','absolute');
            if( 'onshow' in settings ) {
                settings.onshow();
            }
        });
    };


    this.popup_close = function() {
        $('#ui_modal_window_background').fadeOut(500, function() {
            $('#ui_modal_window_background').remove();
        });
        $('#ui_modal_window_container').fadeOut(500, function() {
            $('#ui_modal_window_container').remove();
        });
    };


    // creating new tooltip near object
    this.tooltip = function(content, obj, settings,onshow) {
        if(this.last_tip_id != null) {
           //$('#tooltip' + this.last_tip_id).remove();
        }
     //  alert(content);
        var tip_id = Math.floor(Math.random() * 1000).toString() + Math.floor(Math.random() * 1000);
        // first we need to create new tooltip container
        var tipBlock = $('<DIV>').attr('id', 'tooltip' + tip_id).addClass('ui_tip_block').css('position','absolute').html(content);
        // default settings
        var defaults =  {'offset_Y': 0, 'offset_X' : 0, 'hide_period': 2000, 'auto_hide': 5000 };

        settings = this.getSettingsFromDefaults(settings, defaults);

        if(obj != undefined) {
            var offset = $(obj).offset();
            tipBlock.css('top',offset.top + settings.offset_Y).css('left', offset.left + settings.offset_X);
        }
        this.last_tip_id = tip_id;
        $(obj).bind('mouseleave blur', function() {
            setTimeout(function() {
             //   $('#tooltip' + tip_id).fadeOut('slow');
            }, settings.hide_period);
        });
        if(settings.auto_hide > 0) {
            setTimeout(function(){
                $('#tooltip' + tip_id).remove();
            }, settings.auto_hide);
        }
        $('BODY').append(tipBlock);
        if(onshow != undefined) {
            onshow();
        }
    }

    this.getSettingsFromDefaults = function(settings, defaults) {
        if(settings == undefined) {
            settings = defaults;
        }
        for(setting in defaults) {
            if(!( setting in settings)) {
                settings[settings] = defaults[setting];
            }
        }
        return settings;
    };

    // sending message which will be hided after some delay
    this.message = function(message, settings) {
        var defaults = {'type': 'notify', 'hide_period' : 10000};
        settings = this.getSettingsFromDefaults(settings, defaults);
        $('<div>').attr('id','ui_message_block')
        .addClass('ui_notify_block')
        .css('display','none')
        .css('position','fixed')
        .prependTo($('BODY'));

        $('#ui_message_block').html(message).show();
        setTimeout(function(){
            $('#ui_message_block').fadeOut(500,function() {
                $('#ui_message_block').remove();
            });
        }, settings.hide_period);
    };

    // pass tbody objects for cross selection , collection is jquery object with TR objects
    this.cross_selector = function(collection) {
        collection.each(function() {
            var table = this;
            $(this).find('TR').each(function() {
                var row = this;
                $(row).bind('mouseover',function() {
                    $(row).addClass('ui_cross_selector_row_active');
                }).bind('mouseleave', function() {
                    $(row).removeClass('ui_cross_selector_row_active');
                });
                $(this).find('TD').each(function() {
                    var cell = this;
                    var cell_num = $(row).find('TD').index(this) + 1;
                    $(this).bind('mouseover', function() {
                        $(table).find('TR TD:nth-child(' + cell_num + ')').addClass('ui_cross_selector_col_active');
                    }).bind('mouseleave', function() {
                        $(table).find('.ui_cross_selector_col_active').removeClass('ui_cross_selector_col_active');
                    });
                });
            });
        });
    };

    this.alert = function(message, buttons, image) {
    };



};

var Slider = function(slideobject,options) {
    var self = this;
    var settings = $.extend({perclick : 300,animate: 1,animation_time: 1400,animation_steps: 4,gestures: 1, width: 0 },options);
    var modes = {'left': -1, 'right': 1};

    slideobject.data('currentmargin',0).data('targetmargin',0);
    // РЅР°Рј РЅРµРѕР±С…РѕРґРёРјРѕ РєР°Р¶РґРѕРјСѓ СЌР»РµРјРµРЅС‚Сѓ РІС‹РїРёСЃР°С‚СЊ РµРіРѕ СЃРјРµС‰РµРЅРёРµ РѕС‚РЅРѕСЃРёС‚РµР»СЊРЅРѕ СЃР»Р°Р№РґС€РѕСѓ
    $(document).ready(function() {
        slideobject.find('.photo_preview').each(function() {
            $(this).data('offset', $(this).position().left);
        });
    });
    // РѕРїСЂРµРґРµР»СЏРµРј СЂР°Р·РјРµСЂ СЃР»Р°Р№РґРµСЂР°
    var max_offset = slideobject.find(':last').position().left - slideobject.find(':last').width() - slideobject.width();
    // lets find scroll area size
    // animation function, work until position will be setted
    self.animate_function = function() {
        // first of all lets calcalate how often we need to run animation
        var periods = settings.animation_time / settings.animation_steps;
        // how many pixels we need to move
        var react_diff = settings.perclick / settings.animation_steps;
        var react_function = function() {
            var targetmargin =  slideobject.data('targetmargin');
            var currentmargin = slideobject.data('currentmargin');
            var diff = currentmargin - targetmargin;
            if(Math.abs(diff) >= react_diff ) {
                var new_margin = currentmargin - (diff/Math.abs(diff)) * react_diff ;
                if(Math.abs(new_margin - targetmargin) >= react_diff) {
                    setTimeout(react_function, periods );
                }
                if(isNaN(new_margin)) {
                    alert("CUR: " + currentmargin + " DIFF:" + diff + " REACT: " + react_diff);
                }
                //$('#test').html("TRG: " + targetmargin + "CUR: " + currentmargin + "NEW:" + new_margin + "DIF:" + Math.abs(new_margin - targetmargin) );
                slideobject.data('currentmargin', new_margin);
                slideobject.css('margin-left', '-' +  new_margin + 'px');
            }
        };
        setTimeout(react_function, periods );
    };

    self.move = function(offset_mode) {
        // first we need to get offset
        var old_offset = slideobject.data('offset');
        if(old_offset == undefined) {
            old_offset = 0;
        }
        offset = old_offset + offset_mode;
        if(offset < 0) {
            offset = 0;
        }
        if(offset * settings.perclick > max_offset) {
            return false;
        }
        slideobject.data('offset', offset);
        // target margin
        slideobject.data('targetmargin',  (offset * settings.perclick));
        slideobject.data('currentmargin', (old_offset * settings.perclick));

        if(settings.animate) {
            self.animate_function();
        } else {
            slideobject.css('margin-left', '-' + (offset * settings.perclick) + 'px');
        }
    };
    self.move_to = function(title) {
        var elem = $('[title2='+ title + ']');
        var left = elem.data('offset');
        // С‚РµРєСѓС‰РёР№ РѕС‚СЃС‚СѓРї
        var current_margin = slideobject.data('currentmargin');
        //alert(diff);
      //  alert("CUR: " + current_margin + " LEFT: " + left);
        if( left < current_margin + settings.width / 3   ) {
            self.move((-1) * Math.ceil( (Math.abs(current_margin - left)  ) / settings.perclick));
        } else if ( left > current_margin + settings.width/2 ) {
            self.move( Math.floor( ( left - current_margin - settings.width / 2 ) / settings.perclick));
        } else {
        }
        // we need to check if element is visible or not
    };
};

/**
 * This plugin used for slides list with mousemove and wheel activity
 * to use it you need 4 elements in your HTML:
 * 
 * data-slider-type = 'slider_wrap' - area in which we will move our slider, with overflow hidden and fixed width;
 * data-slider-type = 'slides_self' - area with content, will me moved with margin option;
 * data-slider-type = 'next' - move right; 
 * data-slider-type = 'prev' - move left;
 * 
 */
(function($){
	$.fn.slidebar = function(callback) {
		return this.each(function() {
			var slider_block = $(this);
			/** Slider settings */
			
			/** move slider on each click for this offset, in pixels */
			var step_offset = 150;
			/** coef for mouse move action */
			var mouse_move_coef = 1;
			
			var window    = $(this).find("[data-slider-type='slider_wrap']");
			
			var control_next = $(this).find("[data-slider-type='next']");
			var control_prev = $(this).find("[data-slider-type='prev']");
			
			this.slider = new function() {
				var self = this;
				
				var slides_wrap = slider_block.find("[data-slider-type='slider_wrap']");
				
				/** This class implements main functions for slides */
				self.slides = new function() {
					
					var slides = slider_block.find("[data-slider-type='slides_self']");
					// in this block we will move our slides
					
					this.width = function() {
						return Math.round( slides.width());
					};
					
					this.maxOffset = function(){
						return Math.round(slides.width() - window.width());
					};
					
					/**
					 * Move slides to offset
					 * position offset - moves right
					 * negative offset - moves left
					 */
					this.move = function(offset) {
						var current_offset = parseInt(slides.css('margin-left').replace('px',''));
						var new_offset = current_offset + offset;
						if( new_offset > 0 ) {
							new_offset = 0;
						}
						if( new_offset + this.width() - slides_wrap.width() < 0 ) {
							new_offset = slides_wrap.width() - this.width();
						}
						//console.log("OFF:" + new_offset + " WIDTH:" + this.width() + " WRAP:"+ slides_wrap.width());
					//	alertd(this.width());
						slides.css('margin-left', new_offset + 'px');
					};
					
					this.offset	= function(){
						if( arguments.length ){
							slides.css('left', -Math.min(arguments[0], slides.maxOffset())+'px');
						}
						
						var slideoffset = - Math.round($slides.position().left), maxoffset = slides.maxOffset();
						
						if(slideoffset > maxoffset || slideoffset < 0){
							if(slideoffset < 0) maxoffset = 0;
							slides.css('left', - maxoffset+'px');
							slideoffset = maxoffset;
						}
						
						return slideoffset;
					};
					
					this.pers = function() {
						return slides.offset() / slides.maxOffset();
					};
					
				};
				
				$(slides_wrap).wheel(function(delta){
					self.slides.move(delta * 30);
				});
				
				/** bind control buttons */
				control_next.bind('click', function() {
					self.slides.move( (-1) * step_offset);
					return false;
				});
				control_prev.bind('click', function() {
					self.slides.move(step_offset);
					return false;
				});
				var rejecter = function(e) {
					e.preventDefault();
					e.stopPropagation();
					return false;					
				};
				control_prev.bind('mousedown dblclick', rejecter);
				control_next.bind('mousedown dblclick', rejecter);
				
				
				self.scrollbar = new function() {
					var scrollbar = $(this).find("[data-slider-type='scrollbar']");
					this.width = function() {
						return scrollbar.width();
					};
					
					this.offset = function() {
						return scrollbar.offset().left;
					};
				};
				
				var mouse_control = new function() {
					var control = this;
					this.move_mode = false;
					this.last_pos = 0;
					this.last_offset_direction = 0;
					
					slides_wrap.mousedown(function(e) {
						e.preventDefault();
						e.stopPropagation();
						control.move_mode = 1;
						control.last_pos = e.clientX;
					}).mousemove(function(e) {
						// we need to move slider only in when client click on it
						if ( control.move_mode ) {
							offset = e.clientX - control.last_pos;
							self.slides.move(parseInt(offset * mouse_move_coef) );
							control.last_pos = e.clientX;
							
							var offset_direction = offset / Math.abs(offset);
							
							if( offset_direction != control.last_offset_direction && control.last_offset_direction != 0 ) {
								control.move_mode = 0;
								control.last_offset_direction = offset_direction;
								return true;
							} 							
						}
						e.preventDefault();
						e.stopPropagation();
					}).mouseup(function(e) {
						control.move_mode = 0;
						e.preventDefault();
						e.stopPropagation();
					}).mouseleave(function(e){
						control.move_mode = 0;
					});
				};
			};
		});
	};
})(jQuery);

(function($) {
    $.fn.slider = function(options) {
        if(this.length != 1 ) {
            return false;
        }
        return new Slider(this,options);
    };
})(jQuery);
(function($) {
    $.fn.cross_selector = function() {
        return UI.cross_selector(this);
    }; 
})(jQuery);

(function($) {
    $.fn.tabs = function() {
        return this.each(function(options) {
            var options = $.extend({'animation_time': 300 }, options);
            var container = this;
            $(container).find('.ui_tab_body').hide();
            $(container).find('.ui_tab').each(function() {
                // РѕР±СЂР°Р±Р°С‚С‹РІР°РµРј РІСЃРµ С‚Р°Р±С‹
                var tab = this;
                $(this).find('.ui_tab_header').bind('click', function() {
                    // РµСЃР»Рё СЃР»Р°Р№Рґ Р°РєС‚РёРІРµРЅ С‚Рѕ РЅР°Рј РЅР°РґР° РµРіРѕ СЃРІРµСЂРЅСѓС‚СЊ
                    if( $(tab).hasClass('active_tab')) {
                        $(tab).removeClass('active_tab').find('.ui_tab_body').slideUp(options.animation_time);
                    } else {
                        // РїРѕС…РѕР¶Рµ Сѓ РЅР°СЃ РЅР°РґР° Р°РЅРёРјРёСЂРѕРІР°С‚СЊ СЃР»Р°Р№РґС‹
                        $(container).find('.ui_tab_body').slideUp(options.animation_time);
                        $(container).find('.active_tab').removeClass('active_tab').find('.ui_tab_body').slideUp(options.animation_time);
                        $(tab).addClass('active_tab').find('.ui_tab_body').slideDown(options.animation_time);
                    }
                });
            });
            if( $(container).find('.ui_opened').size() > 0 ) {
                var tab = $(container).find('.ui_opened').first();
            } else {
                var tab = $(container).find('.ui_tab').first();
            }
            $(tab).addClass('active_tab').find('.ui_tab_body').show();
        });
    };
})(jQuery);

(function($){
	$.fn.htabs = function(opts) {
		//var options = opts;

		return this.each(function(options){
			//alert(opts);
			var options = $.extend({'default': 'main'}, opts);
			
			var container = $(this);
			// remove display from all tables
			container.find('[data-type="tabhead"][data-tab-name="' + options['default'] + '"]').addClass('active');
			container.find('[data-type="tabbody"]').hide();
			container.find('[data-type="tabbody"][data-tab-name="' + options['default'] + '"]').show();
			
			container.find('[data-type="tabhead"]').click(function(){
				var tabhead = $(this);
				var name = $(this).attr('data-tab-name');
				container.find('[data-type="tabhead"]').removeClass('active');
				$(this).addClass('active');
				container.find('[data-type="tabbody"]').hide();
				var tabbody = container.find('[data-type="tabbody"][data-tab-name="' + name + '"]');
				tabbody.show();
				if(options.onselect != undefined && typeof options.onselect == 'function') {
					options.onselect(name, tabhead, tabbody);
				}
				return false;
			});
		});
	};
})(jQuery);

/** For tree plugin you need to specify this options 
 *  .separator - delimiter between tree elements when converting them to full path 
 *  .source - source function which will load data using full tree path, source function must call callback function and send 
 * 
 * */

(function($) {
	$.fn.tree = function() {
		return this.each(function(options) {
			if(options.separator) 
			$(this).html('<ul title="root"></ul>');
		});
	};
	
})(jQuery);

/**
 * Run function after text input is finished
 */ 
(function($){
	$.fn.inputend = function(call,options) {
		return this.each(function() {
			var options = {'delay' : 1200 };
			var input = this;
			// save old value, we need to run function only if value is changed
			$(input).data('last-value', $(input).val());
			$(this).bind('keyup', function(event) {
				var current_timestamp = new Date().getTime();
				$(input).data('last_keyup', current_timestamp);
				// run change function after each input with some delay, to prevent fast updates
				setTimeout(function() {
					var input_value = $(input).val();
					if( input_value == $(input).data('last-value')) {
						return false;
					}
					var run_timestamp = new Date().getTime();
					var last_input_keyup = $(input).data('last_keyup');
					if( last_input_keyup < run_timestamp - options.delay ) {
						$(input).data('last-value', input_value);
						input.call = call;
						input.call();
					} 
				}, options.delay + 10 );
			});
			// run callback after focus loss
			$(this).bind('blur', function(event){
				var input_value = $(input).val();
				if( input_value == $(input).data('last-value')) {
					return false;
				}
				$(input).data('last-value', input_value);
				input.call = call;
				input.call();
			});
		});
	};
})(jQuery);

(function($){
	$.fn.onenter = function(callback) {
		return this.each(function(){
			$(this).bind('keydown', function(event){
				if( event.which == 13 ) {
					if(typeof callback == 'function') {
						callback();
					}
				}
			});
		});
	};
})(jQuery);
(function($){
	var callbacks = new Array();
	$.fn.onscroll = function(call) {
		if(typeof call != 'function') {
			return false;
		}
		// РїСЂРѕРІРµСЂСЏРµРј С‡С‚Рѕ С…СЌРЅРґР»РµСЂ РѕРєРЅР° Рё С‚Рѕ С‡С‚Рѕ РЅР°Рј РїРµСЂРµРґР°РЅРѕ СЃРѕРІРїР°РґР°СЋС‚
		if(window == this.get(0)) {
			if(typeof window.onscroll != 'function') {
				window.onscroll = function() {
					var offset = (window.pageYOffset != undefined) ? window.pageYOffset : document.documentElement.scrollTop;
					for(var i in callbacks) {
						callbacks[i](offset);
					}
				};
			}
			callbacks.push(call);
		}
	};
})(jQuery);
(function($){
	$.fn.get_input_data = function () {
		if (this.length != 1) {
			return false;
		}
		var form_data = {};
		// lets find all textareas
		$(this).find('TEXTAREA').each(function(){
			var name = $(this).attr('name');
			if ( name == '')  return true;
			form_data[name] = $(this).val();
		});
		$(this).find('INPUT').each(function(){
			var name = $(this).attr('name');
			if( name == '') return true;
			
			var type = $(this).attr('type');
			switch(type) {
				case "hidden":
				case "text":
				case "password":
					form_data[name] = $(this).val();
					break;
				case "checkbox":
					form_data[name] = $(this).is(':checked');
					break;
			}
		});
		$(this).find('SELECT').each(function(){
			var name = $(this).attr('name');
			var value = $(this).val();
			form_data[name] = value;
		});
		return form_data;
		
	};
})(jQuery);

(function($){
	$.fn.exclick = function(callback, selector, locker) {
		// global marker, allow user to deny exclick callback if needed
		var block = $(this);
		if(selector == undefined) { selector = 'HTML'; 	}
		
		$(selector).unbind('click');
		
		if ( $(selector).data('exclick_binded') == 'yes' ) {
			return true;
		}
		
		$(selector).data('exclick_binded','yes').click(function(event){
			if( event.srcElement != undefined && ( event.srcElement.tagName == 'SELECT' || event.srcElement.tagName == 'OPTION' ) ) return true;
			
			var offset = block.offset();
			//var offset = $(block).position();
			// check if this click outside of our block
			
			
			var outer_width = block.outerWidth();
			var outer_height = block.outerHeight();

			if( event.pageX < offset.left ||
				event.pageX > offset.left + outer_width ||
				event.pageY < offset.top ||
				event.pageY > offset.top + outer_height ) {
				$(selector).unbind('click');
				callback();
			}
			//event.stopPropagation();
			//event.preventDefault();
		});
	};
})(jQuery);

(function($){
	var handle = false;
	
	var wheel_exe = function(event){
		var delta = 0;
		if (!event) event = window.event; // РЎРѕР±С‹С‚РёРµ IE.
		// РЈСЃС‚Р°РЅРѕРІРёРј РєСЂРѕСЃСЃР±СЂР°СѓР·РµСЂРЅСѓСЋ delta
		if (event.wheelDelta) { 
			// IE, Opera, safari, chrome - РєСЂР°С‚РЅРѕСЃС‚СЊ РґРµР»СЊС‚Р° СЂР°РІРЅР° 120
			delta = parseInt(event.wheelDelta/120);
		} else if (event.detail) { 
			// Mozilla, РєСЂР°С‚РЅРѕСЃС‚СЊ РґРµР»СЊС‚Р° СЂР°РІРЅР° 3
			delta = parseInt(-event.detail/3);
		}
		// Р’СЃРїРѕРјРѕРіР°С‚РµР»СЊРЅСЏ С„СѓРЅРєС†РёСЏ РѕР±СЂР°Р±РѕС‚РєРё mousewheel
		if (delta && typeof handle == 'function') {
			//console.log("DELTA: " + delta);
			var result = handle(delta);
			if(!result) {
				hander = false;
				return true;
			}
			// РћС‚РјРµРЅРёРј С‚РµРєСѓС‰РµРµ СЃРѕР±С‹С‚РёРµ - СЃРѕР±С‹С‚РёРµ РїРѕСѓРјРѕР»С‡Р°РЅРёСЋ (СЃРєСЂРѕР»РёРЅРі РѕРєРЅР°).
			if (event.preventDefault)
				event.preventDefault();
			event.returnValue = false; // РґР»СЏ IE
		} 
	};
	
	if (window.addEventListener) {
		window.addEventListener('DOMMouseScroll', wheel_exe, false);
		//window.addEventListener('scroll', wheel_exe, false);
	}
	//IE, Opera.
	window.onmousewheel = document.onmousewheel = wheel_exe;
	
	
	
	$.fn.unwheel = function() {
		handle = false;
		window.onmousewheel = document.onmousewheel = true;
		window.onscroll = true;
	};

	$.fn.wheel = function(callback, opts) {
		var options = $.extend({'unhandler' : true},opts);
		var old_scroll = $(window).scrollTop();
		window.onscroll = function(ev){
			var scroll = $(window).scrollTop();
			var event = {'wheelDelta': -10 * ( scroll - old_scroll ) };
			if( event.wheelDelta <= -120 || event.wheelDelta >= 120) {
				old_scroll = scroll;
				return wheel_exe(event);
			}
		};
		
		return this.each(function(){
			$(this).mouseover(function(){
				handle = callback;
				return false;
			}).mouseleave(function(){
				if(options.unhandler) {
					handle = false;
				}
				return false;
			});
		});
	};
})(jQuery);

/**
 * Get width of browser scrollbar
 */
(function($) {
	$.fn.getScrollbarWidth = function() {
		var inner = document.createElement('p');  
		inner.style.width = "100%";  
		inner.style.height = "200px";  
		
		var outer = document.createElement('div');  
		outer.style.position = "absolute";  
		outer.style.top = "0px";  
		outer.style.left = "0px";  
		outer.style.visibility = "hidden";  
		outer.style.width = "200px";  
		outer.style.height = "150px";  
		outer.style.overflow = "hidden";  
		outer.appendChild (inner);  
		
		document.body.appendChild (outer);  
		var w1 = inner.offsetWidth;  
		outer.style.overflow = 'scroll';  
		var w2 = inner.offsetWidth;  
		if (w1 == w2) w2 = outer.clientWidth;  
		document.body.removeChild (outer);  
		return ( w1 - w2 );  
	};
})(jQuery);

/* Интервал поиска или сортировки, выглядит 
 * как два ползунка и значения величины зависящие от
 * их положения. Плагин применяется к блоку содержащему
 * все необходимые элементы.
 * В качестве параметров передается верхний и нижний предел
 */
(function($){
	$.fn.range = function(options){
		//Текущий интерфейс
		var drag=this;
		//Для хранения перетаскиваемого ползунка
		var drag_slider;
		//Изменяемый предел
		var drag_limit;
		
		var drag_bar = '<div class="drag_bar">'+
			'<div class="drag_bar_line"></div>'+
			'<div class="less_slider drag_slider"></div>'+
			'<div class="more_slider drag_slider"></div>'+
			'</div>';
		var drag_limits = '<div class="drag_bar_value">'+
			'<div class="less_value">'+options.lower+'</div>'+
			'<div class="more_value">'+options.upper+'</div>'+
			'</div>';
		this.html(drag_bar);
		//var dr=this.find('.less_slider');
		
		//В зависимости от опции ползунки отображаются либо выше,
		//либо ниже значений пределов
		if(options.drag_bar_position=='top')
			this.find('div.drag_bar').after(drag_limits);
		else this.find('div.drag_bar').before(drag_limits);
		var less_slider = {
			width : function(){
				return drag.find('.less_slider').width();
			},
			maxOffset : function(){
				return Math.max(0,more_slider.offset());
			},
			offset    : function(){
				if(arguments.length){
					drag.find('.less_slider').css('left', Math.max(0,Math.min(arguments[0],less_slider.maxOffset()))+'px');
				}
				var
					iOffset = drag.find('.less_slider').position().left,
					iMax = less_slider.maxOffset()
				;
				return iOffset;

			}
		};
		var more_slider = {
			width : function(){
				return drag.find('.more_slider').width();
			},
			maxOffset : function(){
				return drag.find('.drag_bar_line').width();
			},
			minOffset : function(){
				return Math.max(0,less_slider.offset()); 
			},
			offset    : function(){
				if(arguments.length){
					drag.find('.more_slider').css('left', Math.max(more_slider.minOffset(),Math.min(arguments[0],more_slider.maxOffset()))+'px');
				}
				var
					iOffset = drag.find('.more_slider').position().left,
					iMax = more_slider.maxOffset()
				;
				return iOffset;

			}
		};
		this.find('div.drag_slider').mousedown(function(e){
			if($(this).hasClass('more_slider')){
				drag_slider=more_slider;
				drag_limit=drag.find('.more_value');
			}else {
				drag_slider=less_slider;
				drag_limit=drag.find('.less_value');
			}
			$(document).mousemove(startDrag)
				   .mouseup(stopDrag);
			return false;
		});
		function startDrag(e){
			var xs=more_slider.offset();
			$('#test').html(e.clientX+'/'+e.pageX);
			drag_slider.offset(e.clientX-drag_slider.width()/2-drag.position().left);
			drag_limit.html(Math.floor(drag_slider.offset()*(parseInt(options.upper)-parseInt(options.lower))/more_slider.maxOffset())+parseInt(options.lower));
		}
		function stopDrag(e){
			$(document).unbind('mousemove',startDrag)
				   .unbind('mouseup',stopDrag);
		}
		//this.find('.less_slider').hide();
		//alert('test');
		//return false;
	};
})(jQuery);