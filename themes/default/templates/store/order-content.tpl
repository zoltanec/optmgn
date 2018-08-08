<tr class="cart-table__tr cart-table_custom_line" 
    data-prod-id="<{$prod->prod_id}>"
    data-hash="<{$hash}>">
    <td class="cart-table__td cart-table-img">
        <a class="cart-table-img__link" href="">
            <img class="cart-table-img__img" src=".jpg" alt="<{$prod->prod_name}>">
        </a>
    </td>
    <td class="cart-table__td cart-table-name">
        <a class="cart-table-name__link" href=""><{$prod->prod_name}></a>
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
        <div class="cart-table-price__type"><{$config['store.discounts']['20 000']['title']}></div>
        <div class="cart-table-price__cost price">
            <span class="price__value">
            <{if $prod->fields['wholesale-discount-price']->content}>
                <{$prod->fields['wholesale-discount-price']->content}>
            <{else}>
                <{$prod->fields['wholesale-price']->content}>
            <{/if}></span> руб.</div>
        <div class="cart-table-price__cost cart-table-price__cost_old price price_old">
            <span class="price__value"></span> руб.
        </div>
    </td>
    if prod->getQuantityDiscount() 
    <!-- за кор./уп. -->
    <td class="cart-table__td cart-table-price">
        <div class="cart-table__title cart-table__title_inline">Цена за кор.:</div>
        <div class="cart-table-price__type"><{$config['store.discounts']['20 000']['title']}></div>
        
        <div class="cart-table-price__cost price">
            <span class="price__value">
                <{if $prod->fields['wholesale-discount-price']->content}>
                    <{$prod->getBoxQt() * $prod->fields['wholesale-discount-price']->content}>
                <{else}>
                    <{$prod->getBoxQt() * $prod->fields['wholesale-price']->content}>
                <{/if}>
            </span> руб.
        </div>
        
        <input type="hidden" name="item_price" value="7977.2">
        <input type="hidden" name="item_summ" value="39886">
    </td>

    <td class="cart-table__td cart-table-put">
        <div class="cart-table__title">Количество:</div>
        <div class="put">
            <div class="product-item-info-container product-item-hidden" data-entity="quantity-block">
                <div class="put__counter cart-table-put__counter">
                    <span class="minus put__arrow put__arrow_minus product-item-amount-field-btn-disabled">-</span>                    
                    <input type="tel" class="text put__input" name="quantity" size="2" maxlength="18" min="0" step="1" value="<{$data.quantity}>">
                    <span class="plus put__arrow put__arrow_plus product-item-amount-field-btn-disabled">+</span>
                </div>
                <div class="error">Данного количества нет на складе</div>
                <div class="cart-table-put__form">кор.</div>
            </div>
        </div>
    </td>

    <td class="cart-table__td cart-table-total">
        <div class="cart-table__title cart-table__title_inline">Сумма:</div>
        <div class="cart-table-price__type">&nbsp;</div>
            <{if $prod->fields['wholesale-discount-price']->content}>
                <div class="cart-table-total__cost price">
                    <span class="price__value">
                        <{$prod->getBoxQt() * $prod->fields['wholesale-discount-price']->content}>
                    </span> руб.
                </div>
                <div class="cart-table-price__cost cart-table-price__cost_old price price_old">
                    <span class="price__value"><{$prod->getBoxQt() * $prod->fields['wholesale-price']->content}></span> руб.
                </div>
            <{else}>
                <div class="cart-table-total__cost price">
                    <span class="price__value">
                        <{$prod->getBoxQt() * $prod->fields['wholesale-price']->content}>
                    </span> руб.
                </div>
            <{/if}>
        <div class="cart-table-price__info info-label info-label_info">
            Экономия 1&nbsp;450.40 руб.
        </div>

        <input type="hidden" name="price_discount" value="">
    </td>
    <td class="cart-table__td cart-table__td--actions">
        <div class="goods-frame__share goods-share">
            <div class="goods-share__item goods-share__item_delay" title="В избранное" data-id=""></div>
        </div>
        <a class="remove cart-table__close icon icon-cross" href="#remove" title="Удалить">
            <i></i>
        </a>
    </td>
</tr>