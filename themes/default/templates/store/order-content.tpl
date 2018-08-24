<input type="hidden" id="basket__page">
<tr class="cart-item cart-table__tr cart-table_custom_line"
    data-prod-id="<{$prod->prod_id}>"
	data-current-price="<{$prod->getCurrentPrice()}>"
	data-current-box-price="<{$prod->getBoxQt() * $prod->getCurrentPrice()}>"
    data-hash="<{$hash}>">
    <td class="cart-table__td cart-table-img">
        <a class="cart-table-img__link" href="<{$me.www}>/store/show-product/product_<{$prod->prod_id}>">
            <img class="cart-table-img__img" src="http://sportlandshop.ru/content/media/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" alt="<{$prod->prod_name}>">
        </a>
    </td>
    <td class="cart-table__td cart-table-name">
        <a class="cart-table-name__link" href="<{$me.www}>/store/show-product/product_<{$prod->prod_id}>">
			<{$prod->prod_name}>
		</a>
        <div class="cart-table-props">
            <dl class="cart-table-props__dl">
                <dt class="cart-table-props__dt">Бренд:</dt>
                <dd class="cart-table-props__dd"><{$prod->fields['brand']->content}></dd>
            </dl>
            <dl class="cart-table-props__dl">
                <dt class="cart-table-props__dt">Количество штук в коробке:</dt>
                <dd class="cart-table-props__dd"><{$prod->getBoxQt()}></dd>
            </dl>
            <dl class="cart-table-props__dl">
                <dt class="cart-table-props__dt">Размер закупки:</dt>
                <dd class="cart-table-props__dd">Коробка</dd>
            </dl>
            <dl class="cart-table-props__dl">
                <dt class="cart-table-props__dt">Размеры:</dt>
                <dd class="cart-table-props__dd">
                    <{foreach item=cols key=size from=unserialize($prod->fields['wholesale-size']->content)}>
                        <{if $cols['checked'] && $cols['value']}>
                            <{$size}>,
                        <{/if}>
                    <{/foreach}>
                </dd>
            </dl>
            <div class="cart-table-term-of-shipment">Срок отгрузки: 4-8 рабочих дней после оплаты</div>
        </div>
    </td>

    <!-- за шт. -->
    <td class="cart-table__td cart-table-price">
        <div class="cart-table__title cart-table__title_inline">Цена за ед.:</div>
        <div class="cart-table-price__type price-type"><{$bulkDiscount.title}></div>
			<div class="current-price cart-table-price__cost price">
				<span class="price__value">
					<{$prod->getBulkDiscountPrice()}>
				</span> руб.
			</div>
			<{if $bulkDiscount.cff < 1}>
				<div class="old-price cart-table-price__cost cart-table-price__cost_old price price_old price_old_basket">
					<span class="price__value"><{$prod->getCurrentPrice()}></span> руб.
				</div>
			<{/if}>
    </td>
    <!-- за кор./уп. -->
    <td class="cart-table__td cart-table-price">
        <div class="cart-table__title cart-table__title_inline">Цена за кор.:</div>
        <div class="cart-table-price__type price-type"><{$bulkDiscount.title}></div>
        
        <div class="box-price cart-table-price__cost price">
            <span class="price__value">
                <{$prod->getBoxQt() * $prod->getBulkDiscountPrice()}>
            </span> руб.
        </div>
		<{if $bulkDiscount.cff < 1}>
			<div class="box-price-old cart-table-price__cost cart-table-price__cost_old price price_old price_old_basket_box">
				<span class="price__value">
					<{$prod->getBoxQt() * $prod->getCurrentPrice()}>
				</span> руб.
			</div>
		<{/if}>
    </td>

    <td class="cart-table__td cart-table-put">
        <div class="cart-table__title">Количество:</div>
        <div class="put">
            <div class="product-item-info-container product-item-hidden" data-entity="quantity-block">
                <div class="put__counter cart-table-put__counter">
                    <a class="minus put__arrow put__arrow_minus product-item-amount-field-btn-disabled put__arrow_basket put-arrow-basket-minus"">-</a>
                    <input type="tel" class="text put__input" name="quantity" size="2" maxlength="18" min="0" step="1" value="<{$data.quantity}>">
                    <a class="plus put__arrow put__arrow_plus product-item-amount-field-btn-disabled put__arrow_basket put-arrow-basket-plus">+</a>
                </div>
                <div class="error">Данного количества нет на складе</div>
                <div class="cart-table-put__form">кор.</div>
            </div>
        </div>
    </td>

    <td class="cart-table__td cart-table-total">
        <div class="cart-table__title cart-table__title_inline">Сумма:</div>
		<div class="product-sum price">
			<span class="price__value multiply-price" 
				data-status=" price-without-sale" 
				data-price="<{$prod->getBoxQt() * $prod->getBulkDiscountPrice()}>">
					<{$data.quantity * $prod->getBoxQt() * $prod->getBulkDiscountPrice()}>
			</span> руб.
		</div>
		<{if $bulkDiscount.cff < 1}>
			<div class="product-sum-old cart-table-price__cost cart-table-price__cost_old price price_old">
				<span class="price__value multiply-price"
					data-status="price-without-sale"
					data-price="<{$prod->getBoxQt() * $prod->getCurrentPrice()}>">
						<{$data.quantity * $prod->getBoxQt() * $prod->getCurrentPrice()}>
				</span> руб.
			</div>
			<div class="prod-economy cart-table-price__info info-label info-label_info">
				Экономия <span><{$data.quantity * $prod->getBoxQt() * ($prod->getCurrentPrice() - $prod->getBulkDiscountPrice())}><span> руб.
			</div>
		<{/if}>
    </td>
    <td class="cart-table__td cart-table__td--actions">
        <a class="remove cart-table__close icon icon-cross" href="#remove" title="Удалить">
            <i></i>
        </a>
    </td>
</tr>