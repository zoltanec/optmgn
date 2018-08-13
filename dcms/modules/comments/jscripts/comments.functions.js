function showHideBBText(elemid) {
	var blockId = '#cm_hidden_text' + elemid;
	if($(blockId).is(':visible')) {
		$(blockId).hide();
	} else {
		$(blockId).show();
	}
	return false;
}
var Comments = function(settings) {
	var self = this;
	if(settings.object_id != undefined ) {
		self.object_id = settings.object_id;
	} else {
		throw new Error("No object id");
	}
	if(settings.current_page != undefined ) {
		self.current_page = settings.current_page;
	} else {
		throw new Error("Wrong current page!");
	}
	if(settings.last_page != undefined ) {
		self.last_page = settings.last_page;
	} else {
		throw new Error("Wrong last page!");
	}
	if(settings.order_mode != undefined) {
		self.order_mode = settings.order_mode;
	} else {
		throw new Error("Wrong order mode!");
	}
	if(settings.perpage != undefined) {
		self.perpage = settings.perpage;
	} else {
		self.perpage = 50;
	}
	
	this.isDownloadActive = false;
	this.lastDownloadActivation = 0;
	this.redownloadPeriod = 5000;
	this.isBinderStarted = false;
	this.empty_comments_loads = 0;
	this.append_page_started = false;
	this.append_page_num = 0;
	// оригинальный контент комментариев
	this.commentsOriginalContent = {};
	
	this.setObjectID = function(object_id) {
		// меняем идентификатор объекта
		self.object_id = object_id;
	};
	
	this.insertLink = function(nick,id) {
		tEditor.addText("[["+nick+']]: #'+id + "\n");
		return false;
	};
	
	this.rebindKarma = function() {
		$('.karma').each(function(index) {
			if($(this).html() >= 0) {
				$(this).addClass('positive_karma');
			} else {
				$(this).addClass('negative_karma');
			}
		});
	};
	
	this.rebindMenuButton = function() {
		$('.comments TBODY').each(function() {
			var comid = $(this).attr('title2');
			var button = $(this).find('.comment_button_user');
			if(typeof button[0].onclick=='function') {
				return true;
			} else {
				button[0].onclick = function(){ 
					if(button.find('UL').is(':visible')) {
							button.find('UL').hide();
					} else {
						$('.comments TBODY .comment_button_user UL').hide();
						button.find('UL').show();
						setTimeout(function(){
							button.find('UL').hide();
						},7000);
					}
				};
			}
		});
	};
	

	
	this.updateComment = function(inComid, inMode) {
		$.getJSON(siteVars.www + '/comments/update-comment-karma/comid_' + inComid + '/mode_' + inMode, function(karma) {
			switch(karma.result) {
				case 'OK':
					if(karma.karma >= 0 ) {
						spanClass = 'positive';
					} else {
						spanClass = 'negative';
					}
					$('#comment_karma_' + inComid).html(karma.karma).addClass(spanClass);
					break;
				case 'UNAUTH': alert(commentsMessages.YOU_NEED_TO_AUTHORIZE_FIRST); break;
				case 'KARMA_BLOCKED': alert(commentsMessages.COMMENTS_VOTE_LIMIT_REACHED); break;
			case 'NO_SUCH_COMMENT':  alert(commentsMessages.NO_SUCH_COMMENT); break;
			case 'SELF_KARMING': alert(commentsMessages.VOTING_OWN_MESSAGES_PROHIBITED); break;
			default: alert(commentsMessages.ERROR_UPDATING_RATING);
			}	
		});
		return false;
	};
	
	
	
	this.start_comments_download = function() {
		self.downloadLatestComments();
	};

	this.downloadLatestComments = function() {
		
	};
	
	this.cmSendAbuse = function(comid) {
		var reason = prompt('Причина жалобы','');
		// checking if we have reason
		if(reason!= null && reason.length > 2) {
			$.post(siteVars.www + '/comments/abuse-comment/', { 'comid' : comid, 'reason': reason, 'url': document.location.href}, function(answer) {
				if(answer == 'OK') {
					alert('Спасибо за бдительность. Жалоба отправлена');
				}
			});
			return false;
		}
		return false;
	};
	

	
	
	
	this.rebindPager = function() {
		$('.cm_page_link').click(function() {
			var page = $(this).attr('title');
			self.getPage(page);
			return false;
		});
	};
};

