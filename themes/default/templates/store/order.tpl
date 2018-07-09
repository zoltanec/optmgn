<div id="content" class="clearfix w100p pz">
    <link href="<{$theme.css}>/catalog/trash.css" rel="stylesheet" type="text/css"/>
    <link href="<{$theme.css}>/catalog/order.css" rel="stylesheet" type="text/css"/>
    <link href="<{$theme.css}>/catalog/catalog.css" rel="stylesheet" type="text/css"/>
    <link href="<{$config->jscripts_path}>/theme/jquery.mCustomScrollbar.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/scrolltotop.js"></script>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/catalog/order.js"></script>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/catalog/catalog.js"></script>
    <div class="bl-trash--wrapper">
        <div class="header">Моя корзина</div>
        <table>
            <tbody>
                <tr>
                    <th class="tl pl30" width="210">Фото товара</th>
                    <th class="tl" width="210">Описание</th>
                    <th class="col-100">Размер</th>
                    <th class="col-100">Количество</th>
                    <th class="col-100 col-pricce">Цена</th>
                    <th class="col-100">Изменить</th>
                </tr>
                <{if $cart}>
                <{foreach item=pack key=pack_id name=pack from=$cart}>
                    <{assign var=pack_summ value=0}>
                    <{foreach name=items item=data key=hash from=$pack}>
                        <{if $data.visible}>
                            <{assign var=prod_id value=$data.prod_id}>
                            <{assign var=prod value=D_Core_Factory::Store_Product($prod_id)}>
                            <tr class="item">
                                <td class="trash-element-photo" data-title="Фото товара">
                                    <a href="<{$me.www}>/store/show-product/product_<{$prod->prod_id}>" class="cart-photo">
                                        <img style="height:80px;" class="product_image" src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" /></a>
                                    </a>
                                </td>
                                <td class="trash-element-description" data-title="Описание">
                                    <div class="bl-trash--item_info">
                                        <{$prod->prod_name}>
                                    </div>
                                </td>
                                <td class="trash-element-sizes" data-title="Размер"><{$data.size}></td>
                                <td class="trash-element-quantity" data-title="Количество">
                                    <div class="qty--wrapper">
                                        <span class="new_qty" onclick="Trash.setQty('<{$hash}>', -1); return false; void(0);">-</span>
                                        <span class="qty_item" data-val="<{$data.quantity}>"><{$data.quantity}></span>
                                        <span class="new_qty" onclick="Trash.setQty('<{$hash}>', 1); return false; void(0);">+</span>
                                    </div>
                                </td>
                                <td class="trash-element-price" data-title="Цена"><{$prod->current_price}> руб.</td>
                                <td class="trash-element-delete" data-title="Изменить">
                                    <{if isset(D::$session['favorite']) && in_array($prod->prod_id, D::$session['favorite'])}>
                                        <div class="bl-favorite__trash__link--wrapper prod-<{$prod->prod_id}>">
                                            <a href="#" onclick="return FireFavorite.event(<{$prod->prod_id}>, 'trash', 'remove');"><i class="icon_star_trash--favorite red"></i></a>
                                        </div>
                                    <{else}>
                                        <div class="bl-favorite__trash__link--wrapper bl-favorite-prod-<{$prod->prod_id}>">
                                            <a href="#" onclick="return FireFavorite.event(<{$prod->prod_id}>, 'trash', 'add');"><i class="icon_star_trash--favorite grey"></i></a>
                                        </div>
                                    <{/if}>
                                    <span class="icon-del-trash" onclick="Trash.delItemTrash('<{$hash}>'); return false; void(0);"></span>
                                </td>
                            </tr>
                        <{/if}>
                    <{/foreach}>
                <{/foreach}>
                <{else}>
                    <tr class="empty_trash">
                        <td colspan="6">В корзине нет товаров</td>
                    </tr>
                <{/if}>
            </tbody>
        </table>
        <div class="responsive-basket">
            <{if $cart}>
            <{foreach item=pack key=pack_id name=pack from=$cart}>
                <{assign var=pack_summ value=0}>
                <{foreach name=items item=data key=hash from=$pack}>
                    <{if $data.visible}>
                        <{assign var=prod_id value=$data.prod_id}>
                        <{assign var=prod value=D_Core_Factory::Store_Product($prod_id)}>
                        <div id="c621ea2d22281cba22f7adf6927b68ef" class="responsive-basket__item">
                            <div class="responsive-basket__item--title">
                                <div class="responsive-basket__item--title-brand">

                                </div>
                                <div class="responsive-basket__item--title-model">
                                    <{$prod->prod_name}>
                                </div>
                            </div>
                            <div class="bl-favorite__trash__link--wrapper">
                                <a href="#" onclick="return Auth.openModal();"><i class="icon_star_trash--favorite grey"></i></a>
                            </div>
                            <div class="responsive-basket__item--delete" onclick="Trash.delItemTrash('c621ea2d22281cba22f7adf6927b68ef'); return false; void(0);"></div>
                            <div class="responsive-basket__item--photo">
                                <a href="#" class="cart-photo">
                                    <img style="height:80px;" class="product_image" src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" />
                                </a>
                            </div>
                            <div class="responsive-basket__item--description">
                                <div class="description-params">
                                    <div>Размер: 43</div>
                                    <div>Количество: <{$data.quantity}></div>
                                </div>
                                <div class="responsive-basket__item--price">Цена: <{$prod->current_price}> руб.</div>
                            </div>
                        </div>
                    <{/if}>
                <{/foreach}>
            <{/foreach}>
            <{else}>
                <div class="empty_trash">
                    <p>В корзине нет товаров</p>
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
                    <span class="value_sum"><{$cart_total.total_cost}> руб.</span>
                </div>
                <a href="<{$me.www}>/store/checkout">Оформить заказ</a>
            </div>
            <{*div class="bl-promocode__footer--wrapper">
                <div class="bl-footer_promo--container">
                    <span>промокод</span>
                    <input type="text" value="" onkeyup="return Trash.enterPromoCode(this.value);">
                    <span class="icon-del-trash clear-promo " onclick="return Trash.clearPromoCode();"></span>
                    <button onclick="return Trash.setPromoCode();">Применить</button>
                </div>
            </div>
            <div class="clear"></div>
            <div class="bl-promocode__footer_error--wrapper">
                <div class="promo_error">
                    Промокод введен некорректно или период его действия истек.<br>
                    Проверьте информацию об акции и попробуйте еще раз.
                </div>
            </div*}>
        </div>
    <{/if}>
</div>
</div>
