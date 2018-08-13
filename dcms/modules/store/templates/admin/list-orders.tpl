<audio  controls="controls" style="visibility: hidden;" id="alert">
	<source src="<{$theme.images}>/alert.ogg" type="audio/ogg" />
</audio>


<h2>Заказами</h2>


<div class="orders_list">
	<ul class="store_order_statuses_list">
	<{foreach item=status_name key=status_code from=Store_Cart::getStatuses()}>
		<li data-type="tabhead" data-tab-name="status_<{$status_code}>"><{$status_name}> <span class="store_orders_count"></span></li>
	<{/foreach}>
</ul>

<{foreach item=status_name key=status_code from=Store_Cart::getStatuses()}>
	<div class="store_orders_list store_orders_list_<{$status_code}>" data-type="tabbody" data-tab-name="status_<{$status_code}>">
		<h2><{$status_name}></h2>
		<{assign var=total_summ value=0}>

		<div class="store_orders_container">
		<{foreach item=order from=Store_Cart::getLastOrders($status_code)}>
			<{include order=$order file='admin/single-order'}>
		<{/foreach}>
		</div>
	</div>
<{/foreach}>

<script type="text/javascript">
$('.orders_list').htabs({'default' : 'status_0', 'onselect': function(tabname,tabhead) {
	tabhead.find('SPAN').html('');
}});
</script>