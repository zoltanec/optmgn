/*
 * Pages Module
 */
(function(D) {
	D.register('pages', new function() {
		var self = this;
		
		self.init_tree = function () {			

		};
		
		self.bind_tree_click = function (node_class){
			$(node_class).click( function() {
				//get object
				var object = self.get_object($(this));
				self.edit_page( object );
			});
		};
		
		self.bind_tree_toggle = function (toggle_class){
			$(toggle_class).click( function() {
				if($(this).hasClass('toggle_minus'))
					$(this).removeClass('toggle_minus').addClass('toggle_plus');
				else $(this).removeClass('toggle_plus').addClass('toggle_minus');
				$(this).parents('.tree_node').next('ul').slideToggle();
				return false;
			});
		};
		 

		self.bind_tree_right_click = function (node_class){
			
			$(node_class).bind('contextmenu', function(e){
				e.preventDefault();
				//Hide context menu
				self.hide_context_menu();
				
				var items = new Array();
				var object = self.get_object($(this));
				$(this).addClass('context_node');
				
				//Document name
				items[items.length] = self.build_context_item( $('<b>').html(object.pagetitle), false);
				
				//Separated line
				items[items.length] = self.build_context_item( '', false, $('<span>').addClass('sep_line'));
				
				//Edit document
				items[items.length] = self.build_context_item( 'Редактировать документ', function(){ 
					self.edit_page( object );
					return false;
				});
				
				//Create document
				items[items.length] = self.build_context_item( 'Создать документ', function() {
					self.hide_context_menu();
					self.run('add-page', { 'parent_id' : object.content_id }, function(answer){
							$('div#right_info_wrap').html(answer);
							self.update_tree();
							self.bind_change_pagetype('#select_type');
					});
					return false;
				});
				
				//Copy document
				items[items.length] = self.build_context_item( 'Копировать документ', function() {
					self.copy_page( object );
					return false;
				});
				
				//Separated line
				items[items.length] = self.build_context_item( '', false, $('<span>').addClass('sep_line'));
				
				//Set active/unactive
				var active_text = ( object.active == '1' ) ? 'неактивным' : 'активным';
				items[items.length] = self.build_context_item( 'Сделать ' + active_text, function() {
					self.hide_context_menu();
					var active = ( object.active == '1' ) ? '0' : '1';
					D.modules.core.set_object_active(object.object_id, active, function(answer){
						if ( answer.status == 'OK' ) {
							object.item.attr('data-active', active);
						}
						self.update_tree();
					});
					return false;
				});
				
				
				//Set active/unactive in menu
				var menu_active_text = ( object.menu == '1' ) ? 'неактивным' : 'активным';
				items[items.length] = self.build_context_item( 'Сделать ' + menu_active_text + ' в меню', function() {
					self.hide_context_menu();
					var menu_active = ( object.menu == '1' ) ? '0' : '1';
					D.modules.core.update_field(object.object_id, 'menu', 'update', menu_active, function(answer){
						if ( answer.status == 'OK' ) {
							object.item.attr('data-menu', menu_active);
						}
						self.update_tree();
					});
					return false;
				});
				
				//Delete document
				items[items.length] = self.build_context_item('Удалить документ', function() {
					self.delete_page( object );
					return false;
				});
				
				//Separated line
				items[items.length] = self.build_context_item('', false, $('<span>').addClass('sep_line'));
				
				//Open frontend document
				items[items.length] = self.build_context_item( 'Открыть в браузере', function() {
					self.run('open-page', {'content_id' : object.content_id }, function(answer){
						window.open(answer.url);
					});
					return false;
				});
								
				var menu = $('<div>').attr( 'id','pages_context_menu' );
				var menu_content = $('<ul>').addClass( 'context_menu' );
				
				//Append all function buttons in menu
				$.each(items, function(i,item){
					menu_content.append(item);
				});
				
				$(menu).append(menu_content);
				$(menu).css('z-index','99').css('top',e.pageY).css('left',e.pageX);
				$('body').append(menu);
				return false;
			});
		};
		
		self.bind_change_pagetype = function(node_class) {
			//Инициализация формы при редактировании страницы
			self.change_pagetype(node_class);
			$(node_class).change( function() {
				self.change_pagetype(node_class);
			});
		}
		
		self.change_pagetype = function(node_class) {
			var type = $(node_class).val();
			$('.form_row').hide();
				$('.def').show();
				switch(type) {
					case 'module':
					case 'link': $('.' + type).show(); break;
					default: $('.form_row').each(function(){
							//Если нет принадлежности к определенному типу, то показываем
							if($(this).attr('class')=='form_row')
								$(this).show();
						});
				}	
		}
		
		self.get_object = function( object_wrap ) {
			var object = {};
			if(!object_wrap)
				object.item = $('.active_node');
			else object.item = object_wrap.find('.node');
			object.content_id = object.item.attr('data-id');
			object.object_id = object.item.attr('data-object-id');
			object.active = object.item.attr('data-active');
			object.menu = object.item.attr('data-menu');
			object.pagetitle = object.item.text()
			
			return object;
		};
    
		self.selectMode = function() {
			if($("#mode :selected").val()=='html'){			
				tinyMCE.execCommand('mceRemoveControl',false,'rich'); 
			} else {
				tinyMCE.execCommand('mceAddControl',false,'rich'); 
			}
		};
		
		self.edit_page = function( object ) {
			//Hide context menu
			self.hide_context_menu();
			
			//set active class
			$('.active_node').removeClass('active_node');
			object.item.addClass('active_node');
			
			if(!object.content_id)
				return false;
			//Update edit form
			self.run('edit-page', { 'content_id' : object.content_id }, function(answer){
				$('div#right_info_wrap').html(answer);
				$('#mode').bind('change', self.selectMode);
				self.bind_change_pagetype('#select_type');
				D.modules.admin.bind_multifile_upload();
			});
			return false;
		};
		
		self.copy_page = function( object ) {
			//Hide context menu
			self.hide_context_menu();
			self.run('copy-page', { 'content_id' : object.content_id }, function(answer){
				self.update_tree();
			});
		};			

		self.delete_page = function( object ) {
			//Hide context menu
			self.hide_context_menu();
			
			if  ( object.length == 0 || !object.content_id) {
				alert('Не один объект не выбран.')
			} else {
				if ( confirm( "Вы действительно хотите удалить объект '"+object.pagetitle+"'" ) ){
					self.run( 'delete-page', {'content_id' : object.content_id }, function(){
						self.update_tree();
					});
				}
			}
			return false;
		};
		
		//Create button element in menu
		self.build_context_item = function (item_text, handler, item_wrap) {
			var add = $('<li>').addClass('context_menu_item');
			var content_item;
			if(!item_wrap)
				content_item = $('<a>').attr('href','#').html(item_text).click(handler);
			else content_item = item_wrap.html(item_text).click(handler);
			add.append(content_item);
			return add;
		};
		
		//Hide right-click context menu
		self.hide_context_menu = function () {
			$('#pages_context_menu').remove();
			$('.tree_node').removeClass('context_node');
		};
		
		self.update_tree = function () {
			var object = self.get_object();
			$('div#tree_nav').html('');
			self.run('tree', function(answer){
				$('div#tree_nav').html(answer);
				$('span[data-id=' + object.content_id + ']' ).addClass('active_node');
				self.bind_pages_functions();
			});
			return false;
		};
		
		self.bind_tabs = function () {
			var tabcontainer = $('.tabs_cont div'); // получаем массив контейнеров
		    tabcontainer.hide().filter(':first').show(); // прячем все, кроме первого
			// далее обрабатывается клик по вкладке
		    $('.st_tabs li a').click(function () {
			    tabcontainer.hide(); // прячем все таб-контейнеры
			    tabcontainer.filter(this.hash).show(); // показываем содержимое текущего
			    $('.st_tabs li a').removeClass('active'); // у всех убираем класс 'active'
			    $(this).addClass('active'); // текушей вкладке добавляем класс 'active'
			    return false;
		    }).filter(':first').click();
			return false;
		};
		
		self.bind_pages_functions = function () {
			self.bind_tree_click('.tree_node');
			self.bind_tree_right_click('.tree_node');
			self.bind_tree_toggle('.tree_toggle');
		};
		
		self.onready = function() {
			self.bind_pages_functions();
			
			$('body').click(function (){
				self.hide_context_menu();
			});
			
			$('#arrow_up').click( function() {
				$('.toggle_minus').each(function(){
					$(this).removeClass('toggle_minus').addClass('toggle_plus');
					$(this).parents('.tree_node').next('ul').slideToggle();
				});		
				return false;
			});
			
			$('#arrow_down').click( function() {
				$('.toggle_plus').each(function(){
					$(this).removeClass('toggle_plus').addClass('toggle_minus');
					$(this).parents('.tree_node').next('ul').slideToggle();
				});
				return false;
			});
			
			//Add document button in main panel
			$('#add_doc').click( function() {
				var obj = $('.active_node');
				if  ( obj.length == 0 ) {
					var parent_id = 0;
				} else {
					var parent_id = $(obj).attr('data-id');
				}
				self.run('add-page', { 'parent_id' : parent_id }, function(answer){
					$('div#right_info_wrap').html(answer);
					self.update_tree();
				});
				return false;
			});
			
			$('#copy').click( function() {
				//get object
				var object = self.get_object();
				self.copy_page( object );
			});
			
			//Delete button in main panel
			$('#delete_doc').click( function() {
				//get object
				var object = self.get_object();
				self.delete_page( object );
				return false;
			});
			
			//Update tree
			$('#refresh').click( function() {
				self.update_tree();
				return false;
			});
			
			//Update document
			$('#edit_page').live('submit', function() {
				if ( $('#mode:selected').val() != 'html' ) {
					$('textarea[name=content]').val(tinyMCE.activeEditor.getContent());
				}
			
				D.send_form('edit_page',function(answer) {
					$.each(answer.object, function(property, value) {
						//content_name
						//title
						//menutitle
						var form_item = $('input[name=' + property + ']');
						if(form_item.length)
							form_item.attr('value',value);
					});
					$('#submit_status').html('<b>SAVED</b>').hide().fadeIn(1000);
				});
				self.update_tree();
				return false;
			});
		};
		
	});
})(D);