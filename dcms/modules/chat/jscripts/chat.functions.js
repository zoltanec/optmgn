(function(D) {
	D.register('chat', new function() {
		var me = this;
		
		me.last_msgid = 0;
		// active users list
		me.users = {};
		me.uid = 0;
		me.colors = {};
		me.smiles = {};
		
		me.get_chat_messages = function() {
		//	alert(me.last_msgid);
			me.call('get-chat-messages', {data : {'last_msgid' : me.last_msgid}, success: function(messages) {
				//alert(messages);
				for(var i in messages) {
					if(messages[i].msgid > me.last_msgid) {
						me.append_message(messages[i]);
						me.last_msgid = messages[i].msgid;
					}
				}
			}});
			setTimeout(function(){
				me.get_chat_messages();
			},2000);
		};
		me.append_message = function(msg) {
			var user_info = me.get_user_info(msg.uid);
			switch(msg.type) {
				case '1': 
					me.append_raw_message(msg.message,msg);
					break;
				case '3':
					var raw_user_info = msg.message.split(';;;');
					var info = { 'uid': msg.uid, 'visible_name' : raw_user_info[0], 'avatar' : raw_user_info[1],'color': raw_user_info[3]};
					me.append_user_info(info);
					me.append_raw_message(' присоединился к нашему чату.',msg);
					break;
				case '4':
					me.append_raw_message(' покинул наш чат.', msg);
					me.user_exited(msg.uid);
					break;
				case '5':
					me.change_user_color(msg);
					break;
				case '6':
					me.deleted_message(msg);
					break;
			}
			me.scroll_bottom();
		};
		
		me.append_raw_message = function(content,msg) {
			if(typeof msg != 'object') {
				return false;
			}
			var time = new Date(msg.add_time * 1000);
			var time_string = (time.getMinutes() < 10 ) ? time.getHours() + ':0' + time.getMinutes() : time.getHours() +':' + time.getMinutes();
			var user_info = me.get_user_info(msg.uid);
			var message = '<div class="chat_user_message" data-msgid="' + msg.msgid + '" data-uid="' 
			+ msg.uid + '"><div class="chat_msg_functions"></div><span class="chat_msg_time">' + time_string + '</span>' 
			+ '<span class="chat_visible_name" style="color: #' + me.get_color(user_info.color) + '">' + user_info.visible_name + ':</span>' + content + '</div>';
			var message = $(message);
			//$('#chat_messages').append(message);
			
		//	alert("go");
			if(msg.uid == me.uid) {
				message.find('.chat_msg_functions').append('<span class="chat_rollback_message">X</span>');
				message.find('.chat_rollback_message').click(function(){
					if(!confirm("Сообщение будет удалено, продолжить?")) {
						return false;
					}
					me.delete_message(msg.msgid);
				});
			}
			message.find('.chat_visible_name').click(function() {
				me.insert_text(user_info.visible_name + ',');
			});
			$('#chat_messages').append(message);
			return true;
		};
		
		me.deleted_message = function(msg) {
			var msgid = msg.message;
			$('#chat_messages DIV[data-msgid="' + msgid + '"]').remove();
		};
		
		me.delete_message = function(msgid) {
			me.call('delete-message', {'data' : {'msgid' : msgid}, success: function(answer){
				if(answer.status == 'OK') {
					$('#chat_messages DIV[data-msgid="' + msgid + '"]').remove();
				}
			}});
		};
		
		me.change_user_color = function(msg) {
			var colors = msg.message.split(';;;');
			me.users[msg.uid].color = colors[0];
			me.append_raw_message(' сменил свой <span style="color: #' + me.get_color(colors[1]) + '">старый цвет</span> ' +
					'на <span style="color: #' + me.get_color(colors[0]) + '">новый цвет</span>.',msg);
		};
		
		me.get_color = function(color) {
			if(color in me.colors) {
				return me.colors[color];
			} else {
				return '000000';
			}
		};
		
		me.get_chat_colors = function() {
			me.call('get-chat-colors', {success: function(answer){
				if(typeof answer == 'object') {
					me.colors = answer;
				}
				// now lets 
				for(var color in me.colors){
					$('.chat_colors_select').append('<div data-color="' + color + '" style="background: #' + me.colors[color] + ';"></div>');
				}
				$('.chat_colors_select DIV').click(function(){
					var color = $(this).attr('data-color');
					me.call('set-user-color', {'data' : {'color' : color}, success: function(answer){
						if(answer.status == 'OK') {
							me.users[me.uid].color = color;
							$('.chat_colors_select').hide();
						}
						
						//alert(answer.status);
					}});	
				});
			}});
			$('#chat_colors_select_button').click(function() {
				var colors_block = $('.chat_colors_select');
				if( colors_block.is(':visible')) {
					colors_block.hide();
				} else {
					colors_block.show();
				}
			});
		};
		
		
		me.insert_text = function(value) {
			var val = $('#chat_message_input').val() + value ;
			$('#chat_message_input').val(val);
		};
		
		me.bind_chat_exit = function() {
			//$('.chat_exit').click(function(){
				//me.call('')
			//});
		};
		
		
		me.get_user_info = function(uid) {
			if(uid in me.users && me.users[uid] != undefined ) {
				return me.users[uid]; 
			} else {
				return {visible_name: 'NA', uid: 0};
			}
		};
		
		me.get_users_list = function() {
			me.call('get-users-list', {success: function(users) {
				//me.users = users;
				// таблица пользователей 
				for(var i in users) {
					me.append_user_info(users[i]);
				}
			}});
		};
		me.append_user_info = function(info) {
			if(info.uid in me.users && me.users[info.uid].active) {
				return true;
			}
			info.active = true;
			me.users[info.uid] = info;
			var avatar = (info.avatar != '') ? D.content + '/users/avatars/' + info.avatar : D.theme_images + '/users/default_avatar.png';
			var user_block = '<table class="chat_user_contact" data-uid="' + info.uid + '">' + 
			'<tr><td rowspan="2" class="chat_user_avatar"><img src="' + avatar + '">' + 
			'</td><td class="chat_user_name">' + info.visible_name + '</td></tr><tr><td class="chat_user_status"></td></tr></table>';
			$('#chat_contacts').append(user_block);
		};
		
		me.user_exited = function(uid) {
			if(uid in me.users) {
				me.users[uid].active = false;
			}
			$('.chat_user_contact[data-uid="' + uid + '"]').remove();
		};
		
		
		
		me.bind_chat_messages_block = function() {
			$('#chat_messages').css('height','100px');
			var height = $('.chat_messages').height();
			$('#chat_messages').css('height',height + 'px');
		};
		
		me.scroll_bottom = function() {
			$('#chat_messages').scrollTop(1000000);
		};
		
		me.bind_chat_sender = function() {
			$('#chat_message_input').keyup(function (e) {
				if(e.which == 17) isCtrl=false;
			}).keydown(function (e) {
					if($('#chat_on_ctrl_enter_send').is(':checked')) {
						if(e.which == 17) isCtrl=true;
					} else {
						isCtrl = true;
					}
			   		if(e.which == 13 && isCtrl == true) {
			   			me.send_message();
						return false;
					}
			});
			$('.chat_send').click(me.send_message);
			// smiles
			$('.chat_smiles_input IMG').click(function(){
				me.insert_text( $(this).attr('data-code'));
			});
		};
		
		me.load_smiles_list = function(smiles) {
			me.smiles = smiles;
		};
		
		me.parse_text = function(msg){
			return me.parse_smiles(msg.replace(/</g,'&lt;').replace(/>/g,'&gt;'));
		};
		
		me.parse_smiles = function(text) {
			for(var smile in me.smiles) {
				text = text.toString().split(smile).join('<img src="' + D.theme_images + '/smiles/' + me.smiles[smile] + '">'); 
			}
			return text;
		};
		
		me.trim = function(string) {
		    return string.replace(/^\s*/, "").replace(/\s*$/, "");
		};
		
		me.send_message = function() {
			var input = $('#chat_message_input');
			var msg = input.val();
			if(me.trim(msg) == '') {
				return false;
			}
			input.attr('disabled',true);
			var message = {'message': msg, 'uid' : me.uid, 'type':1};
			message.add_time = new Date().getTime() / 1000;
			me.call('send-message', {data : {'msg':msg}, success:function(answer) {
				if(answer.status == 'OK') {
					input.removeAttr('disabled').val('');
				}
				message.msgid = answer.msgid;
				me.append_raw_message(me.parse_text(msg), message);
				me.scroll_bottom();
				$('#chat_message_input').focus();
			}});
			setTimeout(function(){
				input.removeAttr('disabled');
			},5000);
		};
		
		me.onready = function(){
			setTimeout(me.get_chat_messages, 1000);
			me.bind_chat_messages_block();
			me.bind_chat_sender();
			me.bind_chat_exit();
			me.uid = $('.chat_main_window').attr('data-uid');
			$(window).resize(function() {
				me.bind_chat_messages_block();
			});
			me.get_chat_colors();
			me.get_users_list();
			
		};
	});
})(D);