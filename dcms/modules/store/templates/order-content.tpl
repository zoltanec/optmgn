<div <{if $cart_total.total_cost>=300}>style="display:none;"<{/if}> class="attention cond">Сумма заказа должна быть не менее 300р.</div>
<div <{if time()|date_format:"%H">11 && time()|date_format:"%H"<21}>style="display:none;"<{/if}> class="attention advert">Прием заказов с 11:00 до 22:00!</div>
		<div id="order">
<{if $cart}>
    <{foreach item=pack key=pack_id name=pack from=$cart}>
    <{assign var=pack_summ value=0}>
	<div class="packet">
		<div class="packet_title">
			<span><{$smarty.foreach.pack.iteration}> пакет</span>&nbsp;&nbsp;&nbsp;
	     	<a class="duplicate_pack" href="<{$me.www}>/store/change-cart/pack_<{$pack_id}>/action_dubl"><img src="<{$theme.images}>/double.png" />Дублировать</a>&nbsp;&nbsp;&nbsp;
			<a class="delete_pack" href="<{$me.www}>/store/change-cart/pack_<{$pack_id}>/action_del"><img src="<{$theme.images}>/delete.png" />Удалить</a>
		</div>
		<div class="packet_content">
		<{foreach item=data key=prod_id from=$pack}>
			<{assign var=prod value=D_Core_Factory::Store_Product($prod_id)}>
			<{$pack_summ=$pack_summ+$prod->price*$data['quantity']}>
		<table border="0" class="packet_item">
			<tr>
				<td class="packet_item_image"><img src="<{$me.content}>/media/product<{$prod->prod_id}>/<{$prod->getPicture()->fileid}>" /></td>
				<td class="packet_item_name"><a class="pd_link" href="<{$me.www}>/store/show-product/<{$prod->parent_category->category_code}>/<{$prod->category_code}>/product_<{$prod->prod_id}>"><{$prod->prod_name}></a><br /><span><{$prod->psc}>шт. <{$prod->weight}>гр.</span></td>
				<td class="packet_item_line"></td>
				<td class="packet_item_price">
					<div class="product_show_input">
						<div class="packet_price">
							<div class="price_digit"><span><{$prod->price}></span><span class="pd_rub">&#8399;</span></div>
						<input type="text" name="quantity" align="right" value="<{$data['quantity']}>" disabled="disabled" />
						</div>
					<div class="packet_number">
						<a class="item_quantity plus" href="<{$me.www}>/store/change-cart/pack_<{$pack_id}>/prod_<{$prod->prod_id}>/action_plus"></a>
						<a class="item_quantity minus" href="<{$me.www}>/store/change-cart/pack_<{$pack_id}>/prod_<{$prod->prod_id}>/action_minus"></a>
					</div>
					<a href="<{$me.www}>/store/change-cart/pack_<{$pack_id}>/prod_<{$prod->prod_id}>/action_del" class="delete_item"></a></div>
				</td>
			</tr>
		</table>
		<{/foreach}>
		<table border="0" class="packet_item">
			<tr>
				<td class="packet_item_image"></td>
				<td class="packet_item_name"></td>
				<td class="total_value">Общая стоимость:</td>	
				<td class=" product_show_input total_value_price"><div style="width:85px;text-align:right;"><span><{$pack_summ}></span><span class="pd_rub">&#8399;</span></div></td>
			</tr>
		</table>
		<{if $smarty.foreach.pack.total>1}>
			<a href="<{$me.www}>/store/change-pack/pack_<{$pack_id}>" class="change_packet"></a>
		<{/if}>
		</div>
    </div>
    <{/foreach}>
    <a id="order_btn" class="order" style="<{if time()|date_format:"%H"<=11 || time()|date_format:"%H">=22}>opacity:0.5;<{/if}><{if $cart_total.total_cost<300}>display:none;<{/if}>" href="<{$me.www}>/store/order-form"></a>
    <{else}>
    	<div id="empty_order">
    	У вас нет ни одного заказа!
    	</div>
    <{/if}>
</div>
<div class="add_packet"><a class="blank_pack duplicate_pack" href="<{$me.www}>/store/change-cart/action_dubl"><img src="<{$theme.images}>/add_packet.png" />Еще одна порция</a> 
    <span>Для удобства, мы сортируем суши и ролы по порциям. Это удобно, если вас больше одного человека.</span>
</div>