(function(D) {
	D.register('admin', new function() {
		var me = this;
		var self = this;
		window.isCtrl = false;
		$(document).keydown(function(event) {
			window.isCtrl = true;
		}).keyup(function(event) {
			window.isCtrl = false;
		});
		me.init_table_menu = function(table, options) {
			$(table).each(function() {
				var tbl = $(this);
				var check_uncheck_element = function(object,check) {
					if( check != undefined) {
						if(check) {
							var check_mode = true;
							var classes = {'delete':'cms_table_list_inactive_element','add':'cms_table_list_active_element'};
						} else {
							var check_mode = false;
							var classes = {'delete':'cms_table_list_active_element','add':'cms_table_list_inactive_element'};
						}
					} else { 
						if( $(object).find("INPUT[name='check']").is(':checked') ) {
							var check_mode = false;
							var classes = {'delete':'cms_table_list_active_element','add':'cms_table_list_inactive_element'};
						} else {
							var check_mode = true;
							var classes = {'delete':'cms_table_list_inactive_element','add':'cms_table_list_active_element'};
						}
					}
					$(object).find("INPUT[name='check']").attr('checked',check_mode);
					$(object).removeClass(classes.delete).addClass(classes.add);
				};
				
				var buttons = $(this).find('TBODY.cms_table_menu > TR > TD');
				$(tbl).find("TBODY[data-type='element']").each(function() {
					var element = this;
					check_uncheck_element(element, false);
					$(element).click(function(event) {
						if(window.isCtrl) {
							check_uncheck_element(element);
						} 
						event.stopPropagation();
					});
					$(element).find("INPUT[name='check']").bind('click', function(){
						if($(this).is(':checked')) {
							check_uncheck_element(element,true);
						} else {
							check_uncheck_element(element,false);
						}
					});
				});
				
				$(tbl).find("TBODY[data-type='element']").bind('mouseover', function(){
					if(me.admin_is_check_mouse_down != undefined && me.admin_is_check_mouse_down) {
						id = $(this).attr('data-id');
						// теперь выбираем элемент
						check_uncheck_element(this, me.admin_last_mass_check_mode);
					}
				}).bind('mouseup', function(){
					me.admin_is_check_mouse_down = false;
					//	alert("yes");
				});
				
				$(tbl).find('.check').bind('mousedown', function(){
					me.admin_is_check_mouse_down = true;
					me.admin_last_mass_check_mode = ($(this).find('INPUT').is(':checked')) ? false : true;
				});
				
				$(tbl).find('INPUT[name="select_unselect_all"]').bind('click', function() {
					var checked_mode = ($(this).is(':checked')) ? true : false;
					$(tbl).find("TBODY[data-type='element']").each(function() {
						check_uncheck_element(this, checked_mode);
					});				
				});
				if( options.delete_selected != undefined ) {
					var delete_button = $('<a>').attr('href','#').addClass('cms_table_menu_delete_selected').html(D._('DELETE_SELECTED'));
					delete_button.click(function(){
						options.delete_selected();
					});
					buttons.append(delete_button);
				}
				//tbl.find('TBODY.cms_table_menu > TR > TD').html('HELLOWORLD');
			});
		};
		
		// on ready action
		this.onready = function() {
			self.rebind_objects();
			self.bind_form_methods();
		};
		
		this.bind_form_methods = function() {
			$('.cms_form').each(function(){
				var form = this;
				
				var form_id = $(form).attr('data-form-id');
				$(form).find('THEAD .configure').click(function(){
					$(form).addClass('cms_form_configuring');
					return false;
				});
				$(form).find('THEAD .save').click(function(){
					$(form).removeClass('cms_form_configuring');
					return false;
				});
				
				$(form).find('TBODY').each(function(){
					var elem = this;
					var name = $(elem).attr('data-line-name');
					
					if(name == undefined) return true;
					
					var field_key = form_id + ':' + name;
					if(self.storage.isset(field_key)) {
						var mode = self.storage.get(field_key);
					} else {
						var mode = 1;
					}
					if(mode == 1) {
						$(elem).find('.cms_form_var_changer INPUT').attr('checked','checked');
					} else {
						$(elem).find('.cms_form_var_changer INPUT').attr('checked', false);
					}
					
					$(elem).attr('data-line-show-mode', mode);
					
					$(elem).find('.cms_form_var_changer INPUT').click(function(){
						var mode = ( $(this).is(':checked')) ? 1 : 0;
						$(elem).attr('data-line-show-mode', mode);
						self.storage.set(field_key, mode);
					});
					
				});
			});
		};
		
		this.rebind_objects = function() {
			$('.cms_list').each(function(){
				var funcs = ( $(this).attr('data-list-funcs') != undefined ) ? $(this).attr('data-list-funcs').split(' ') : new Array();
				$(this).find('TBODY[data-type="element"]').each(function(){
					var object = {};
					object.row = $(this);
					object.object_id = $(this).attr('data-object-id');
					
					object.title = $(this).find('[data-name="title"]').html();
					for ( var i in funcs ) {
						var func_name = funcs[i];
						switch(funcs[i]) {
						case 'delete': me.bind_delete_func(object); break;
						case 'active': me.bind_active_func(object); break;
						case 'edit'  : me.bind_edit_func(object); break;
						case 'fields': me.bind_field_updater(object); break;
						}
					}
				});
			});
		};
		
		this.bind_delete_func = function(object) {
			object.row.find('.delete').unbind('click').click(function() {
				console.log("clicked");
				if(!confirm(D._('ADMIN_DO_YOU_WANT_TO_DELETE_OBJECT', object.title))) {
					return false;
				}
				D.modules.core.delete_object(object.object_id, function(answer){
                    					console.log(answer); 
					if(answer.status == 'OK' ) {
						object.row.addClass('cms_deleted_object');
						setTimeout(function(){
							object.row.remove();
						}, 1000);
					}
				});
			});
		}
		
		this.bind_field_updater = function(object) {
			object.row.find('[data-field]').each(function(){
				var field = $(this);
				var field_name = $(this).attr('data-field');
				var updater = function(mode, value) {
					D.modules.core.update_field(object.object_id, field_name, mode, value, function(answer){
						if(answer.status == 'OK') {
							field.find("[data-field-func='value']").html(answer.value);
						}
					});
				};
				field.find("[data-field-func]").each(function(){
					var func = $(this).attr('data-field-func');
					switch(func) {
						case "inc":
						case "dec": 
							$(this).click(function(){
								updater(func,'');
							});
							break;
					}
				});
			});
		}
		
		this.bind_active_func = function(object) {
			object.row.find('.active').click(function(){
				object.active = object.row.attr('data-active');
				var active = ( object.active == '1' ) ? '0' : '1';
				D.modules.core.set_object_active(object.object_id, active, function(answer){
					if (answer.status == 'OK') {
						object.row.attr('data-active', active);
					}
				});
			});
		};
		this.bind_edit_func = function(object) {
			object.row.find('.edit').click(function(){
				location.href=$(this).attr('data-url');
			});
			return false;
		};
		
		this.bind_admin_panel = function() {
			$('#cms_panel_btn_cache').click(function(){
				$('#cms_flush_cache').submit();
			});
		};
		
		this.notify = function(message) {
			var msg = $('<DIV>');
			msg.html(message).click(function(){
				$(msg).fadeOut();
			}).appendTo('#admin_notification_block');
			setTimeout(function(){
				$(msg).fadeOut();
			}, 8000);
		};
		
	});
})(D);
