(function(D) {
	D.register('core', new function() {
		var me = this;
		var self = this;
		me.onready = function() {
			//alert("go");
			self.bind_multilangs();
		};
		
		me.bind_view_settings_page = function() {
			$('.cms_core_setting').each(function(){
				var setting = this;
				var setting_id = $(this).attr('data-setting-id');
				var type = $(this).attr('data-type');
				var value = '';
				switch(type) {
					case 'bool':
						if($(this).find('value').is(':checked')) {
							value = 1;
						} else {
							value = 0;
						}
						break;
					case 'int':
					case 'string':
						value = $(this).find('value').val();
						break;
				}
				$(this).find('[type=submit]').click(function(){
					me.call('update-setting', {'data' : {'setting_id' : setting_id, 'value' : '232'}, 'success': function(answer){
						alert(answer);
					}});
				});
			});
		};
		
		/** set object activity */
		me.set_object_active = function(object_id, active, on_success) {
			me.run('update-activity', {'active' : active, 'object_id': object_id}, on_success);
		};
		me.delete_object = function(object_id, on_success) {
			me.run('delete-object', {'object_id' : object_id}, on_success);
		};
		
		self.update_field = function(object_id, field, mode, value, callback) {
			self.run('update-field', {'object_id': object_id, 'field' : field, 'mode': mode, 'value': value}, function(answer){
				if(callback instanceof Function) {
					callback(answer);
				}
			});
		};
		
		me.bind_activity_switcher = function(table) {
			table.find('TBODY[data-type="object"]').each(function() {
				var object = this;
				var object_id = $(object).attr('data-object-id');
				
				$(this).find('[name="active"]').click(function(){
					var active = $(this).is(':checked');
					me.run('update-activity', {'active' : active, 'object_id': object_id}, function(answer) {
						
					});
				});
			});
		};
		
		self.bind_multilangs = function() {
			$('.cms_form').each(function(){
				var form = $(this);
				var object_id = form.attr('data-object-id');
				
				form.find('.cms_admin_multilang').each(function(){
					var elem = $(this);
					elem.find('.cms_admin_multilang_input').find('TEXTAREA,INPUT').hide().first().show();
					elem.find('TH').first().addClass('active');
					elem.find('TH').each(function(){
						var tab = $(this);
						$(this).click(function(){
							elem.find('TH').removeClass('active');
							$(this).addClass('active');
							var lang = $(this).attr('data-lang');
							elem.find('.cms_admin_multilang_input').find('TEXTAREA,INPUT').hide();
							elem.find('[data-lang="' + lang + '"]').show();
							return false;
						});
					});
					elem.find('INPUT[type="submit"]').click(function(){
						//console.log("BIND1");
						var variant = elem.find('.cms_admin_multilang_input').find('TEXTAREA:visible,INPUT:visible');
						var lang = variant.attr('data-lang');
						var vl = variant.val();
						self.run('i18n.update-i18n-field',{'object_id': object_id, 'lang': lang, 'text': vl, 'name' : $(this).attr('data-name')}, function(answer){
							//alert(answer.status);
						});
						//	alert(vl + ':' + lang);
						return false;
					});
				});
			});
		};
		
		self.bind_i18n_controls = function() {
			$('.cms_list TBODY').each(function(){
				var msg = $(this);
				
				var msg_code = msg.attr('data-msg-code');
				var lang = msg.attr('data-lang');
				
				msg.find('INPUT[type="submit"]').click(function(){
					data = msg.get_input_data();
					data.lang = lang;
					data.msg_code = msg_code;
					
					self.run('i18n.update-lng-message',data, function(answer){
						
					});
				});
			});
		};
		
		
	});
})(D);
