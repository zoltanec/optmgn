<div id="content" class="clearfix mt114">
    <div class="bl-cabinet--wrapper">
        <div class="bl-cabinet--content bl-content--wrapper">
            <div class="bl-cabinet-favorite--wrapper">
                <h1>Избранное</h1>
                <{if $favorite}>
                    <div class="bl-attention__cab_favorite--wrapper">
                        <span>Товар в избранном не резервируется, его могут выкупить в любой момент!</span>
                    </div>
                    <div class="catalogue">
                        <div class="icat">
                            <{foreach item=prodId from=$favorite}>
                                <{assign var=prod value=D_Core_Factory::Store_Product($prodId)}>
                            
                            <a href="<{$me.www}>/store/show-product/product_<{$prod->prod_id}>">
                                <div class="photos">
                                    <{foreach name=pictures item=picture from=$prod->pictures}>
                                        <div class="photo p<{$smarty.foreach.pictures.iteration}> <{if !$smarty.foreach.pictures.index}>current<{/if}>">
                                            <div class="timg">
                                                <img alt="<{$prod->prod_name}>" 
                                                    title="<{$prod->prod_name}>" 
                                                    src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$picture->fileid}>" >
                                            </div>
                                            <span></span>
                                        </div>
                                    <{/foreach}>
                                    <div class="<{if $prod->fields['new']->content}>novinka skidka_prew<{/if}>
                                           <{if $prod->fields['club']->content}>club club_prew<{/if}>
                                           <{if $prod->fields['sale']->content}>discount-ico skidka_prew sale990<{/if}>
                                            "></div>
                                    <div class="bl-favorite__cabinet__link--wrapper">
                                        <span onclick="return FireFavorite.event(<{$prod->prod_id}>, 'cabinet', 'remove');">
                                        <img src="<{$theme.images}>/close.svg"></span>
                                    </div>
                                </div>
                                <div class="name">
                                    <b><{if $prod->fields['brand']->content}>
                                        <{$prod->fields['brand']->content}>
                                    <{else}>
                                        <{preg_replace("#(.*?)\s.*#", "$1", $prod->prod_name)}>
                                        <{/if}></b>
                                    <div class="upp"><{$prod->prod_name}></div>
                                    <{if !$prod->fields['discount_price']->content}>
                                        <b><{$prod->price}> руб.</b>
                                    <{else}>
                                        <b class="old_price_prew"><{$prod->price}> руб.</b>
                                        <b class="new_price_prew"><{$prod->fields['discount_price']->content}> руб.</b>
                                    <{/if}>
                                </div>
                                <div class="size">
                                    <span>Размеры в наличии:</span>
                                    <{foreach item=cols key=size from=unserialize($prod->fields['size']->content)}>
                                        <{if $cols['checked']}>
                                            <{$size}> |
                                        <{/if}>
                                    <{/foreach}>
                                </div>
                            </a>
                            <{/foreach}>
                        </div>
                    </div>
                <{else}>
                    <div class="bl-cabinet-favorite--wrapper">
                        <p>
                            <strong>Вы пока не добавляли товаров в избранное</strong><br><br>
                            Чтобы добавить товар в избранное, необходимо нажать на иконку
                            <span class="bl-favorite__product__link--wrapper">
                                <a href="#" onclick="return false;"><i class="icon_star_product--favorite grey"></i> в избранное</a>
                            </span> на странице товара.
                        </p>
                    </div>
                <{/if}>
            </div>
        </div>
    </div>
</div>