(function(D) {
	D.register('comments', new function() {
		var me = this;
		me.original_content = {};
		// count of empty comments load
		me.empty_comments_loads = 0;
		// is download script is active
		me.is_download_active = false;
		// last download script activation
		me.last_download_activation = 0;
		// last comments page
		me.last_page = 0;
		// current comments page
		me.current_page = 0;
		// order mode
		me.order_mode = 'normal';
		// page number for nopage scrolling
		me.append_page_num = 0;
		// append page trigger
		me.append_page_started = false;

		me.edit_comment = function(comid) {
			var comment_block = $('#usercomment' + comid);
			var old_html = comment_block.find('.comment_html').html();
			var loader_string = '<img src="' + me.images + '/loader.gif">';
			
			comment_block.find('.comment_html').html(loader_string);
			
			me.call('edit-comment', {'data':{'comid': comid},'success':function(answer){
					if(answer == 'UNAUTH') {
						D._('UNAUTH');
						return false;
					}
					comment_block.find('.comment_html').html(answer);
					// store original content in object
					me.original_content[comid] = $(answer).find('[name=content]').val();
					// bind content sender
					comment_block.find('.submit_comment').click(function(){
						var new_content = comment_block.find('[name=content]').val();
						var moderator_note = comment_block.find('[name=moderator_note]').val();
					
						if( new_content == me.original_content[comid]) {
							comment_block.find('.comment_html').html(old_html);
						}
						
						comment_block.find('.comment_html').html(loader_string);
						
						// иначе похоже у нас было изменение данных
						me.call('update-comment',{data:{'comid': comid, 'content': new_content, 'moderator_note': moderator_note}, success:function(answer) {
							if(answer == 'UNAUTH') {
								alert(D._('UNAUTH'));
							} else {
								comment_block.find('.comment_html').html(answer);
							}
						}});
					});
				
					comment_block.find('.submit_reset_button').click(function(){
						if( comment_block.find('[name=content]').val() != me.original_content[comid]) {
							if(!confirm(D._("COMMENTS_COMMENT_WAS_CHANGED_CONFIRM_EXIT"))) {
								return false;
							} else {
								comment_block.find('.comment_html').html(old_html);
							}
						} else {
							comment_block.find('.comment_html').html(old_html);
						}
					});
			}});
			return false;
		};
		
		this.delete_comment = function(comid) {
			if(!confirm(D._('COMMENTS_CONFIRM_COMMENT_DELETE'))) {
				return false;
			}
			me.run('delete-comment', {'comid':comid}, function(answer) {
				if(answer.status == 'OK') {
					$('TABLE.comments TBODY[data-comid="' + comid + '"]').remove();
				}
			});
			return false;
		};
		
		// start new comments downloader
		this.start_comments_download = function() {
			me.download_latest_comments();
		};
		
		this.get_page = function(page) {
			$('TABLE.comments').css('opacity', 0.3).css('cursor','wait');
			me.run('get-comments-page/', { 'object_id' : me.object_id, 'cmpage': page, 'cmperpage': me.perpage, 'order_mode': me.order_mode }, function(answer) {
				$('#comments_page').html(answer).css('opacity', 1).css('cursor','default');
				me.current_page = page;
			});
			return false;                                                   	                                                    
		};
		
		// download latest comments
		this.download_latest_comments = function() {
			if( ! ( ( me.last_page == me.current_page || me.last_page == 0 ) || 
					( me.append_page_num != 0 && me.append_page_num == me.last_page ) ) ) {
				return false;
			}
			
			var current_timestamp = new Date().getTime();
			if(self.isDownloadActive && self.lastDownloadActivation > currentTimestamp - 4 * self.redownloadPeriod) {
				return false;
			}
			/*starting download */
			me.is_download_active = true;
			me.last_download_activation = current_timestamp;
			// find last comment id
			var last_comid = (me.order_mode=='reverse') ? $('.comments > TBODY:first').attr('data-comid') : $('.comments > TBODY:last').attr('data-comid');
			
			me.run('get-latest-comments', {'object_id': me.object_id, 'comid': last_comid, 'order_mode': me.order_mode }, function(answer) {
				me.is_download_active = false;
				if(answer == '') {
					me.empty_comments_loads = me.empty_comments_loads + 1;
					return true;
				} else {
					me.empty_comments_loads = 0;
				}
				if( me.order_mode == 'reverse') {
					$('.comments_container').prepend(answer);
				} else {
					$('.comments_container').append(answer);
				}
				// self.rebindMenuButton();
			});
			setTimeout(function() {
				me.download_latest_comments();
			}, me.get_next_download_timeout());
		};
		
		// next time when we need to download our comments 
		this.get_next_download_timeout = function() {
			var min_Y = 6;
			var kX = 0.029;
			var kY = 190;
			var Y = Math.floor(( kY/(1+Math.exp((-1)*kX * me.empty_comments_loads))) - kY/2);
			return (Y < min_Y ) ? min_Y * 1000 : Y * 1000;
		};
		
		
		// download and append next page
		this.append_next_page = function() {
			if(me.append_page_started) return true;
			me.append_page_started = true;
			setTimeout(function() {
				me.append_page_started = false;
			}, 10000);
			if(me.append_page_num == 0) {
				me.append_page_num = parseInt(me.current_page);
			}
			if(me.order_mode == 'reverse') {
				if(me.append_page_num > 1 ) {
					page = me.append_page_num - 1;
				} else {
					return false;
				}
			} else {
				if(me.append_page_num < self.last_page) {
					page = me.append_page_num + 1;
				} else {
					return false;
				}
			}
			me.run('get-comments-page', {'object_id':me.object_id,'cmpage': page,'cmperpage': me.perpage, 'order_mode': me.order_mode, showmode: 'only-comments'}, 
					function(answer) {
	            		$('.comments_container').append(answer);
	            		me.append_page_num  = page;
	            	//.rebindMenuButton();
	            	//self.append_page_started = false;
	        });
			return true;
		};
		
		
		// submit comment to server
		this.submit_comment = function(form) {
			var submit_button = $(form).find('.submit_ok');
			
			var comment_text = $('#textInput').val();
			if(comment_text == '') {
				return false;
			}

			if(submit_button.is('.submit_disabled')) {
				return false;
			}
			
			//blocking button
			submit_button.attr('disabled','disabled').addClass('submit_disabled');
			me.run('post-comment', {'object_id':  me.object_id, content: comment_text}, function(answer) {
					if(answer.status == 'OK') {
						$('#textInput').val('');
					}	 else if ( answer.status == 'UNAUTH') {
						alert(D._('UNAUTH'));
					} else if ( answer.status == 'NO_SUCH_USER') {
						return false;
					} else if ( answer.status == 'COMMENT_NOT_FOUND') {
						return false;
					} else if ( answer.status == 'EMPTY_CONTENT') {
						return false;
					} else if ( answer.status == 'APPROVE_NEEDED') {
						$('#textInput').val('');
						alert(D._('COMMENTS_MESSAGE_WILL_BE_APPROVED_AFTER_MODERATOR_CHECK'));
					}
					submit_button.removeAttr('disabled').removeClass('submit_disabled');
					me.empty_comments_loads = 0;
					setTimeout(function() {
						me.download_latest_comments();
					}, 200);
			});
			return false;
		};
		
		// initialize comment object
		this.init = function(data) {
			me.object_id = data.object_id;
			me.last_page = data.last_page;
			me.current_page = data.current_page;
		};
		
		this.onready = function() {
			$('#comment_submit').bind('submit', function(){
				return me.submit_comment(this);
			});
			$('.comments_submit_comment').bind('click', function() {
				$('#comment_submit').submit();
				return false;
			});
			
			me.start_comments_download();

			//comments.rebindKarma();

			$('#textInput').keyup(function (e) {
				if(e.which == 17) isCtrl=false;
			}).keydown(function (e) {
				if(e.which == 17) isCtrl=true;
				if(e.which == 13 && isCtrl == true) {
					$('#comment_submit').submit();
					return false;
				}
			});
			//tEditor.setActiveEditor(document.getElementById('textInput'));
			//comments.rebindPager();
			//comments.rebindMenuButton();
		};
	});
})(D);

