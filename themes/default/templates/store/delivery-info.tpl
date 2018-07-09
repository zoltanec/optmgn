<div class="bl-wrapper-order--content">
    <div class="bl-fix-height--wrapper">
        <table class="delivery">
            <tbody>
                <tr>
                    <th class="tl pl30" width="220">Оплата</th>
                    <th class="tl">Служба доставки</th>
                    <th class="tl">Место получения</th>
                    <th class="col-170">Сроки</th>
                    <th class="col-100">Стоимость</th>
                </tr>
                <tr class="item">
                    <td data-title="Оплата" class="del-pay pl fl">100% оплата</td>
                    <td data-title="Служба доставки" class="del-service fl">Почта РФ</td>
                    <td data-title="Место получения" class="del-place fl">Почтовое отделение</td>
                    <td data-title="Сроки" class="del-time">3-7 дней</td>
                    <td data-title="Стоимость" class="del-price"><{if $freeDelivery}>0 руб.<{else}>*<{/if}></td>
                </tr>
                <tr class="item">
                    <td data-title="Оплата" class="del-pay pl fl">100% оплата</td>
                    <td data-title="Служба доставки" class="del-service fl">СДЭК</td>
                    <td data-title="Место получения" class="del-place fl">Склад отделения</td>
                    <td data-title="Сроки" class="del-time">2 дня</td>
                    <td data-title="Стоимость" class="del-price"><{if $freeDelivery}>0 руб.<{else}>*<{/if}></td>
                </tr>
                <tr class="item">
                    <td data-title="Оплата" class="del-pay pl fl">Оплата при получении</td>
                    <td data-title="Служба доставки" class="del-service fl">Почта РФ</td>
                    <td data-title="Место получения" class="del-place fl">Почтовое отделение</td>
                    <td data-title="Сроки" class="del-time">3-7 дней</td>
                    <td data-title="Стоимость" class="del-price"><{$postPrice}> руб.**</td>
                </tr>
                <tr class="item">
                    <td data-title="Оплата" class="del-pay pl fl">Оплата при получении</td>
                    <td data-title="Служба доставки" class="del-service fl">СДЭК</td>
                    <td data-title="Место получения" class="del-place fl">Склад отделения</td>
                    <td data-title="Сроки" class="del-time">2-6 дней</td>
                    <td data-title="Стоимость" class="del-price"><{$sdekPrice}> руб.**</td>
                </tr>
            </tbody>
        </table>
        <div class="bl-bottom-note--wrapper" style="text-align: left;padding-left: 30px;">
            <{if !$freeDelivery}>
            <p>*В данном регионе бесплатная доставка не действует</p>
            <{/if}>
            <p>**Стоимость доставки "Склад-Склад" рассчитана на вес посылки до 4 кг</p>
        </div>
        <div class="bl-delivery-alert"></div>
    </div>
</div>