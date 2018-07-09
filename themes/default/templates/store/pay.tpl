<div class="bl-fix-height--wrapper">
    <table class="pay">
        <tbody>
            <tr>
                <th class="tl pl30">Способ оплаты</th>
                <th class="tl col-700"></th>
                <th class="col-150">Выбрать</th>
            </tr>
            <{*tr class="item active" onclick="return Order.checkPay(1, this)">
                <td data-title="Способ оплаты" class="pay-method pl fl">Robokassa</td>
                <td data-title="Описание" class="pay-desc">банковская карта, электронные кошельки (QIWI, Web Money, Элекснет), наличными в салонах связи, со счета мобильного телефона (МТС, Tele2)</td>
                <td data-title="Выбрать" class="pay-choise"><span class="circle active"></span></td>
            </tr*}>
            <tr class="item " onclick="return Order.checkPay(7, this)">
                <td data-title="Способ оплаты" class="pay-method pl fl">WalletOne</td>
                <td data-title="Описание" class="pay-desc">банковские карты Visa, Mastercard, МИР</td>
                <td data-title="Выбрать" class="pay-choise"><span class="circle <{if $payInfo.id == 7}>active<{/if}>"></span></td>
            </tr>
        </tbody>
    </table>
    <div class="bl-pay-alert"></div>
    <div class="bl-detail-bottom">
        <div class="bl-detail-order-wrapper clearfix">
            <div class="bl-orient--right">
                <div class="head-text">Мой заказ</div>
                <div class="order-info">
                    <div class="line ">
                        <span class="label">Итого стоимость товаров:</span>
                        <span class="value"><{$cart_total.total_cost}> руб.</span>
                    </div>
                    <div class="line ">
                        <span class="label">Доставка:</span>
                        <span class="value"><{$deliveryInfo.cost}> руб.</span>
                    </div>
                    <{if $prepay}>
                        <div class="line strong">
                            <span class="label">Предоплата:</span>
                            <span class="value">1000 руб.</span>
                        </div>
                        <div class="line strong">
                            <span class="label">Доплата при получении:</span>
                            <span class="value"><{$totalCost - 1000}> руб.</span>
                        </div>
                    <{else}>
                        <div class="line strong">
                            <span class="label">Итого к оплате:</span>
                            <span class="value"><{$totalCost}> руб.</span>
                        </div>
                    <{/if}>
                </div>
            </div>
        </div>
        <div class="bl-nav-bnt--wrapper clearfix">
            <div class="left-btn">
                <a href="#" onclick="return Order.step(2)">Назад</a>
            </div>
            <div class="right-btn">
                <a href="#" onclick="return Order.submit()">Оплатить</a>
            </div>
        </div>
    </div>
</div>
<div class="bl-bottom-note--wrapper">
    <p>*Нажав на кнопку "Оплатить", Вы будете перенаправлены на страницу оплаты</p>
</div>