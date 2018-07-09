<div class="bl-fix-height--wrapper">
    <table class="delivery">
        <tbody>
            <tr>
                <th class="tl pl30" width="220">Оплата</th>
                <th class="tl">Служба доставки</th>
                <th class="tl">Место получения</th>
                <th class="col-170">Сроки</th>
                <th class="col-100">Стоимость</th>
                <th class="col-150">Выбрать</th>
            </tr>
            <tr class="item " onclick="return Order.checkDelivery(5, 0, this)">
                <td data-title="Оплата" class="del-pay pl fl">100% оплата</td>
                <td data-title="Служба доставки" class="del-service fl">Почта РФ</td>
                <td data-title="Место получения" class="del-place fl">Почтовое отделение</td>
                <td data-title="Сроки" class="del-time">3 - 7 дней</td>
                <td data-title="Стоимость" class="del-price"><{if $freeDelivery}>0 руб.<{else}>*<{/if}></td>
                <td data-title="Выбрать" class="del-choise"><span class="circle <{if $deliveryInfo.id == 5}>active<{/if}>"></span></td>
            </tr>
            <tr class="item " onclick="return Order.checkDelivery(6, 0, this)">
                <td data-title="Оплата" class="del-pay pl fl">100% оплата</td>
                <td data-title="Служба доставки" class="del-service fl">СДЭК</td>
                <td data-title="Место получения" class="del-place fl">Курьером до двери</td>
                <td data-title="Сроки" class="del-time">2 дня</td>
                <td data-title="Стоимость" class="del-price"><{if $freeDelivery}>0 руб.<{else}>*<{/if}></td>
                <td data-title="Выбрать" class="del-choise"><span class="circle <{if $deliveryInfo.id == 6}>active<{/if}>"></span></td>
            </tr>
            <tr class="item <{if $prepay}>disable<{else}>" onclick="return Order.checkDelivery(8, <{$postPrice}>, this)<{/if}>">
                <td data-title="Оплата" class="del-pay pl fl">Оплата при получении</td>
                <td data-title="Служба доставки" class="del-service fl">Почта РФ</td>
                <td data-title="Место получения" class="del-place fl">Почтовое отделение</td>
                <td data-title="Сроки" class="del-time">3 - 7 дней</td>
                <td data-title="Стоимость" class="del-price"><{$postPrice}> руб.</td>
                <td data-title="Выбрать" class="del-choise"><{if !$prepay}><span class="circle <{if $deliveryInfo.id == 8}>active<{/if}>"></span><{/if}></td>
                <{if $prepay}>
                <td colspan="6" class="alert-hidden">
                    Данный вид доставки доступен при сумме заказа менее 6000 рублей.
                </td>
                <{/if}>
            </tr>
            <tr class="item <{if $prepay}>disable<{else}>" onclick="return Order.checkDelivery(9, <{$sdekPrice}>, this)<{/if}>">
                <td data-title="Оплата" class="del-pay pl fl">Оплата при получении</td>
                <td data-title="Служба доставки" class="del-service fl">СДЭК</td>
                <td data-title="Место получения" class="del-place fl">Склад отделения</td>
                <td data-title="Сроки" class="del-time">2-6 дней</td>
                <td data-title="Стоимость" class="del-price"><{$sdekPrice}> руб.</td>
                <td data-title="Выбрать" class="del-choise"><{if !$prepay}><span class="circle <{if $deliveryInfo.id == 9}>active<{/if}>"></span><{/if}></td>
                <{if $prepay}>
                <td colspan="6" class="alert-hidden">
                    Данный вид доставки доступен при сумме заказа менее 6000 рублей.
                </td>
                <{/if}>
            </tr>
            <{if $prepay}>
                <tr class="item active" onclick="return Order.checkDelivery(7, 490, this)">
                    <td data-title="Оплата" class="del-pay pl fl">Предоплата 1000 руб</td>
                    <td data-title="Служба доставки" class="del-service fl">Почта РФ</td>
                    <td data-title="Место получения" class="del-place fl">Почтовое отделение</td>
                    <td data-title="Сроки" class="del-time">3 - 7 дней</td>
                    <td data-title="Стоимость" class="del-price">490 руб.</td>
                    <td data-title="Выбрать" class="del-choise"><span class="circle <{if $deliveryInfo.id == 7}>active<{/if}>"></span></td>
                </tr>
            <{/if}>
        </tbody>
    </table>
    <div class="bl-delivery-alert"></div>
    <div class="bl-bottom-note--wrapper" style="text-align: left;padding-left: 30px;">
        <{if !$freeDelivery}>
        <p>*В данном регионе бесплатная доставка не действует</p>
        <{/if}>
        <p>**Стоимость доставки "Склад-Склад" рассчитана на вес посылки до 4 кг</p>
    </div>
    <div class="bl-detail-bottom">
        <div class="bl-detail-order-wrapper clearfix">
            <div class="bl-orient--right mr-68">
                <div class="head-text">Мой заказ</div>
                <div class="order-info">
                    <div class="line ">
                        <span class="label">Стоимость товаров:</span>
                        <span class="value"><{$cart_total.total_cost}> руб.</span>
                    </div>		
                    <div class="line ">
                        <span class="label">Доставка:</span>
                        <span id="delivery-cost" class="value"><{$deliveryInfo.cost}> руб.</span>
                    </div>
                    <div class="prepay" <{if D::$session['delivery']['id'] != 7}>style="display:none"<{/if}>>
                        <div class="prepay line strong">
                            <span class="label">Предоплата:</span>
                            <span class="value">1000 руб.</span>
                        </div>
                        <div class="prepay line strong">
                            <span class="label">Доплата при получении:</span>
                            <span class="value"><{$totalCost - 1000}> руб.</span>
                        </div>
                    </div>
                    <div <{if D::$session['delivery']['id'] == 7}>style="display:none"<{/if}> class="online-pay line strong">
                        <span class="label">Итого к оплате:</span>
                        <span id="total-cost" data-val="<{$totalCost}>" class="value"><{$totalCost}> руб.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bl-nav-bnt--wrapper clearfix">
            <div class="left-btn">
                <a href="#" onclick="return Order.step(1)">Назад</a>
            </div>
            <div class="right-btn">
                <a href="#" onclick="return Order.step(3)">Далее</a>
            </div>
        </div>
    </div>
</div>