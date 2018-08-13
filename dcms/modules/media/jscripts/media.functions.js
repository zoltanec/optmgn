(function(D) {
	D.register('media', new function() {
		var self = this;
		var me = this;
		// all files list
		me.files_list = new Array();
		// when file is selected call this handler
		me.on_file_select_handler = false;
		me.current_dir = '';
		me.current_file_num = -1;
		
		
		this.update_media_dir_stat = function(dirid) {
			if(confirm(D._('UPDATE_MEDIA_DIR_STAT',dirid))) {
				self.call('rebuild-dir-stat',{data: {'dirid' : dirid }, success : function(answer){
					alert(answer);
				}});
			}
			return false;
		};
		this.delete_dir = function(dirid) {
			if(confirm(D._('DELETE_MEDIA_DIR',dirid))) {
				self.call('delete-dir', {data: {'dirid' : dirid}, success: function(answer){
					if(answer == 'OK') {
						$('.media_current_dir_subdirs TR[title="dir-' + dirid + '"]').remove();
					}
				}});
			}
			return false;
		};
		this.delete_file = function(dirid,fileid,nowarn) {
			if(nowarn !== undefined || confirm(D._('DELETE_MEDIA_FILE'))) {
				self.call('delete-file',{ data: {'dirid' : dirid, 'fileid': fileid}, success: function(answer) {
					if(answer == 'OK') {
						$('.media_dir_files TR[title="' + fileid + '"]').remove();
					}
				}  });
			}
			return false;
		};
		
		this.delete_selected = function(dirid) {
			if(!confirm(D._('DELETE_SELECTED_MEDIA_FILES'))) {
				return false;
			}
			var to_delete = [];
			$('.media_dir_file').each(function() {
				var fileid = $(this).attr('title');
				if($(this).find('INPUT.media_file_checkbox').is(':checked')) {
					to_delete.push(fileid);
				}
			});
			self.call('delete-file', {data: {'dirid' : dirid, 'files' : to_delete.join(';;;')}, success: function(answer) {
				if(answer == 'OK') {
					for(var num in to_delete) {
						$('.media_dir_file[title="' + to_delete[num] + '"]').remove();
					}
				} 
			}});
			return false;
		};
		
		this.import_files_to_dir = function(dirid) {
			self.call('import-files', {data: {'dirid' : dirid}, success: function(answer) {
				UI.popup(answer);
			}});
			return false;
			//document.location.href = self.request_admin_path + '/import-files/dirid_' + dirid;
		};
		
		this.select_all_media_files = function(mode) {
			if(mode == 1 ) {
				$('.media_dir_file .media_file_checkbox').attr('checked',true);
			} else {
				$('.media_dir_file .media_file_checkbox').attr('checked',false);
			}
			return false;
		};
		
		this.run_files_import = function() {
			//alert("go");
			return false;
		};
		
		this.get_media_file = function(fileid) {
				var new_num = self.get_file_num(fileid);
				self.load_media_file(new_num);
		};

		this.load_media_file = function(filenum) {
			if(!(filenum in self.files_list)) {
				alert(filenum);
				return false;
			}
			var old_height = $('#media_content_container').height();
			$('#media_content_container').css('opacity', 0.3).css('height',old_height + 'px');
			var request = {};
			// request content
			request.data = {'dirid' : me.current_dir, 'fileid' : me.files_list[filenum].fileid};
			// request success function
			request.success = function(answer) {
				// checking for errors
					if(answer == 'NO_SUCH_FILE') {
						//coreJS.notify("Файл не найден");
					} else {
						comments.setObjectID(me.files_list[filenum].object_id);
						comments.getPage(1);
						me.current_file_num = filenum;
						document.location.hash = '#' + self.files_list[filenum].fileid;
						$('#media_content_container').html(answer).css('opacity',1);
						if(me.on_file_select_handler != false) {
							me.on_file_select_handler(self.files_list[filenum]);
						}
						// а теперь загружаем страницу с коммен
					}
			};
			me.call('show', request);
		};

		this.on_file_loaded = function() {
			$('#media_content_container').css('height','inherit');
		};

		this.mark_file_as_selected = function(filenum) {
			$('.photo_preview_current').removeClass('photo_preview_current');
			$('[title2=' + self.files_list[filenum].fileid + ']').addClass('photo_preview_current');
		};
		
		this.set_current_fileid = function(fileid) {
			me.current_file_num = me.get_file_num(fileid);
			if(me.on_file_select_handler != false) {
				me.on_file_select_handler(me.files_list[me.current_file_num]);
			}
		};
		
		this.get_prev_file = function() {
			var prev_file_num = me.current_file_num - 1;
			if(prev_file_num < 0 ) {
				prev_file_num = me.files_list.length - 1;
			}
			me.load_media_file(prev_file_num);
			return false;
		};

		this.get_next_file = function() {
			var next_file_num = me.current_file_num + 1;
			if(next_file_num >= me.files_list.length) {
				next_file_num = 0;
			}
			me.load_media_file(next_file_num);
			return false;
		};

		this.bind_show_page = function() {
			$('.media_go_prev').click(function() {
				return me.get_prev_file();
			});
			$('.media_go_next').click(function() {
				return me.get_next_file();
			});
		};
		
		this.append_file_to_list = function(file) {
			me.files_list.push(file);
		};
			// retrieve file num
		
		

		this.get_file_num = function(fileid) {
			for(var i = 0; i < me.files_list.length; i++ ) {
				if(me.files_list[i].fileid == fileid) {
					return i;
				}
			}
		};

		this.set_current_dir = function(dirid) {
			me.current_dir = dirid;
		};

		this.set_on_file_select_handler = function(callback) {
			if(callback != undefined && typeof callback == 'function') {
				me.on_file_select_handler = callback;
			}
		};

		this.set_required_file = function(fileid) {
			// требуемый файл
			if(me.files_list[me.current_file_num].fileid != fileid) {
				me.load_media_file(me.get_file_num(fileid));
			}
		};
	});
})(D);