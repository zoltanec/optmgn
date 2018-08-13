<{assign var=total value=Store_Cart::getCartSum()}>
<div id="cart">
<{if $total.total_cost!=0}>
	<a class="show-order" href="<{$me.www}>/store/order"><{$total.total_quantity}> порции</a> 
	/<span><b><{$total.total_cost}></b></span>
	<img src="<{$theme.images}>/rub_mini.png">
<{else}>
<div style="padding-top:2px">
	Корзина пуста
</div>
<{/if}>
</div>
<{if Store_Cart::getPack()}>
<div id="pack">
	<{Store_Cart::getPack()}> Порция
</div>
<{/if}>
