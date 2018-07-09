<table class="cms_list store_single_order order_status_<{$order->status}> order_payment_<{$order->payment}>" data-list-funcs="delete" data-status="<{$order->status}>" data-upd-time="<{$order->upd_time}>" data-order-id="<{$order->order_id}>">
	<thead>
		<tr>
			<th><b>№</b></th>
			<th><b>Время</b></th>
			<th><b>Имя</b></th>
			<th><b></b></th>
			<td colspan="2"><b>#FUNCTIONS#</b></td>
		</tr>
	</thead>
	<tbody data-type="element" data-object-id="<{$order->object_id()}>">
		<tr>
			<td class="nid"><{$order->order_id}></td>
			<td class="nid"><{$order->add_time|convert_time}></td>
			<td class="order_name"><{$order->order_name}></td>
			<td rowspan="2" class="order">

				<div class="packet_content">

				<{assign var=pack_summ value=0}>
				<{foreach item=pack name=pack from=$order->getOrderPacks()}>

					<table class="store_order_packet">
					<{foreach item=product from=$pack}>
						<{assign var=prod value=D_Core_Factory::Store_Product($product->prod_id)}>
						<{$pack_summ=$pack_summ+$prod->current_price*$product->quantity}>
						<tr>
							<td class="packet_item_image"><img style="width: 40px;" src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" onerror="this.style.display = 'none'" /></td>
							<td class="packet_item_name"><b><{$prod->prod_name}></b><br /><{if $prod->weight}><span><{$prod->weight}>гр.</span><{/if}>
								<{if !empty($product->descr)}>
									<div class="packet_item_descr"><{$product->descr}></div>
								<{/if}>

							</td>
							<td class="packet_item_line"></td>
							<td class="packet_item_price">
								<div class="product_show_input">
									<div class="packet_price"><{if $prod->current_price}><span><{$prod->current_price}></span> руб.&nbsp;<{/if}><br>
								</div>
								</div>
							</td>
							<tD>x <{$product->quantity}> шт.</tD>
							<td><{if $prod->current_price}>= <{$product->quantity * $prod->current_price}> руб.<{/if}></td>
						</tr>
					<{/foreach}>
				</table>
			<{/foreach}>

			<b><span class="big">Итого стоимость товаров: </span><{$order->sum}> руб.<br />
			<{if $order->delivery}>
				Стоимость доставки: <{$order->delivery_payment}> руб.<br />
			<{/if}>	
			<{if $order->discount}>
				Скидка: <{$order->discount}> %<br />
			<{/if}>
            Итого: <{$order->sum + $order->delivery_payment}>

			</b><br>
			<{if !empty($order->description)}>
				<b>Примечание:</b><br>
				<{$order->description}>
			<{/if}>
			</td>
			<td rowspan="2" class="order_change_status">
				<{foreach item=status key=status_key from=Store_Cart::getStatuses()}>
					<a class="order_set_<{$status_key}>" href="<{$run.me}>/update-order/ordid_<{$order->order_id}>/mode_status/status_<{$status_key}>/"><{$status}></a><br />
				<{/foreach}>
				<a href="<{$run.me}>/edit-order/<{$order->order_id}>">Редактировать</a><br>
				<a href="<{$run.me}>/print-check/<{$order->order_id}>" target="_blank">Печать чека</a><br>
				
			</td>
			<td class="delete" rowspan="2"></td>
		</tr>
		<tr>
			<td colspan="2">
			ID: <{$order->order_id}><br>
			Текущее состояние: <{$order->status_name}><br>
            Адрес: <{$order->order_address}><br>
			Телефон: <{$order->order_phone}><br>
			Способ оплаты: <{$order->payment_name}>
			</td>
		</tr>
	</tbody>
</table>
<br>