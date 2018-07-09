<{if $cart}>
<{foreach item=pack key=pack_id name=pack from=$cart}>
<table id="basket_wrap" class="packet" data-pack-id="<{$pack_id}>">
	<{assign var=pack_summ value=0}>
	<{foreach name=items item=data key=hash from=$pack}>
	<{if $data.visible}>
			<{assign var=prod_id value=$data.prod_id}>
			<{assign var=prod value=D_Core_Factory::Store_Product($prod_id)}>
			<{$pack_summ=$pack_summ+$prod->current_price*$data['quantity']}>
		<tbody data-type="product" data-prod-id="<{$prod->prod_id}>" data-price="<{$prod->current_price}>" data-quantity="<{$data.quantity}>" data-hash="<{$hash}>" class="product_item basket_product_item packet_item">
		<tr>
		<td class="bt_img"><img class="product_image" src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" /></td>
		<td class="bt_a">
			<a class="product_name" href="<{$me.www}>/store/show-product/product_<{$prod->prod_id}>">
				<{$prod->prod_name}>
			</a>
			<{if !empty($data.descr)}>
				<span class="cart_desc"><{$data.descr}></span>
			<{/if}>
		</td>
		<td class="bt_price"><span class="product_price product_total" >
		<span class="prod_total" data-price="<{$prod->current_price*$data.quantity}>"><{if $discount}><{floor($prod->current_price*$data.quantity*$discount)}><{else}><{$prod->current_price*$data.quantity}><{/if}></span> руб.</span></td>
		<td class="bt_numbers">
			<div class="b_numbers">
			<div class="bn_minus trans_back item_quantity" data-action="minus"></div>
			<div class="bn_number quantity" data-null="0"><{$data['quantity']}></div>
			<div class="bn_plus trans_back item_quantity" data-action="plus"></div>
			</div>
		</td>
		<td class="bt_delete">
			<div class="b_delete trans_back delete_item" data-action="del"></div>
		</td>
		</tr>
		<tr class="hr_line <{if !$smarty.foreach.items.last}>b_clear<{else}>parenthesis<{/if}>"><td colspan="5"></td></tr>
		</tbody>
	<{/if}>
     <{/foreach}>
     <tbody><tr><td colspan="5">
     <div class="basket_total"><span><span>Итого</span> <span class="total_value_price"><{if $discount}><{floor($pack_summ*$discount)}><{else}><{$pack_summ}><{/if}></span> руб.</span></div>
     </td></tr></tbody>
      <tbody><tr><td colspan="5"><div class="basket_discount">
 <{*div id="h_delivery"><input class="nodelivery" name="nodelivery" type="checkbox" data-type="self_delivery" data-price="<{$pack_summ}>" <{if !Store_Cart::checkDelivery()}>checked="checked"<{/if}>/><label>Самовывоз</label><span>-5%</span></div>
 <div id="h_discount"><input class="discount_cart" name="discount" type="checkbox" data-type="discount" data-price="<{$pack_summ}>" <{if Store_Cart::checkDiscount()}>checked="checked"<{/if}>/><label>Накопительная скидка</label><span>-5%</span></div*}>
</div>  </td></tr></tbody>

	</table>
	<{/foreach}>
	<{assign var=curr value=time()}>
    <a id="order_btn" class="order" style="<{if $curr|date_format:"%H"<=11 || $curr|date_format:"%H">=22}>opacity:0.5;<{/if}><{if $cart_total.total_cost<300}>display:none;<{/if}>" href="<{$me.www}>/store/order-form"></a>
<div class="store_order_form_block">
<div class="lured_arrow"></div>
<div class="pull">
   <div class="titles"><span>Оформление заказа</span></div>
</div>
<div class="pull">
 <form id="submit_order">
 <div class="basket_form bf_short">
 <label>Ваше имя</label>
 <input type="text" name="order_name" /><div class="input_successful"></div>
 </div>
 <div class="basket_form bf_short">
 <label>Телефон</label>
 <input class="order_required" type="text" name="order_phone"  /><div class="input_successful"></div><div class="warning"><div></div>Пожалуйста, введите ваш номер телефона.</div>
 </div>
 <div class="basket_form bf_long">
 <label>Адрес</label>
 <input class="order_required" type="text" name="order_address" /><div class="input_successful"></div><div class="warning"><div></div>Пожалуйста, введите ваш адрес.</div>
 </div>
 </form>
</div>
<br />
<br />
<br />
<br />
<div class="line_title"><span>И мы перезвоним вам в течении 10 минут</span></div>
<div class="busket_button_next">
 <div class="button submit_order"><div><span>Отправить</span></div></div>
</div>
</div>
<{else}>
    У вас нет ни одного заказа!
<{/if}>