<form method="post" action="<{$run.me}>/submit-order/">
<table class="cms_form">
	<{formline name='order_name' title='Имя' value=''}>
	<{formline name='order_address' title='Адрес' value=''}>
	<{formline name='order_phone' title='Телефон' value=''}>
	<tbody>
		<tr><td></td>
			<td>Оплата:</td>
			<td>
				<select name="payment">
					<{foreach item=pays key=pid from=Store_Cart::getPaymentModes()}>
						<option value="<{$pid}>"><{$pays}>
					<{/foreach}>
				</select>
			</td>
		</tr>
	</tbody>
	<{*tbody>
		<tr>
			<td>Доставка:</td>
			<td><select name="delivery">
				<option value="0">САМОВЫВОЗ
				<{foreach item=delivery from=Store_Cart::getDeliveryModes()}>
					<option value="<{$delivery->prod_id}>"<{if $delivery->prod_id==$order->delivery}> selected<{/if}>><{$delivery->prod_name}>
				<{/foreach}>
			</select>
			</td>
		</tr>
	</tbody*}>
	<tbody>
		<tr><td></td>
			<td>Примечание:</td>
			<td><textarea name="description" rows="3" cols="40"></textarea></td>
		</tr>
	</tbody>
	<{formline type='save'}>
</table>
</form>

