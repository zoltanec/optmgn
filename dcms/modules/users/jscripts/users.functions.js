var usersJS = new function() {
	var self = this;
	this.runAuthorization = function(login_form, on_success) {
		var username = $(login_form).find('INPUT:[name="username"]').val();
		var password = $(login_form).find('INPUT:[name="password"]').val();
		var rememberme = $(login_form).find('INPUT:[name="rememberme"]').is(':checked');
		$.post(siteVars.www + '/users/authorize-me/', {'username' : username, 'password': password, 'rememberme': rememberme}, function(answer) {
			if(answer.status == 'OK') {
				if(on_success != undefined) {
					on_success(answer);
				}
				$('#login_form_block').hide();
				$('.noauth_required').hide();
				$('.auth_required').show();
				coreJS.notify(siteLang.AUTHORIZATION_SUCCESSFULL);
			} else {
				coreJS.notify(siteLang.AUTHORIZATION_FAILED);
			}
		},'json');
		return false;
	};
	
	this.runExit = function() {
		$.get(siteVars.www + '/users/logout/', function(answer) {
			if(answer.status == 'OK') {
				$('.auth_required').hide();
				$('.noauth_required').show();
				coreJS.notify(siteLang.SESSION_CLOSED);
			}
		},'json');
		return false;
	};
	
	this.loadLatestMessages = function() {
		// сначала определяем самое свежее сообщение
		var last_msgid = $('#chat_messages :first').attr('title');
		// downloading fresh messages
		$.post(siteVars.www + '/users/chat/', {'uid' : $('#recipient_uid').val(), 'mode' : 'latest', 'last_msgid': last_msgid }, function(answer) {
				$('#chat_messages').prepend(answer);
		});
	};
	
	
	
	

	this.getChatMessagesPage = function(page,uid) {
		$('#chat_messages_container').css('cursor','wait').css('opacity',0.1);
		$.post(siteVars.www + '/users/chat/', {'uid' : uid, 'page' : page,'mode': 'get-page'}, function(answer) {
			$('#chat_messages_container').html(answer).css('opacity',1).css('cursor','default');
		});
	}; 
	
	this.showAvatarSelector = function() {
		$.post(siteVars.www + '/users/get-avatars-selector/', function(answer){
			UI.popup(answer,{'onshow' : function(){
				$('.users_all_avatars .single_avatar').click(function(){
					$('#current_user_avatar').attr('src',$(this).find('IMG').attr('src'));
					$.post(siteVars.www + '/users/update-avatar/', {mode: 'set', avatar: 'defaults/' + $(this).attr('title')}, function(answer) {
						if(answer.status == 'OK') {
							//alert("Информация обновлена");
						} else {
							alert("Ошибка!");
						}
					},'json');
					UI.popup_close();
				});
			}});
		});
	};
	
	this.truncateAvatar = function() {
		$.post(siteVars.www + '/users/update-avatar/', {mode: 'truncate'}, function(answer) {
			if(answer.status == 'OK') {
				$('#current_user_avatar').attr('src',siteVars.mimages + '/default_avatar.png');
			}
		},'json');
		return false;
	};
};
$(document).ready(function() {
	$('.authorization_form').bind('submit', function() {
		return usersJS.runAuthorization(this);
	});
});

