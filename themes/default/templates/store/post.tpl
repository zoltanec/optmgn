<div class="bl-fix-height--wrapper h280">
    <div class="bl-pay-imposed-wrapper">
        <div class="first-block">
            <p>Оплатить заказ Вы сможете при получении в почтовом отделении.</p>
            <p>При получении посылки дополнительно оплачивается почтовый сбор, согласно тарифам почты России.</p>
        </div>
        <div class="code-block">
            <p>Для оформления заказа, пожалуйста, подтвердите Ваш номер телефона <span class="phone-number "><{D::$session['formData']['order_phone']}></span></p>
            <{*div class="approve_phone">
                <a href="#" class="send_code" onclick="return Order.getSmsCode()">Получить код</a>
                <div class="el-after-code"></div>
            </div*}>
        </div>
    </div>
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
                    <div class="line strong">
                        <span class="label">Итого к оплате:</span>
                        <span class="value"><{$totalCost}> руб.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bl-nav-bnt--wrapper clearfix">
            <div class="left-btn">
                <a href="#" onclick="return Order.step(2)">Назад</a>
            </div>
            <div class="right-btn">
                <a href="#" onclick="return Order.submit()">Оформить</a>
            </div>
        </div>
    </div>
</div>
