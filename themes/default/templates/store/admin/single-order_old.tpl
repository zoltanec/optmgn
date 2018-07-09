<table class="cms_list store_single_order order_status_<{$order->status}> order_payment_<{$order->payment}>" data-list-funcs="delete" data-status="<{$order->status}>" data-upd-time="<{$order->upd_time}>" data-order-id="<{$order->order_id}>">
	<thead>
		<tr>
			<th><b>�</b></th>
			<th><b>�����</b></th>
			<th><b>���</b></th>
			<th><b>�����</b></th>
			<th><b>�������</b></th>
			<td colspan="2"><b>#FUNCTIONS#</b></td>
		</tr>
	</thead>
	<tbody data-type="element" data-object-id="<{$order->object_id()}>">
		<tr>
			<td class="nid"><{$order->order_id}></td>
			<td class="nid"><{$order->add_time|convert_time}></td>
			<td class="order_name"><{$order->order_name}></td>
			<td class="order_adress"><{$order->order_address}></td>
			<td rowspan="2" class="order">

				<div class="packet_content">

				<{assign var=pack_summ value=0}>
				<{foreach item=pack name=pack from=$order->getOrderPacks()}>

				<b>����� <{$smarty.foreach.pack.iteration}></b>
					<table class="store_order_packet">
					<{foreach item=product from=$pack}>
						<{assign var=prod value=D_Core_Factory::Store_Product($product->prod_id)}>
						<{$pack_summ=$pack_summ+$prod->current_price*$product->quantity}>
						<tr>
							<td class="packet_item_image"><img style="width: 40px;" src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" onerror="this.style.display = 'none'" /></td>
							<td class="packet_item_name"><b><{$prod->prod_name}></b><br /><{if $prod->weight}><span><{$prod->weight}>��.</span><{/if}>
								<{if !empty($product->descr)}>
									<div class="packet_item_descr"><{$product->descr}></div>
								<{/if}>

							</td>
							<td class="packet_item_line"></td>
							<td class="packet_item_price">
								<div class="product_show_input">
									<div class="packet_price"><{if $prod->current_price}><span><{if $order->delivery == 0 and $config['store.delivery.self_discount'] > 0}><{floor($prod->current_price*(1-0.01*$config['store.delivery.self_discount']))}><{else}><{$prod->current_price}><{/if}></span> ���.&nbsp;<{/if}><br>
								</div>
								</div>
							</td>
							<tD>x <{$product->quantity}> ��.</tD>
							<td><{if $prod->current_price}>= <{*if $order->delivery == 0 and $config['store.delivery.self_discount'] > 0}><{$product->quantity * floor($prod->current_price*(1-0.01*$config['store.delivery.self_discount']))}><{else*}><{$product->quantity * $prod->current_price}><{*/if*}> ���.<{/if}></td>
						</tr>
					<{/foreach}>
				</table>
			<{/foreach}>

			<b><span class="big">�����: </span>
			<{if !$order->delivery || $order->discount}>
				<{floor($order->sum-$order->sum*$order->discount*0.01)}> ���.
			<{else}>
				<{$order->sum}> ���.
			<{/if}>
			<br />
			<{if $order->delivery}>
				��������� ��������: <{$order->delivery_payment}> ���.
			<{/if}>	
			<{if $order->delivery == 0 and $config['store.delivery.self_discount'] > 0}>
				(<{$config['store.delivery.self_discount']+$order->discount}> % ������)
			<{elseif $order->discount}>
				(<{$order->discount}> % ������)
			<{/if}>

			</b><br>
			<{if !empty($order->description)}>
				<b>����������:</b><br>
				<{$order->description}>
			<{/if}>
			</td>
			<td rowspan="2" class="order_change_status">
				<{foreach item=status key=status_key from=Store_Cart::getStatuses()}>
					<a class="order_set_<{$status_key}>" href="<{$run.me}>/update-order/ordid_<{$order->order_id}>/mode_status/status_<{$status_key}>/"><{$status}></a><br />
				<{/foreach}>
				<a href="<{$run.me}>/edit-order/<{$order->order_id}>">�������������</a><br>
				<a href="<{$run.me}>/print-check/<{$order->order_id}>" target="_blank">������ ����</a><br>
				
			</td>
			<td class="delete" rowspan="2"></td>
		</tr>
		<tr>
			<td colspan="4">
			ID: <{$order->order_id}><br>
			������� ���������: <{$order->status_name}><br>
			���: <{$order->code}><br>
			�������: <{$order->order_phone}><br>
			������ ������: <{$order->payment_name}>
			</td>
		</tr>
	</tbody>
</table>
<br>