/*
 * jQuery plugin: fieldSelection - v0.1.0 - last change: 2006-12-16
 * (c) 2006 Alex Brem <alex@0xab.cd> - http://blog.0xab.cd
 */
(function() {
	var fieldSelection = {
		getSelection: function() {
			var e = this.jquery ? this[0] : this;
			return (
				/* mozilla / dom 3.0 */
				('selectionStart' in e && function() {
					var l = e.selectionEnd - e.selectionStart;
					return { start: e.selectionStart, end: e.selectionEnd, length: l, text: e.value.substr(e.selectionStart, l) };
				}) ||
				/* exploder */
				(document.selection && function() {
					e.focus();
					var r = document.selection.createRange();
					if (r == null) {
						return { start: 0, end: e.value.length, length: 0 }
					}
					var re = e.createTextRange();
					var rc = re.duplicate();
					re.moveToBookmark(r.getBookmark());
					rc.setEndPoint('EndToStart', re);
					return { start: rc.text.length, end: rc.text.length + r.text.length, length: r.text.length, text: r.text };
				}) ||
				/* browser not supported */
				function() {
					return { start: 0, end: e.value.length, length: 0 };
				}
			)();
		},
		replaceSelection: function() {
			var e = this.jquery ? this[0] : this;
			var text = arguments[0] || '';
			return (
				/* mozilla / dom 3.0 */
				('selectionStart' in e && function() {
					e.value = e.value.substr(0, e.selectionStart) + text + e.value.substr(e.selectionEnd, e.value.length);
					return this;
				}) ||
				/* exploder */
				(document.selection && function() {
					e.focus();
					document.selection.createRange().text = text;
					return this;
				}) ||
				/* browser not supported */
				function() {
					e.value += text;
					return this;
				}
			)();
		}
	};
	jQuery.each(fieldSelection, function(i) { jQuery.fn[i] = this; });
})();