(function(D) {
	D.register('users', new function() {
		var self = this;
		var me = this;
		// UID 
		me.uid = 0;
		// do we need to check PM
		me.pm_check_needed = true;
		// function to call when authorization completed
		me.on_auth_completed = false;
		// function to call if authorization failed
		me.on_auth_error = false;
		
		this.add_new_warning = function() {
			//alert("test");
		};
		this.show_user_page = function(uid) {
			self.call('show',{data: {'uid': uid}, success: function(answer) {
				UI.popup(answer,{ close_button: D.theme_images + '/ui/modal_window_close.png',
					full_page_button: D.theme_images + '/ui/modal_window_newwindow.png',
					full_page_url: self.request_path + '/show/' + uid } );
			}});
			return false;
		};
		this.open_pm_chat = function(uid) {
			if( me.uid == 0 ) return false;
			self.call('chat',{data: {'uid': uid}, success: function(answer) {
				UI.popup(answer,{close_button: D.theme_images + '/ui/modal_window_close.png', onshow: function(){
					self.bind_messages_sender();
				}});
			}});
			return false;
		};
		
		this.run_authorization = function(login_form) {
			var username = $(login_form).find('INPUT:[name="username"]').val();
			var password = $(login_form).find('INPUT:[name="password"]').val();
			var rememberme = $(login_form).find('INPUT:[name="rememberme"]').is(':checked');
			me.run('authorize-me', {'username' : username, 'password': password, 'rememberme': rememberme}, function(answer) {
				if(answer.status == 'OK') {
					if(me.on_auth_completed != false ) {
						me.on_auth_completed(answer);
					}
					$('.cms_login_form').hide();
					$('.noauth_required').hide();
					$('.auth_required').show();
				} else {
					if( typeof me.on_auth_error == 'function') {
						me.on_auth_error();
					}
				}
			});
			return false;
		};
		
		this.submit_pm_message = function() {
			if(me.pm_submit_started != undefined && me.pm_submit_started > D.time() - 3000 ) {
				return false;
			}
			me.pm_submit_started = D.time();
			var message = $('#pm_submit .cm_textarea').val();
			if(message == '') {
				return false;
			}
			$('#pm_submit .cm_textarea').attr('disabled','disabled');
			self.call('send-message', { data: {'content': message, 'uid': $('#recipient_uid').val()}, success: function(answer) {
				$('#pm_submit .cm_textarea').removeAttr('disabled');
				if(answer == 'OK') {
					$('#pm_submit .cm_textarea').val('');
					//у нас добавилось новое сообщение, дозагрузим свежак
					self.get_latest_messages();
				} else {
					return false;
				}
			}});
		};
		
		this.delete_pm = function(msgid) {
			if(!confirm(D._('DELETE_USER_PM_MESSAGE'))) {
				return false;
			}
			self.call('delete-pm',{'data': {'msgid': msgid}, 'success': function(answer) {
				if(answer == 'OK') {
					$('#msgid' + msgid).remove();
				}
			}});
			return false;
		};
		
		this.get_latest_messages = function() {
			// сначала определяем самое свежее сообщение
			var last_msgid = $('#chat_messages :first').attr('title');
			// downloading fresh messages
			self.call('chat', {'data': {'uid' : $('#recipient_uid').val(), 'mode' : 'latest', 'last_msgid': last_msgid}, success: function(answer) {
				if(answer != '') {
					$('#chat_messages').prepend(answer);
				}
			}});
		};
		
		
		this.bind_messages_sender = function() {
			$('#pm_submit').bind('submit', function() {
				me.submit_pm_message();
				return false;
			});
			$('.users_pm_send_form .cm_textarea').keyup(function (e) {
				if(e.which == 17) isCtrl=false;
			}).keydown(function (e) {
					if(e.which == 17) isCtrl=true;
			   		if(e.which == 13 && isCtrl == true) {
						$('#pm_submit').submit();
						return false;
					}
			});
		};
		
		this.new_pm_check = function() {
			if(!me.pm_check_needed || me.uid == 0 ) {
				return false;
			}
			var max_msg_size = 40;
			var last_msgid = D.cookie('pm_last_msgid');
			if(last_msgid == undefined) {
				last_msgid = 0;
			}
			var msg_template = "<div id='pm_msg_${msgid}' title='${lng_title}' class='cms_new_pm_popup pm_msg_${msgid}'><table><tr><td class='cms_new_pm_from' colspan='2'>от <span>${username}</span></td></tr><tr><td class='cms_new_pm_avatar'>" +
					"<img src='${avatar}'></td><td class='cms_new_pm_content'>${content}</td></tr><table></div>";
			self.call('get-new-pm', {data: {'last_msgid': last_msgid }, success: function(answer) {
				for(var i in answer) {
					var message = answer[i];
					if( ! ( 'content' in message )) {
						continue;
					}
					if(message.content.length > max_msg_size) {
						message.content =  message.content.substr(0,40) + '...';
					}
					if(parseInt(message.msgid) > last_msgid) {
						last_msgid = parseInt(message.msgid);
					}
					message.lng_title = D._('USERS_PRESS_TO_PM_TO_OPEN_CHAT');
					if($('#cms_users_messages_block').length != 1 ) {
						$('BODY').append('<div id="cms_users_messages_block"></div>');
					} else {
						if($('#cms_users_messages_block DIV').length > 4) {
							$('#cms_users_messages_block DIV:first-child').remove();
						}
					}
					if(message.avatar == '') {
						message.avatar = self.images + '/default_avatar.png';
					} else {
						message.avatar = self.content +'/avatars/' + message.avatar;
					}
					$.tmpl(msg_template,message).prependTo('#cms_users_messages_block');
					setTimeout(function() {
						$('#pm_msg_' + message.msgid).slideUp('slow',function() {
							$(this).remove();
						});
					},12000);
					$('#pm_msg_' + message.msgid).click(function() {
						self.open_pm_chat(message.uid);
						$('#pm_msg_' + message.msgid).remove();
					});
				}
				D.cookie('pm_last_msgid', last_msgid, {'expires': 30});
			}});
			setTimeout(function(){
				self.new_pm_check();
			}, 10000);
		};
		
		this.bind_registration_form = function() {
			var ok = function(text) {
				return "<span class='users_registration_field_ok'>" + text + "</span>";
			};
			var bad = function(text) {
				return "<span class='users_registration_field_bad'>" + text + "</span>";
			};
			
			var form = $('#users_registration_form');
			form.find('[name="username"]').inputend(function() {
				var input = this;
				me.call('check-username-exist', {data: {'username': $(this).val()}, success: function(answer) {
					if(answer == 'OK_FREE') {
						var text = ok(D._('USERS_REGISTRATION_USERNAME_FREE'));
						var class_need = 'field_ok';
					} else {
						var text = bad(D._('USERS_REGISTRATION_USERNAME_USED'));
						var class_need = 'field_err';
					}
					$(input).removeClass('field_ok').removeClass('field_err').addClass(class_need);
					$('#users_registration_check_username').html(text);
				}});
			});
			form.find('[name="password1"],[name="password2"]').inputend(function() {
				if(form.find('[name="password2"]').val() != form.find('[name="password1"]').val()) {
					var class_name = 'field_err';
					var text = bad(D._('USERS_REGISTRATION_PASSWORDS_MISMATCH'));
				} else {
					var class_name = 'field_ok';
					var text = ok(D._('USERS_REGISTRATION_PASSWORDS_OK'));
				}
				if(form.find('[name="password1"]').val().length <= 4) {
					var class_name = 'field_err';
					var text = bad(D._('USERS_REGISTRATION_PASSWORDS_TOO_SHORT'));
				}
				form.find('[name="password2"],[name="password1"]').removeClass('field_ok').removeClass('field_err').addClass(class_name);
				$('#users_registration_check_password').html(text);
			});
			
		};
		
		this.onready = function() {
			self.new_pm_check();
			$('.cms_login_form').each(function(){
				var form = this;
				$(this).find('.cms_login_form_submit').click(function(){
					me.run_authorization(form);
					return false;
				});
			});
		};
		
		me.init_warnings_control = function(uid) {
			// рендерим управление 
			var controller = "<div class='warnings_container'></div><div class='warnings_controls'>" +
					"<a href='#' onclick='return D.modules.users.make_user_warning(${uid});'>Добавить</a>" +
					"<a href='#' onclick='return D.modules.users.set_user_ban(${uid});'>Блокировать</a> /" +
					"<a href='#' onclick='return D.modules.users.set_user_unban(${uid});'>Разблокировать</a>";
			$.tmpl(controller, {'uid' : uid}).appendTo('#user' + uid + '_warnings');
			me.get_user_warnings(uid,'admin');
		};
		
		this.set_user_ban = function(uid) {
			var block_days = prompt("Введите срок блокировки в днях:","1");
			if(block_days != null || !isNaN(parseInt(block_days)) ) {
				me.call('set-user-ban', {data: {'uid' : uid, 'block_days' : block_days }, success: function(answer) {
					if(answer.status == 'OK') {
						
						D.ui.notify(D._('USERS_USER_BANNED'));
					} else {
						alert("Ошибка блокировки пользователя!");
					}
				}});
			} else {
				alert("Количество дней введено неправильно!");
			}
			return false;
		};
		
		this.set_user_unban = function(uid) {
			if(!confirm("Разблокировать пользователя?")) {
				return false;
			}
			me.call('set-user-ban', {data: {'uid': uid, 'mode': 'unban'}, success: function(answer){
				if(answer.status == 'OK') {
					alert("Пользователь разблокирован");
				}
			}});
			return false;
		};
		
		this.render_user_warning = function(warning, mode) {
			var warning_admin_data = "<span id='user_warning_${wid}' class='single_warning'><span class='warning_time'>${time}</span>${msg}" +
			"<a href='#' class='delete_link' onclick='return D.modules.users.delete_user_warning(${wid},${uid});'>Удалить</a></span>";
			var warning_user_data = "<span id='user_warning_${wid}' class='single_warning'><span class='warning_time'>${time}</span>" +
					"<span class='warning_message'>${msg}</span>";
			warning.time = new Date(warning.add_time * 1000).toGMTString();
			if(mode != undefined && mode == 'user') {
				$.tmpl(warning_user_data, warning).appendTo('#moderator_warnings');
			} else {
				$.tmpl(warning_admin_data, warning).appendTo('#user' + warning.uid + '_warnings .warnings_container');
			}
		};
		
		this.get_user_warnings = function(uid,mode) {
			// загружаем список предупреждений пользователю
			me.call('get-user-warnings', { data: {'uid': uid }, success: function(answer) {
				// а теперь обрабатываем все
				$.each(answer, function(index,warning) {
					me.render_user_warning(warning,mode);
				});
			}});
		};
		
		this.delete_user_warning = function(wid,uid) {
			if(!confirm("Удалить предупреждение пользователю?")) {
				return false;
			}
			// теперь выполняем запрос на удаление предупреждения
			me.call('delete-user-warning', {data: {'wid': wid, 'uid' : uid}, success: function(answer){
				if(answer == 'OK') {
					$('#user_warning_' + wid).remove();
					// предупреждение успешно удалено
					D.ui.notify("Предупреждение успешно удалено!");
				} else {
					alert("Не удалось удалить предупреждение!");
				}	
			}});
			return false;
		};
		
		this.make_user_warning = function(uid) {
			var warning_text = prompt("Введите текст предупреждения:","");
			if(warning_text != null && warning_text != '') {
				me.call('submit-user-warning', { data: {'msg': warning_text,'uid':uid }, success: function(answer) {
					if(answer.status == 'OK') {
						me.render_user_warning(answer,'admin');
					} else {
						D.ui.notify("Произошла ошибка добавления предупреждения!");
					}
				}});
			} else {
				D.ui.notify("Ошибка");
			}
		};
		
		this.rebind_chats = function() {
			$('#users_private_chats .users_single_private_chat').each(function(){
				var uid = $(this).attr('uid');
				$(this).find('.users_private_chat_title').click(function() {
					me.open_pm_chat(uid);
				});
			});
		};
		
		this.update_password = function() {
			var old_password = $('INPUT[name="old_password"]').val();
			var new_password1 = $('INPUT[name="new_password1"]').val();
			var new_password2 = $('INPUT[name="new_password2"]').val();
			
			self.run('update-my-password', {'old_password' : old_password, 'new_password1' : new_password1, 'new_password2': new_password2},
				self.password_updated, self.password_error
			);
			
			return false;
		};
		
		this.password_updated = function(answer) {
			
		};
		
		this.password_error = function(error_code) {
			alert(test);
		};
	});
})(D);
