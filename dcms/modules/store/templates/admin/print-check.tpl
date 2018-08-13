<html>
<head>
<link href="<{$theme.css}>/core.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://yandex.st/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="<{$config->jscripts_path}>/d.js"></script>
<script type="text/javascript">
	var D = new D({www: '<{$me.www}>', context: 'admin'});
</script>
</head>
<body>
<script type="text/javascript">
	$(document).ready(function(){
		window.print();
	});
</script>
<div id="print_content">
<div style="overflow:hidden">
 <div class="left">
	<table class="print_wrap">
		<tr>
			<td>Заказ № <{$order->order_id}></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="pw_title">Время добавления &nbsp;&nbsp;</td>
			<td><{$order->add_time|date_format:"%d.%m.%Y %H:%M"}></td>
		</tr>
		<tr>
			<td class="pw_title">Телефон </td>
			<td><{$order->order_phone}></td>
		</tr>
        <tr>
			<td class="pw_title">Адрес </td>
			<td><{$order->order_address}></td>
		</tr>
	</table>
 </div>
 <div class="right">
	<table class="print_wrap">
		<tr>
			<td>Летучая рыба, ИП Стафеева Е.В.
				<br />пр. Карла Маркса 172
				<br />инн 744604747171</td>
		</tr>
		<tr>
			<td>www.sushimgn.ru</td>
		</tr>
		<tr>
			<td>Телефон: 8(3519) 29-90-10, 29-90-30</td>
		</tr>
        <tr>
			<td>Время работы: с 10:00 до 22:00</td>
		</tr>
	</table>
 </div>
	 </div>
<div id="pw_h2">Заказ</div>
<{foreach item=pack name=pack from=$order->getOrderPacks()}>
	<{*h3>Группа товаров <{$smarty.foreach.pack.iteration}></h3*}>
	<table class="check-table">
		<{foreach item=product from=$pack}>
			<tbody>
			<{assign var=prod value=D_Core_Factory::Store_Product($product->prod_id)}>
			<{$pack_summ=$pack_summ+$prod->price*$product->quantity}>
			<tr>
				<td class="packet_item_name"><{$prod->prod_name}></td>
				<td class="packet_item_line center"><{$product->quantity}> шт.</td>
				<td class="packet_item_price"><{if $prod->price}><{$product->quantity * $prod->current_price}> руб.<{/if}></td>
			</tr>
			</tbody>
		<{/foreach}>
	</table>
<{/foreach}>
<div class="print_total"><span class="big">Итого: </span>
	<{if !$order->delivery || $order->discount}>
			<{floor($order->sum-$order->sum*$order->discount*0.01)}> руб.
			<{else}>
				<{$order->sum}> руб.
			<{/if}>
			<{if $order->delivery == 0 && $config['store.delivery.self_discount'] > 0}>
				(<{$config['store.delivery.self_discount']+$order->discount}> % скидка)
			<{elseif $order->discount}>
				(<{$order->discount}> % скидка)
			<{/if}>
	<br />
	<{if $order->delivery}>
	Стоимость доставки: <{$order->delivery_payment}> руб.
	<{/if}>
</div>
<div>
<{$order->description}>
</div>
</div>
</body>
</html>