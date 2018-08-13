<form method="post" action="<{$run.me}>/update-order/">
<input type="hidden" name="ordid" value="<{$order->order_id}>">
<table class="cms_form">
	<tbody>
		<tr>
			<td></td>
			<td>Идентификатор заказа:</td>
			<td><{$order->order_id}></td>
		</tr>
	</tbody>

	<tbody>
		<tr><td></td>
			<td>Время добавления:</td>
			<td><{$order->add_time|convert_time}></td>
		</tr>
	</tbody>

	<{formline name='order_name' title='Имя' value=$order->order_name}>
	<{formline name='order_address' title='Адрес' value=$order->order_address}>
	<{formline name='order_phone' title='Телефон' value=$order->order_phone}>

	<tbody>
		<tr><td></td>
			<td>Оплата:</td>
			<td>
				<select name="payment">
					<{foreach item=pays key=pid from=Store_Cart::getPaymentModes()}>
						<option value="<{$pid}>"<{if $pid==$order->payment}> selected<{/if}>><{$pays}>
					<{/foreach}>
				</select>
			</td>
		</tr>
	</tbody>
	<{*tbody>
		<tr><td></td><td>Скидка 5%(самовывоз):</td><td><input name="nodelivery" type="checkbox" value="1" <{if !$order->delivery}>checked="checked"<{/if}> /></td></tr>
	</tbody>
	<tbody>
		<tr><td></td><td>Накопительная скидка 5%:</td><td><input name="discount" type="checkbox" value="5" <{if $order->discount}>checked="checked"<{/if}> /></td></tr>
	</tbody*}>
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
		<{assign var=delivery_amounts value=array(60,70,80,100,150,200)}>
		<tr>
			<td></td>
			<td>Стоимость доставки: <{$order->delivery_payment}></td>
			<td>
				<select name="delivery_payment">
					<option value="0">Выберите стоимость</option>
					<{foreach item=amount from=$delivery_amounts}>
						<option value="<{$amount}>" <{if $amount==$order->delivery_payment}>selected="selected"<{/if}>><{$amount}></option>
					<{/foreach}>
				</select> руб.</td>
		</tr>
	</tbody>
	<tbody>
		<tr><td></td>
			<td>Примечание:</td>
			<td><textarea name="description" rows="3" cols="40"><{$order->description}></textarea></td>
		</tr>
	</tbody>
	<{formline type='save'}>
</table>
</form>

<h2>Товары в заказе</h2>

Добавить товар
<form method="post" action="<{$run.me}>/add-product-order/">
<{foreach item=category from=Store_Category::getCategoriesByPid()}>
	<a class="pcategory" href="<{$run.me}>/get-categories/<{$category->category_id}>"><{$category->category_name}></a> |
<{/foreach}>
<br /><br />
<input type="hidden" name="ordid" value="<{$order->order_id}>">
<select name="product" size="40">
	<{foreach item=category from=Store_Category::getChildCategories(1, 0, true)}>
		<optgroup label="<{if $category->offset}>&nbsp;&nbsp;&nbsp;&nbsp;|-<{/if}><{$category->category_name}>">
		<{foreach item=product from=Store_Product::getProductsByCategoryy($category->category_id)}>
			<option value="<{$product->prod_id}>">|-<{$product->prod_name}></option>
		<{/foreach}>
		</optgroup>
	<{/foreach}>
</select><br /><br />
<input type="text" name="quantity" value="1" size="5" />
<input type="submit" value="Добавить" />
</form>
<{foreach item=pack name=pack from=$order->getOrderPacks()}>
	<h3>Группа товаров <{$smarty.foreach.pack.iteration}></h3>

	<table class="cms_list" data-list-funcs="delete fields">
		<thead>
			<tr>
				<th>Фото</th>
				<th>Название</th>
				<th>Цена</th>
				<th>Количество</th>
				<th colspan="2">#FUNCTIONS#</th>
			</tr>
		</thead>
		<{foreach item=product from=$pack}>
			<tbody data-type="element" data-object-id="<{$product->object_id()}>">
			<{assign var=prod value=D_Core_Factory::Store_Product($product->prod_id)}>
			<{$pack_summ=$pack_summ+$prod->current_price*$product->quantity}>
			<tr>
				<td class="center"><img width="60" src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" onerror="this.style.display = 'none'" /></td>
				<td class="packet_item_name"><a href="<{$run.me}>/edit-product/pid_<{$prod->prod_id}>/"><{$prod->prod_name}></a><br /><{if $prod->weight}><span><{$prod->weight}>гр.</span><{/if}></td>
				<td class="packet_item_price center"><{if $prod->price}><{$prod->current_price}><{/if}></td>
				<td data-field="quantity" class="center priority">
    				<a class="up" title="Повысить" data-field-func="inc"></a>
					<b data-field-func="value"><{$product->quantity}></b>
					<a class="down" title="Понизить" data-field-func="dec"></a>
   				</td>
				<td class="delete"></td>
				<td></td>
				</tr>
			</tbody>
		<{/foreach}>
	</table>
<{/foreach}>
<script type="text/javascript">
	$(document).ready(function(){
		$('a.pcategory').click(function(){
			$.post($(this).attr('href'),function(answer){
				$('select[name=product]').html(answer);
			});
			return false;
		});
	});
</script>