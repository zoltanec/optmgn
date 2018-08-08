<div class="container">
	<div class="row ">
		<div class="col-item">
			<h1 class="title-h1">Корзина</h1>
		</div>
	</div>
</div>
<div class="container l-cart">
	<{if $cart}>
    <div id="basket-replace">
			<div class="row">
				<div class="col-item">
					<div class="tabs-cart l-cart__tabs">
						<div class="tabs-cart__list l-cart__tabs-list basket_sort">
							<div class="tabs-cart__item  wrap_li active" item-section="AnDelCanBuy" data-hash="tab_AnDelCanBuy" data-type="AnDelCanBuy">
								<a class="tabs-cart__link" href="">
									Готовые к заказу (<span id="basket_ready_product-cnt">5</span>)
								</a>
							</div>
							<div class="tabs-cart__item  wrap_li tabs-cart__item-delay hidden ">
								<a class="tabs-cart__link" href="/basket/delayed/"> 
									Избранные (<span id="basket_delay_product-cnt">0</span>)
								</a>
							</div>
							<div class="remove_all_basket tabs-cart__close btn btn_size_xs icon icon-cross button grey_br transparent AnDelCanBuy cur">
									Очистить
							</div>
						</div>
                        
                        <div class="system-message notetext info-block info-block_info">
                            <div class="text">
                                <p class="info-block__string">
                                    <b class="text text--bold">Тип Вашей цены - <span class="price-type"><{$config['store.discounts']['20 000']['title']}></span>.</b></p>
                                <p class="info-block__string">Общая сумма в Вашей корзине: <span class="text text--orange"><{$cart_total.total_cost}> руб.</span></p>
                            </div>
                        </div>
                        <div class="tabs-cart__content l-cart__tabs-content">
                            <div class="tabs-cart__panel active" id="AnDelCanBuy">
                                <span class="basket_product_type_delay hidden" data-val="N"></span>
                                <table class="cart-table">
                                    <tbody>
                                    <tr class="cart-table__tr">
                                        <th class="cart-table__th"></th>
                                        <th class="cart-table__th">Наименование</th>
                                        <th class="cart-table__th">Цена за единицу</th>
                                        <th class="cart-table__th">Цена за упаковку/короб</th>
                                        <th class="cart-table__th cart-table__th_center">Количество</th>
                                        <th class="cart-table__th">Сумма</th>
                                        <th class="cart-table__th"></th>
                                    </tr>
                                    <{foreach item=pack key=pack_id name=pack from=$cart}>
                                        <{assign var=pack_summ value=0}>
                                        <{foreach name=items item=data key=hash from=$pack}>
                                            <{if $data.visible}>
                                                <{assign var=prod_id value=$data.prod_id}>
                                                <{assign var=prod value=D_Core_Factory::Store_Product($prod_id)}>
                                                <{include file='store;order-content'}>
                                            <{/if}>
                                        <{/foreach}>
                                    <{/foreach}>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="system-message notetext info-block info-block_info">
                                <div class="text">В&nbsp;Вашей корзине находятся товары со&nbsp;стандартным сроком отгрузки. 
                                    Отгрузка Вашего заказа будет осуществлена через 4-7 рабочих дня после оплаты заказа.</div>
                            </div>        
                        </div>
					</div>
				</div>
			</div>
			<div class="row row_ver_sm l-cart__row-total">
				<!-- Сумма -->

				<div class="col-item order-total order-total_all">
					<table>
						<tbody>
                            <tr>
								<td class="order-total__td content"></td>
								<td class="order-total__td l-index__content info-td_economy">
									<strike><{$cart_total.total_cost}> руб.</strike>
								</td>
							</tr>
							<tr>
								<td class="order-total__td content">
									Скидка за объем:
								</td>
								<td class="order-total__td info-td_economy">
									19&nbsp;020.14 руб.
								</td>
							</tr>
							<tr>
								<td class="order-total__td content">
									<span class="info-label_economy info-label_economy_title">Экономия:</span>
								</td>
								<td class="order-total__td info-td_economy" colspan="2">
									<span class="info-label_economy info-label_economy_value">19&nbsp;020.14 руб.</span>
								</td>
							</tr>
														<tr>
							<td class="order-total__td content" rowspan="1">
								<div class="h6">Итого:</div>
							</td>
							<td class="order-total__td info-td_economy">
								<div class="price"><span class="price__value">462&nbsp;668.64</span> руб.
								</div>
							</td>
						</tr>
					</tbody></table>
				</div>
			</div>
						
			<!-- Продолжить покупки / Оформить заказ -->
			<div class="row">
				<div class="col-item">
					<div class="btn-line btn-line_right btn-line_border">
						<a class="btn btn_size_m" href="/catalog/">Продолжить покупки</a>
						<div class="btn btn_primary btn_size_m submitBasket" data-text="Начало оформления заказа">Оформить заказ</div>
					</div>
				</div>
			</div>
		</form>
	</div>
    <{else}>
        <div class="row">
            <div class="col-item">
                <div class="tabs-cart l-cart__tabs">
                    <div class="tabs-cart__list l-cart__tabs-list basket_sort">
                        <div class="tabs-cart__item  wrap_li active" item-section="AnDelCanBuy" data-hash="tab_AnDelCanBuy" data-type="AnDelCanBuy">
                            <a class="tabs-cart__link" href="#">
                                Готовые к заказу (<span id="basket_ready_product-cnt">0</span>)
                            </a>
                        </div>

                        <div class="tabs-cart__item  wrap_li tabs-cart__item-delay  ">
                            <a class="tabs-cart__link" href="#"> 
                                Избранные (<span id="basket_delay_product-cnt">0</span>)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-item content">
                <img class="pull-left margin_right_20 margin_bottom_10" src="/local/templates/main/images/empty_cart.png" alt="">
                <h3>К сожалению, ваша корзина пуста</h3>
                <p>Исправить это недоразумение очень просто:&nbsp;<a href="<{$me.www}>">выберите в магазине</a> интересующий товар и нажмите кнопку «В корзину».</p>
                <a class="btn btn_size_s btn_primary margin_top_20">Вернуться</a>
            </div>
        </div>
    <{/if}>
</div>
<{if $cart}>
	<div class="bl-trash--footer">
		<div class="btn_back">
			<a href="javascript: window.history.back();">Назад</a>
		</div>
		<div class="step_order_form">
			<div class="summ-trash">
				<span class="label">Стоимость товаров:</span>
				<span class="value_sum"> руб.</span>
			</div>
			<a href="<{$me.www}>/store/checkout">Оформить заказ</a>
		</div>
	</div>
<{/if}>

