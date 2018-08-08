<{assign var=total value=Store_Cart::getCartSum()}>
<div class="col-item header-basket">
	<a class="header-basket__frame" href="<{$me.www}>/store/order">
        <span class="header-basket__baloon"><b>Для вашего региона:</b> <br><b>Минимальный заказ</b> - 10 000 руб. <br>Бесплатная доставка от 50 000 руб.</span>
		<span class="header-basket__cart">
			<span class="header-basket__length"><{if $total.total_cost > 0}><{$total.total_quantity}><{/if}></span>
		</span>
		<span class="header-basket__info">
			<span class="header-basket__text">Корзина</span>
			<span class="header-basket__value"><{if $total.total_cost > 0}><{$total.total_cost}> руб.<{else}>пуста<{/if}></span>
		</span>
	</a>
</div>
