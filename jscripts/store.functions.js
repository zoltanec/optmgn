(function(D) {
	D.register('store', new function() {
		var self = this;

		self.shift=$('div.product_show').width();
		
		self.onready = function() {
			var timer;
			var flaf_hover=0;

			// select small image for show in show-product
			$('.goods-frame__item-sml').live("hover",function(){
				$('.goods-frame__item-sml.active').removeClass('active');
				$(this).addClass('active');
				var src = $(this).find('.goods-frame__image-sml').attr('src');
				$('.goods-frame__image-big').attr('src', src);

				return false;
			});

			// change good's item's panel's text
			$('.tabs-goods__item').live("click",function(e){
				e.preventDefault();
				var panel_id = $(this).attr('data-id');
				if (!$(this).hasClass('active')) {
					$('.tabs-goods__item').removeClass('active');
					$(this).addClass('active');
					$('.tabs-goods__panel').removeClass('active').hide();
					$('#' + panel_id).addClass('active').show();
				}
			});

			//change value of product after loading page
			//change type of product and show prices of all products in basket
			function changeValue() {
				if($("#basket-replace").length != 0){
					var cartTotal = 0;

					//first part
					$('.cart-item').each(function(){
						var quant = $(this).find('input[name=quantity]').val();
						cartTotal += quant * $(this).attr('data-current-box-price');
					});
					
					//second part
					if(cartTotal <= 20000){
						price_type = 'Белая';
						percent = 1;
					}else if(cartTotal <= 80000){
						price_type = 'Зелёная';
						percent = 0.95;

					}else if(cartTotal <= 200000){
						price_type = 'Синяя';
						percent = 0.93;
					}else if (cartTotal >= 200000){
						price_type = 'Красная';
						percent = 0.9;
					}
					
					$(".cart-item").each(function(key, e){
						var productSumItem = $(e).find('.multiply-price');
						var quant = $(e).find('input[name=quantity]').val();
						//without discount price
						var price = $(e).attr('data-current-price');
						var boxPrice = $(e).attr('data-current-box-price');

						$(e).find('.box-price').find('.price__value').text(parseInt(boxPrice * percent));
						$(e).find('.current-price').find('.price__value').text(parseInt(price * percent));
						$(e).find('.product-sum').find('.price__value').text(parseInt(boxPrice * percent * quant));
						var economy = boxPrice * quant - boxPrice * quant * percent;
						$(e).find('.prod-economy span').text(parseInt(economy)).show();
						if(percent != 1){
							$(e).find('.box-price-old').find('.price__value').text(boxPrice);
							$(e).find('.old-price').find('.price__value').text(price);
							$(e).find('.product-sum-old').find('.price__value').text(boxPrice * quant);
						}else{
							$('.price_old').find('.price__value').text('');
							$(e).find('.prod-economy').hide();
						}
					});
					$('.all-orders-prices-sum, .bulk-total').text(cartTotal * percent);
					$('.cart-total').text(cartTotal);
					$('.economy-value').text(cartTotal - cartTotal * percent);
					
					$('.price-type').text(price_type);
				}
			}

			//add or subtract quantity of product
			$('a.put__arrow').live("click",function() {
				var quantityInput = $(this).parents('.put__counter').find('input[name=quantity]');
				var quantity = quantityInput.val();
				if($(this).hasClass('put__arrow_minus')) {
					if(quantity > 1) {
						quantity--;
					}
				} else {
					quantity++;
				}
				quantityInput.val(quantity);

				if($(this).hasClass("put__arrow_basket")) {
					var product_price = $(this).parents(".cart-table__tr").find(".multiply-price");
					var quant = $(this).parent().find('input[name=quantity]').val();
					product_price.each(function(){
						var static_price = $(this).attr('data-price');
						var	p = static_price * quant;
						if(p != 0){
							$(this).text(p);
						}
					});
					return changeValue();
				}
				return false;
			});

			//delete a product
			$('.cart-table__close').live("click",function() {
				$(this).parent().parent().remove();
			})

			$('.remove_all_basket').live("click",function(){
				$('.cart-table').find('.cart-table_custom_line').remove();
			})

			//slider hit new sale
			function slider(item) {
				var itemCount = 0;
				var itemsLength = $(item).find('.item-hit').length;
				
				if($(item).find('.item-hit').length <= 4) {
					$(item).find('.slider-nav').hide();
				}
				
				$(item).find('.item-hit').each(function(key, item) {
					if(itemCount < 4){
						$(item).show();
					} else {
						return false;
					}
					itemCount++;
				})
			}
			$('.slider-wrap').each(function(key, item) {
				slider(item);
			});

			//slider next and prev
			$(".slider").live("click",function() {
				console.log('init');
				var thisButton = $(this);
				var product = thisButton.parents('.slider-wrap').find('.item-hit');
				var itemsLength  = product.length;
				var currentPosition = parseInt(thisButton.parents('.slider-wrap').attr('data-position'));
				console.log(currentPosition);
				if(!currentPosition) {
					currentPosition = 0;
				}
				console.log(currentPosition);
				
				if ($(this).hasClass("slider-next")) {
					sliderPosition = currentPosition + 4;
					console.log(sliderPosition + '/' + Math.ceil(itemsLength / 4) * 4);
					if(sliderPosition >= Math.ceil(itemsLength / 4) * 4){
						sliderPosition = 0;
					}
					product.hide();
					product.slice(sliderPosition, sliderPosition + 4).show();

				}else{
					sliderPosition = currentPosition - 4;
					console.log(sliderPosition + '/' + (Math.ceil(itemsLength / 4) * 4));
					if(sliderPosition <= 0){
						sliderPosition = Math.ceil(itemsLength / 4) * 4;
					}
					product.hide();
					product.slice(sliderPosition - 4, sliderPosition).show();
				}
				thisButton.parents('.slider-wrap').attr('data-position', sliderPosition);
			});
				
			$('.paginator a').on("click", function(){
				alert();
				var page = parseInt($(this).attr('data-page'));
				$('form.bl-filter_form--element input[name=page]').attr('value',page);
				$('form.bl-filter_form--element').submit();
				return false;
			});

			$('.bl-sub_menu--wrapper a, .responsive-menu-categories a').each(function(){
				var current = $('.bl-sub_menu--wrapper').attr('data-current');
				if(current == '') {
					return false;
				}
				var href = $(this).attr('href');
				var preg = new RegExp(current);
				if(preg.test(href)) {
					$(this).addClass('active');
					$(this).parent('div').addClass('active');
					if($(this).parents('div.dropdown').length){
						$(this).parents('div.dropdown').addClass('active');
					}
					$('.bl-sub_menu--wrapper').addClass('active');
					var active = $(this).parent('div').attr('data-id');
					$('.bl-main_menu-wrapper nav a').each(function(){
						if($(this).attr('href') == '#' + active) {
							$(this).parent('div').addClass('active');
						}
					});
				}
			});
			
			//add bookmark
			$(".addBookmark").live("click",function(){
				$(this).html('Нажмите «Ctrl + D» для добавления страницы в закладки');
				$(document).keydown(function(e) {
					if (e.keyCode == 68 && e.ctrlKey) {
						$(".addBookmark").html('<a rel="sidebar">Добавить в закладки</a>');
					}
				});
			})




				//Добавляем в список продукты
				if($('DIV.gallery DIV.product').length || $('#content .basket_product_item').length){
					$('.product, .basket_product_item').each(function() {
						self.list.add($(this).attr('data-prod-id'));
					});
				}
                
                $(".to-cart, .l-goods-i__incart_add-one").live("click",function(){
                    var toCart = $(this);
                    var product = $(this).parents('.product-item');
                    if(product.length) {
                        var quantity = product.find('input[name=quantity]').val();
                    } else {
                        product = $('.product_actions');
                        var quantity = $('input[name=quantity]').val();
                        if(toCart.hasClass(











								'l-goods-i__incart_add-one')) {







                            quantity = 1;
                        }
                    }
                    self.run('add-to-cart', {'product': product.attr('data-prod-id'),'quantity': quantity}, function(answer) {
                        if(answer.success) {
                            $('.header-basket').html(answer.html);
                            $('.l-goods-i__incart_basket_cnt').html(answer.quantity + ' кор.');
                            toCart.parents('.goods__put').find('.l-goods-i__incart, .put__btn_in_basket').show();
                            toCart.parents('.goods__put').find('.to-cart-block').hide();
                        } else {
                            console.log('Error add product to cart');
                        }
                    });
                    return false;
                });
				
				//Изменение продуктов в пакете
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

				//Проверка телефона
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
					}
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
		};

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
	});
})(D);
