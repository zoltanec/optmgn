<{if count($products)}>
    <{foreach item=prod from=$products}>
    <div class="goods-list__item goods-card ga_item" id="" data-entity="items-row" data-product_id="">
        <div class="goods-card__frame">
            <a class="goods-card__link" 
            href="<{$me.www}>/store/show-product/product_<{$prod->prod_id}>" 
            title="<{$prod->prod_name}>"
            data-prod-id="<{$prod->prod_id}>" 
            data-prod-price="<{$prod->current_price}>"
            data-entity="image-wrapper">
                <div class="goods-card__img-wrap">
                    <img class="goods-card__img" src="http://sportlandshop.ru/content/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" alt="<{$prod->prod_name}>" >
                    <div class="goods-labels goods-card__labels">
                        <div class="goods-labels__list">
                            <{if $prod->fields['new']->content}>novinka skidka_prew<{/if}>
                            <{if $prod->fields['club']->content}>club club_prew<{/if}>
                            <{if $prod->fields['sale']->content}>discount-ico skidka_prew sale990<{/if}>
                            <div class="icon goods-labels__item goods-label goods-label_new" title="Новинки"></div>
                        </div>
                    </div>
                </div>
                <div class="goods-card__brand">
                    <{if $prod->fields['brand']->content}>
                        <{$prod->fields['brand']->content}>
                    <{else}>
                        <{preg_replace("#(.*?)\s.*#", "$1", $prod->prod_name)}>
                    <{/if}>
                </div>
                <div class="goods-card__name"><{$prod->prod_name}></div>
                <div class="goods-card__price price">
                    от <span class="price__value" id=""><{$prod->fields['wholesale-box-price']->content}></span> руб./шт</div>
                <div class="goods-card__price_old price price_old hidden">
                    от <span class="price__value" id=""></span><{$prod->fields['wholesale-price']->content}> руб./шт</div>
            </a>
            <div class="goods-card__hover">
                <div class="goods-card__put">
                    <div class="put put_sm to-cart-block">
                        <div class="product-item-info-container product-item-hidden" data-entity="quantity-block">
                            <div class="put__counter" data-toggle="tooltip" data-original-title="">
                                <a class="put__arrow put__arrow_minus product-item-amount-field-btn-disabled" id="bx_3966226736_1408701_7e1b8e3524755c391129a9d7e6f2d206_quant_down" href="javascript:void(0)" rel="nofollow">
                                </a>
                                <input class="put__input" id="" type="tel" name="quantity" value="1" disabled="disabled">
                                <a class="put__arrow put__arrow_plus product-item-amount-field-btn-disabled" id="" rel="nofollow">
                                </a>
                            </div>
                        </div>
                        <div id="">
                            <div class="put__btn 
                                btn 
                                btn_primary 
                                btn_size_xs 
                                product_add_to_basket_opt 
                                to-cart">В корзину</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <{/foreach}>
<{/if}>