(function(D) {
	D.register('store', new function() {
		var self = this;
		self.last_prod_id = 0;
		self.last_wheel_time = 0;
		self.wheel_delay = 200;
		self.list = new D.ObjectsList();
		self.self_delivery_coef = 0.95;
		self.exclick_locker = false;
		self.mode = 'default';
		self.default_name = '';
		self.default_phone = '';
		self.minimum_amount = 200;
		self.map_started = false;

		self.shift=$('div.product_show').width();
		self.onready = function() {

				var timer;
				var flaf_hover=0;

				//Добавляем в список продукты
				if($('DIV.gallery DIV.product').length || $('#content .basket_product_item').length){
					$('.product, .basket_product_item').each(function() {
						self.list.add($(this).attr('data-prod-id'));
					});
				}

				$("#main_slider #slider_wrap > div.product_show").hide();
				$(window).load(function(){
					if($('#main_slider').length!=0){
						var total=$('#main_slider div.product_show').length;
						$('#main_slider div.product_show img').each(function(){
							var src=$(this).attr('data-src');
							$(this).attr('src',src);
						});
					}
					$('.product_item img').animate({'opacity':1},200);
					return false;
				});

				//Загрузка слайдера
				$('#main_slider .product_item').last().find('img').load(function(){
					$("#loader").hide();
					$("#main_slider #slider_wrap > div.product_show").show();
					//$('#mininav, .left_arrow, .right_arrow').show();
					timer = setInterval(slideAuto, 4000);

				});

				$('#slider').mouseover(function(){
					flaf_hover=1;
				}).mouseout(function(){
					flaf_hover=0;
				});
				resizeSite();

				function slideAuto() {
					if(flaf_hover) return false;
					clearInterval(timer);
					var next=$('#slider_dots div.active').next();
					if(!next.length)
						next=$('#slider_dots div').first();
					$('#main_slider #slider_wrap').animate({'left':-self.shift},500,function(){
							$("#main_slider #slider_wrap > div:first-child").clone().appendTo("#main_slider #slider_wrap");
							$("#main_slider #slider_wrap > div:first-child").detach();
							$('#main_slider #slider_wrap').css('left',0);
					});
					//var next=$('#slider_dots div.active').next();
					//if(!next.length)
					//		next=$('#slider_dots div').first();
					$('#main_slider #slider_dots div').removeClass('active');
					next.addClass('active');
					timer = setInterval(slideAuto, 4000);
					return false;
				}

				$(window).resize(resizeSite);
				function resizeSite(){
					$('div.product_show').css('width',$(window).width());
					self.shift=$('div.product_show').width();
				}
				$('.nav').bind('click',changeSlide);
				function changeSlide(){
					var next;
					$('.nav').unbind('click',changeSlide);
					if($(this).hasClass('right_arrow') || $(this).hasClass('dot_arrow_right')){
						next=$('#slider_dots div.active').next();
						if(!next.length)
							next=$('#slider_dots div').first();
						$('#main_slider #slider_wrap').animate({'left':-self.shift},500,function(){
							$('.nav').bind('click',changeSlide);
							$("#main_slider #slider_wrap > div:first-child").clone().appendTo("#slider_wrap");
							$("#main_slider #slider_wrap > div:first-child").detach();
							$('#main_slider #slider_wrap').css('left',0);
						});
					}else{
						next=$('#slider_dots div.active').prev();
						if(!next.length)
							next=$('#slider_dots div').last();
						$("#main_slider #slider_wrap > div:last-child").clone().prependTo("#slider_wrap");
						$('#main_slider #slider_wrap').css('left',-self.shift);
						$('#main_slider #slider_wrap').animate({'left':0},500,function(){
								$('.nav').bind('click',changeSlide);
								$("#main_slider #slider_wrap > div:last-child").detach();
						});
					}
					$('#slider_dots div').removeClass('active');
					next.addClass('active');
					return false;
				}
			$('#slider_dots div').bind('click',slideByDots);

			function slideByDots(){
					//$('#slider_dots div').unbind('mouseover',slideByDots);
					var prev=number($('#slider_dots div'),'active');
					$('#slider_dots div').removeClass('active');
					$(this).addClass('active');
					var current=number($('#slider_dots div'),'active');
					var total=current-prev;
					if(total<0) total*=-1;
						if(current-prev>0)
							slideRight(total);
						else slideLeft(total);
				}
			function slideRight(total){
					if(total<=0)
						return false;
					$('#slider_wrap').animate({'left':-self.shift},0,function(){
						$("#slider_wrap > div:first-child").clone().appendTo("#slider_wrap");
						$("#slider_wrap > div:first-child").detach();
						$('#slider_wrap').css('left',0);
						total--;
						if(total>0)
							slideRight(total);
					});
				}
			function slideLeft(total){
					if(total<=0)
						return false;
					$("#slider_wrap > div:last-child").clone().prependTo("#slider_wrap");
					$('#slider_wrap').css('left',-self.shift);
					$('#slider_wrap').animate({'left':0},0,function(){
						$("#slider_wrap > div:last-child").detach();
						total--;
						if(total>0)
							slideLeft(total);
					});
				}
			function number(element,id){
					var i=0;
					var result=0;
					element.each(function(){
						++i;
						if($(this).attr('class')=='active')
							result=i;
					});
					return result;
				}

			self.rebind_products();
			//!Добавление товара в корзину
			$('.buy_button').live('click', function(){
				var product = $(this).parents('.product_item');
				var quantity = product.find('input[name=quantity]');
				var wok = $(this).parents('.product_item').find('.wok_select');
        var wok_select;
        if(wok.length){
          wok_select = wok.val();
					if(!wok_select)
						alert('Укажите основу для вашей лапши!');
				}
				self.run('add-to-cart', {'product':product.attr('data-prod-id'),'quantity':quantity.val(),'wok':wok_select},function(answer) {
					$('.order_info').html(answer);
          console.log(wok.length);
          if(!wok.length)
            product.find('.button_small_text').html('Еще');
				});
				return false;
			});

			var show_order = function(){

				self.run('order', function(answer) {
					self.modal_render(answer);
					$('SELECT[name="delivery"]').bind('change', self.update_cart_total);
					self.update_cart_total();

					if(!self.storage.isset('order_name') ) {
						self.storage.set('order_name', self.default_name);
					}
					if(!self.storage.isset('order_phone')) {
						self.storage.set('order_phone', self.default_phone);
					}

					// autosave and autorestore
					$('.order_save').each(function(){
						var name = $(this).attr('name');

						if(self.storage.isset(name)) {
							$(this).val(self.storage.get(name));
						};
						$(this).bind('keyup', function(){
							self.storage.set(name, $(this).val());
						});
					});


				});
				return false;
			};

			//!Открытие корзины
			$('.show-order').click(show_order);
			$('.button_back').live('click',function() {
				$('.store_order_form_block').hide();
				$('.store_order_content').show();
				var width = $('.store_order_form_content').width();
				var margin_left = width / 2;
				$('.modal_window').animate({'width' : '840px', 'margin-left': '-' + margin_left + 'px'});
			});

			//!Закрытие модального окна
			$('.modal_close, .close').live('click',function(){
				self.close_modal();
				return false;
			});

			//!Изменение продуктов в пакете
			$("a.manage_packet, a.blank_pack, .delete_item, .item_quantity").live("click",function(){
				var button = $(this);
				var product = button.parents(".packet_item");
				var pack = button.parents(".packet");
				var action = button.attr('data-action');
				var hash = button.parents(".packet_item").attr('data-hash');
				var qvisual="input";
				var quantity=product.find(".quantity");
				var qval = parseInt(quantity.val());
				if(!qval){ var qval = parseInt(quantity.html());
				  var qvisual="span";
				}
				if( action == 'minus' && ( ( qval == 1 && quantity.attr('data-null') == '0') || qval == 0 ) ) {
					return false;
				}
				 if(action=='plus') {
						++qval;
						if(qvisual=="input")
						quantity.attr("value", qval);
						else quantity.html(qval);
					} else if(action=='minus' ) {
						qval--;
						if(qvisual=="input")
						quantity.attr("value", qval);
						else quantity.html(qval);
					}
				self.run('change-cart', {'prod':product.attr('data-prod-id'),
										'pack': pack.attr('data-pack-id'),
										'hash': hash, 'quantity': qval, 'action':action },function(answer) {


					if(action=='del') {
						product.detach();
						if(!$(".packet_item").length)
							self.run('order', function(answer) {
								$('.basket_content').html(answer);
							});
						else $(".packet_item").last().find('.hr_line').removeClass('b_clear').addClass('parenthesis');
						self.updateCart

					} else if(action=='dubl' || action=='del_pack') {
					    $(".modal_window").html(answer);
					} else if(action==''){
						self.close_modal();
					}

					if( action == 'plus' || action == 'minus') {
						product.find('.prod_total').html( parseFloat(product.attr('data-price')* qval));
						product.find('.prod_total').attr('data-price',parseFloat(product.attr('data-price') * qval));
					}

					pack.find(".total_value_price").html(answer);
					$('.total').html(answer);
					$('INPUT.discount_cart').attr('data-price',answer);
					self.update_cart_total();
				});
				return false;
			});

			//! Заказ звонка
			$('.call_order').live('click',function(){
				if($(this).hasClass('blocked'))
					return false;
				if($(this).hasClass('active')){
					$('#call_order').hide();
					$(this).removeClass('active')
				}else {
					$('#call_order').show();
					$(this).addClass('active');
				}
				return false;
			});
			$('INPUT[name="callback_phone"], INPUT[name="order_phone"]').live('keyup', function(){
				var phone = $(this);
				var replace = /[^0-9 \-\+\)\(]/;
				var phone_val = phone.val().replace(replace, '');
				self.checkPhone(phone_val);
				phone.val(phone_val);
			});

			$('.request_callback_button').live('click',function(){
				var phone = $('INPUT[name="callback_phone"]').val();
				if(!self.checkPhone(phone))
					return false;
				phone=phone.replace(/((\d)(\d{3})|\d{0})(\d{2,3})(\d{2})(\d{2})/g, '$2 $3 $4-$5-$6');
				self.run('request-callback-exec', {'phone' : phone}, function(answer){
					if(answer == 'OK') {

						$('#call_order_form').hide();
						$('.call_order').removeClass('active');
						$('.call_order').addClass('blocked')
						$('.co_successful').show();
						var timer2=setInterval(function(){
							$('.co_successful').hide();
							$('#call_order').hide();
							$('#call_order_form').show();
							$('.call_order').removeClass('blocked');
							$('#call_order co_title').html('Ваш номер телефона');
							$('INPUT[name="callback_phone"]').removeClass('order_not_entered');
							clearInterval(timer2);
						},4000);
					}
				});
				return false;
			});

			//!ПРоверка телефона
			self.checkPhone=function(phone){
				var replace = /[^0-9]/g;
				phone=phone.replace(replace, '');
				if(!( phone.length==11 && phone.charAt(0)=="8" || phone.length==12 && phone.charAt(0)=="+" || phone.length==6 || phone.length==7)) {
					var cols;
					if(phone.length<6)
						cols=6;
					else cols=11;
					$('#call_order_form .co_title').html('Номер должен состоять минимум из '+cols+' цифр').addClass('order_not_entered');
					$('INPUT[name="callback_phone"]').addClass('order_not_entered');
					return false;
				}else{
					$('#call_order_form .co_title').html('Ваш номер телефона').removeClass('order_not_entered');
					$('INPUT[name="callback_phone"]').removeClass('order_not_entered');
				}
				return true;
			};

			//! Переход к форме заказа
			$('.order_btn').live('click',function(){
				$('.store_order_content').hide();
				$('.store_order_form_block').show();
				var width = $('.store_order_form_block').width();
				var margin_left = width / 2;
				$('.modal_window').css('margin-left', '-' + margin_left + 'px !important').animate({'width' : width + 'px'});
				$('.modal_window_wrap > DIV').css('margin-top', '100px');
				self.start_map();
				return false;
			});

			//! Проверка полей ввода
			$('.store_order_form_block input[name=order_phone], .store_order_form_block input[name=order_address]').blur(function(){
				if($(this).val()!=''){
					phone = $(this).val();
					phone = phone.replace(/^(\+?)|[^0-9]*/g,"$1");
					if($(this).attr('name')=="order_phone" && !(phone.length==11 && phone.charAt(0)=="8" || phone.length==12 && phone.charAt(0)=="+" || phone.length==6)) {
							return false;
					}
					$(this).next().show();
					$(this).next().next().hide();
					$(this).removeClass('order_not_entered');
				}//else{
				//	$(this).addClass('order_not_entered');
				//	$(this).next().hide();
				//	$(this).next().next().show();
				//}
				return false;
			});

			//! Оформление заказа
			$(".submit_order").live("click",function(){
				var error = false;
				if($('.order_required').length){
					$('.order_required').each(function(){
						var name = $(this);
						var value = $(this).val();
						phone = value.replace(/^(\+?)|[^0-9]*/g,"$1");
						if(value == '' || ($(this).attr('name')=="order_phone" && !(phone.length==11 && phone.charAt(0)=="8" || phone.length==12 && phone.charAt(0)=="+" || phone.length==6))) {
							error = true;
							$(this).addClass('order_not_entered');
							$(this).next().hide();
							$(this).next().next().show();
						}
					});
				}
				if(error) return false;

				var phone = $("form#submit_order input[name=order_phone]").val();
				var order_name=$("form#submit_order input[name=order_name]").val();
				var delivery = $('INPUT[name="nodelivery"]').is(':checked');
				var discount = $('INPUT[name="discount_flag"]').val();
				//var delivery_val = $('SELECT[name="delivery"]').val();
				var payment = $('SELECT[name="payment"]').val();
				if($('INPUT[name=order_address]').length)
				var order_address = $('INPUT[name=order_address]').val();
				else var order_address = '';
				var addr_parts = ['str','house','flat'];
				for(var part in addr_parts) {
					if($('INPUT[name="order_address_' + addr_parts[part] + '"]').length)
					order_address = order_address + ' ' + $('INPUT[name="order_address_' + addr_parts[part] + '"]').val();
				}

				var order_descr = $("form#submit_order TEXTAREA[name='order_descr']").val();

				if(delivery) {
					delivery = 0;
				} else {
					delivery = 1;
				}
				phone=phone.replace(/((\d)(\d{3})|\d{0})(\d{2,3})(\d{2})(\d{2})/g, '$2 $3 $4-$5-$6');
				self.run('submit-order', { 'order_phone': phone,
					'order_name'    : order_name,
					'order_address' : order_address,
					 'order_descr'  : order_descr,
					     'delivery' : delivery,
						 'discount' : discount,
					      'payment' : payment},
					function(answer){
						$('.basket_content').html(answer);
						self.updateCart();
				});
				return false;
			});
			//! Сортировка
			$('#sorting_input div').live('click',function(){
				var current=$(this);
				self.sort_prod(current);
				return false;
			});
			$('#sorting_input input').live('click',function(){
				self.sort_prod();
			});

			self.preload();
		};

		self.soft_load = function() {
		//!Плавная загрузка превью
				$('.product_item img').css('opacity',0);
				$('.product_item img').each(function() {

					$(this).bind('load', function(){
						//alert(1);
						$(this).animate({'opacity': 1},400);
					});
					$(this).attr('src', $(this).attr('data-src'));
				});
		};

		self.sort_prod = function(current) {
			var without_fish=0;
			var vega=0;
			if(current){
			var input=current.prev();
			if(input.is(':checked'))
				input.removeAttr('checked');
			else input.attr('checked','checked');
			}
			if($('INPUT[name="without_fish"]').is(':checked')) {
				without_fish=1;
			}
			if($('INPUT[name="vega"]').is(':checked')) {
				vega=1;
			}
			var category = $('INPUT[name="category"]').val();
			self.run('sort-products/mexico', {'vega':vega,'without_fish':without_fish,'category':category}, function(answer){
				$('.gallery').html(answer);
				self.rebind_products();
				self.list.elements=[];
				$('DIV.product').each(function() {
						self.list.add($(this).attr('data-prod-id'));
				});
			});
			return false;
		};
		self.start_map = function() {
			if(self.map_started) return true;
			self.map_started = true;
			$.getScript('http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=fid_134806358407019964441');
		};
		/*$('#nodelivery, #h_delivery').live('click',function(){
			if( $('INPUT[name="nodelivery_flag"]').val()==0 ) {
				$('INPUT[name="nodelivery_flag"]').attr('value',1);
				$('input.nodelivery').attr('checked','checked');
			}else {
				$('INPUT[name="nodelivery_flag"]').attr('value',0);
				$('input.nodelivery').removeAttr('checked');
			}
			var delivery_flag=$('INPUT[name="nodelivery_flag"]').val();
			var discount_flag=$('INPUT[name="discount_flag"]').val();
			self.run('set-delivery', {  'discount' : discount_flag}, function(answer) { //'nodelivery' : delivery_flag,
				$('#order_delivery_details').attr('class','delivery_' + delivery_flag);
			});
			self.update_cart_total();

		});*/

		$('#discount, #h_discount').live('click',function(){
			if( $('INPUT[name="discount_flag"]').val()==0 ) {
				$('INPUT[name="discount_flag"]').attr('value',1);
				$('input.discount_cart').attr('checked','checked');
			}else {
				$('INPUT[name="discount_flag"]').attr('value',0);
				$('input.discount_cart').removeAttr('checked');
			}
			var delivery_flag=$('INPUT[name="nodelivery_flag"]').val();
			var discount_flag=$('INPUT[name="discount_flag"]').val();
			self.run('set-delivery', { 'nodelivery' : delivery_flag, 'discount' : discount_flag}, function(answer) {
				//$('#order_delivery_details').attr('class','discount_' + discount_flag);
			});
			self.update_cart_total();

		});

		self.update_cart_total = function() {
			var total_cart_price = $('input.discount_cart').attr('data-price');//parseInt($(".total").html());
			var delivery_price = parseInt($('SELECT[name="delivery"] OPTION:selected').attr('data-price'));
			//var delivery_name = $('SELECT[name="delivery"] OPTION:selected').attr('data-name');

			//$('#delivery_area .delivery_name').html(delivery_name);
			//var no_delivery_flag=$('INPUT[name="nodelivery_flag"]').val();
			var discount_flag=$('INPUT[name="discount_flag"]').val();
			var discount;

			//if(no_delivery_flag==1 && discount_flag==1)
			//	discount=0.9;
			//else 
      if(discount_flag==1)
				discount=0.95;
			//else if(no_delivery_flag==1)
			//	discount=0.95;
			else
				discount=false;

			console.log(discount);
			if( discount ) {
				if(!delivery_price)
				   delivery_price=$('INPUT[name="nodelivery_top"]').attr('data-price');
        console.log(delivery_price);
				if(total_cart_price)
					$('.basket_total .total_value_price,.total').html(parseInt( total_cart_price * discount));
				//Стоимость продуктов в корзине
				$('.prod_total').each(function(){
					var prod_price=$(this).attr('data-price');
					$(this).html(parseInt(prod_price*discount));
				});
				//Стоимость всех продуктов в разделе
				$('.product_item').each(function(){
					var prod_price=$(this).attr('data-prod-price');
					$(this).find('.prod_price').html(parseInt(prod_price*discount));
				});
			} else {
				if(!delivery_price)
				   delivery_price=$('INPUT[name="nodelivery_top"]').attr('data-price');
				if(total_cart_price)
					$('.basket_total .total_value_price,.total').html(total_cart_price);
				//Стоимость продуктов в корзине
				$('.prod_total').each(function(){
					var prod_price=$(this).attr('data-price');
					$(this).html(prod_price);
				});
				//Стоимость всех продуктов в разделе
				$('.product_item').each(function(){
					var prod_price=$(this).attr('data-prod-price');
					$(this).find('.prod_price').html(prod_price);
				});
			}
			return false;
		};

		self.flush_cart = function() {
			self.run('flush-cart', {}, function(answer){
				if ( answer.status == 'OK' ) {
					$('.store_cart_non_empty').hide();
					$('#empty_order').show();
					self.updateCart();
					$('.product .buy_button .button_small_text').html('ДОБАВИТЬ');
				}
			});
			return false;
		};

		self.self_delivery = function() {
			var checkbox = $('INPUT[data-type="self_delivery"]');
			var status = checkbox.is(':checked');

			if(status) {
				$('SPAN[data-type="user_delivery"]').css('opacity','0.5');
				$('SELECT[name="delivery"]').attr('disabled',true);
			} else {
				$('SPAN[data-type="user_delivery"]').css('opacity','1');
				$('SELECT[name="delivery"]').attr('disabled',false);
			}
			self.update_cart_total();
		};

		self.rebind_products = function() {
			$('DIV[data-type="product"], table tbody[data-type="product"]').each(function(){
				var product = $(this);
				$(this).find('.product_name,.product_image,.promo_product').unbind('click').click(function(){
					return self.show_product( product.attr('data-prod-id'));
				});
			});
		};



		self.show_product = function(product) {
			var next=self.list.next(product);
			var prev=self.list.prev(product);
			var prods=new Array(product,next,prev);

			if(next==product && prev==product)
			var prods=new Array(product);

			self.run('show-product', { 'products' : prods }, function(answer) {
				self.modal_render(answer);
				if($('.basket_product_item').length)
					$('.modal_wrapper .button').hide();
				$('div.product_show').css('width',$(window).width());
				self.shift=$('div.product_show').width();
				//!Закрытие модального окна
				$('#modal_window_preview > DIV').exclick(function() {
					D.modules.store.close_modal();
				});
				self.preload();
			});
			return false;
		};

		self.prev = function() {
			prod_id=$('.product_item.active').attr('data-prod-id');
			var prev_id = self.list.prev(prod_id);
			var prev = $('.modal_wrapper .product_item[data-prod-id='+prev_id+']');

			var preload_img=new Image();
			var preload_src=$('.product_item[data-prod-id='+self.list.prev(prev_id)+'] .product_image').attr('src');
			preload_src=preload_src.replace('thumbs/','');
			preload_img.src=preload_src;

			self.run('append-product', {'product' : prev_id }, function(answer) {
				if(!prev.length){
					$(".modal_wrapper #slider_wrap > div:last-child").after(answer);
					if($('.basket_product_item').length)
						$('.modal_wrapper .button').hide();
					prev = $('.modal_wrapper .product_item[data-prod-id='+prev_id+']');
				}
				$('#slider_wrap .product_item').removeClass('active');
				prev.addClass('active');
				$('div.product_show').css('width',$(window).width());
				//!Анимация
				$(".modal_wrapper #slider_wrap > div:last-child").clone().prependTo(".modal_wrapper #slider_wrap");
				$('.modal_wrapper #slider_wrap').css('left',-self.shift);
				$('.modal_wrapper #slider_wrap').animate({'left':0},500,function(){
					$(".modal_wrapper #slider_wrap > div:last-child").detach();
				});
				self.preload();
				return false;
			});
		};

		self.next = function() {
			prod_id=$('.product_item.active').attr('data-prod-id');
			var next_id = self.list.next(prod_id);
			var next = $('.modal_wrapper .product_item[data-prod-id='+next_id+']');

			var preload_img=new Image();
			var preload_src=$('.product_item[data-prod-id='+self.list.next(next_id)+'] .product_image').attr('src');
			preload_src=preload_src.replace('thumbs/','');
			preload_img.src=preload_src;

			self.run('append-product', {'product' : next_id }, function(answer) {
				if(!next.length){
					$(".modal_wrapper #slider_wrap > div:first-child").after(answer);
					if($('.basket_product_item').length)
						$('.modal_wrapper .button').hide();

					next = $('.modal_wrapper .product_item[data-prod-id='+next_id+']');
				}
				$('div.product_show').css('width',$(window).width());
				//!Анимация
				$('.modal_wrapper #slider_wrap').animate({'left':-self.shift},500,function(){
					$(".modal_wrapper #slider_wrap > div:first-child").clone().appendTo(".modal_wrapper #slider_wrap");
					$(".modal_wrapper #slider_wrap > div:first-child").detach();
					$('.modal_wrapper #slider_wrap').css('left',0);
				});
				$('#slider_wrap .product_item').removeClass('active');
				next.addClass('active');
				self.preload();
				return false;
			});
		};
		self.preload = function() {
			$('div.product_show.active .product_image_preloader').show();
			//!Прогрузка картинок и скрытие прелоадера
			var image=$('div.product_show.active img.product_image_original');
			var src=image.attr('src');
				image.css('opacity','0.1');
				image.attr('src','');
				image.attr('src',src);
				image.load(function(){
					$('div.product_show.active .product_image_preloader').hide();
					image.show();
					image.animate({'opacity':'1'},200);
				});
			return false;
		};
		self.close_modal = function() {
			$('.modal_window_wrap').animate({'opacity':'0'},50,function(){
				$('.modal_window_wrap').remove();
				$('BODY').css('overflow','auto');
			});
		};


		self.show_prod = function(prod_id) {
			self.last_prod_id = prod_id;
			self.run('show-product', {'product' : prod_id }, function(answer) {
				self.modal_render(answer);
				$('div.product_show').css('width',$(window).width());
			});
			return false;
		};

		self.updateCart = function() {
			self.run('cart', function(answer) {
				$(".order_info").html(answer);

			    if($(".order_info .total").length && parseInt( $(".order_info .total").html()) >= self.minimum_amount ){
						if($("div.cond").length)
							$("div.cond").hide();
						$(".order_btn").show();
					} else {
						if($("div.cond").length)
							$("div.cond").show();
						$(".order_btn").hide();
					}
			});
			return false;
		};

		self.save_store_profile = function(){
			var data = $('FORM.profile_info').get_input_data();

			self.run('update-profile', data , function(answer){
				if(answer.status == 'OK') {
					$('.profile_upd').show();
					setTimeout(function(){
						$('.profile_upd').hide();
					}, 5000);
				}
			});
			return false;

		};

		self.modal_render = function(answer) {
			$('BODY').css('overflow','hidden');
			$('.modal_window_wrap').remove();
			$('BODY').append(answer);
			$('.modal_wrapper').css('opacity','0');
			$('.modal_wrapper').animate({'opacity':'1'},350);
			$('.modal_wrapper').exclick( self.close_modal, 'DIV.modal_window_wrap');

			var minimum_top = parseInt( $('.modal_window_wrap > DIV').css('margin-top'));
			var maximum_top = -999999;
			setTimeout(function(){
				maximum_top = 0 - ( parseInt( $('.modal_window_wrap > DIV').height() - 0.5 * $(window).height()) );
			}, 1000);

			$('BODY').wheel(function(delta){
				return false;
				if( $('.modal_window_wrap').length != 0 ) {
					var elem = $('.modal_window_wrap > DIV');
					var margin_top = parseInt($(elem).css('margin-top')) + delta * 30;
					if(margin_top >= minimum_top ) margin_top = minimum_top;

					$('.modal_window_wrap > DIV').css('margin-top', margin_top + 'px');
					return true;
				} else {
					return false;
				}
			});

		}
	});
})(D);
