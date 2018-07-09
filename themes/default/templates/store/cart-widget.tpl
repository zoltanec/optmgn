<div class="bl-after_add_trash--wrapper">
    <{if isset($addedProduct)}>
        <div class="add_small--wrapper">
            <h4>Добавлено в Вашу корзину</h4>
            <div class="bl-info_good--wrapper">
                <div class="bl-img">
                    <img style="height:80px;" class="product_image" src="<{$me.content}>/media/thumbs/product<{$addedProduct->prod_id}>/<{$addedProduct->picture->fileid}>" />
                </div>
                <div class="bl-info">
                    <span class="name"><{$addedProduct->prod_name}></span>
                    <span class="param">Размер:<{$addedProduct->size}></span>
                    <span class="param">Количество: 1</span>
                    <span class="price"><{$addedProduct->price}> руб.</span> 
                </div>
            </div>
        </div>
    <{/if}>
</div>
<script>
    $(document).ready(function(){
        var doc_h 			= $(window).height();
        var cnt_in_trash 	= $("#cnt_good_in_trash").val();
        if(doc_h < 800){
            var h = 320;
            var v = 2;
            if(window.innerHeight <= 768){
                v = 1;
                h = 160;
                $(".bl-list_trash--container .items.slider_wrapper .items_wrapper").css("height", "160px");
            }else{
                $(".bl-list_trash--container .items.slider_wrapper .items_wrapper").css("height", "320px");
            }
            $('.items').vaccordion({
                accordionW: 294,
                accordionH: h,
                expandedHeight	: 162,
                visibleSlices: v
            });
        } else{
            var h = 480;
            var v = 3;
            if(window.innerHeight <= 768){
                v = 1;
                h = 160;
            }
            if(cnt_in_trash < 4){
                $('.items').removeClass("slider_wrapper");
            }
            if(cnt_in_trash > 3){
                $('.items').vaccordion({
                    accordionW: 294,
                    accordionH: h,
                    expandedHeight	: 162,
                    visibleSlices: v
                });
            }
        }
    });
</script>
<{assign var=cart value=Store_Cart::getCart()}>
<{assign var=total value=Store_Cart::getCartSum()}>
<input type="hidden" id="cnt_good_in_trash" value="<{$total.total_quantity}>">
<{if $cart}>
    <div class="bl-small_trash--wrapper canopen">
        <div class="header_small_trash" onclick="window.location.href = '/store/order'; return false;">
            <i></i>
            <span class="cnt_trash"><{$total.total_quantity}></span>
        </div>
        <div class="bl-list_trash--wrapper">
            <div class="bl-list_trash--container">
                <h4>Добавлено в Вашу корзину</h4>
                <div class="items slider_wrapper" style="width: 294px; height: 160px;">
                    <{if $total.total_quantity > 2}>
                        <div class="va-nav">
                            <div class="va-nav-prev"><span class="va-nav-prev-span">Previous</span></div>
                            <div class="va-nav-next" style="display: block;"><span class="va-nav-next-span">Next</span></div>
                        </div>
                    <{/if}>
                    <div class="items_wrapper" style="height: 160px;">
                        <{foreach item=pack key=pack_id name=pack from=$cart}>
                            <{assign var=pack_summ value=0}>
                            <{foreach name=items item=data key=hash from=$pack}>
                                <{if $data.visible}>
                                    <{assign var=prod_id value=$data.prod_id}>
                                    <{assign var=prod value=D_Core_Factory::Store_Product($prod_id)}>
                                    <div class="item va-slice" id="aa43d2877fdd0de47c80bce70e7bd0e3" style="top: 160px; height: 160px;">
                                        <i onclick="Trash.delItemSmallTrash('aa43d2877fdd0de47c80bce70e7bd0e3'); return false; void(0);"></i>
                                        <div class="bl-img">
                                            <a href="#" class="cart-photo">
                                                <img style="height:80px;" class="product_image" src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" /></a>
                                        </div>
                                        <div class="bl-info">
                                            <span class="name"><{$prod->prod_name}></span>
                                            <span class="param">Размер: <{$data.size}></span>
                                            <span class="param">Количество: <{$data.quantity}></span>
                                            <span class="price"><{$prod->current_price}> руб.</span>
                                        </div>
                                    </div>
                                <{/if}>
                            <{/foreach}>
                        <{/foreach}>
                    </div>
                </div>
                <div class="list_trash--footer">
                    <div class="total_price">
                        <div class="label"><span>Стоимость:</span></div>
                        <div class="value"><span><{$total.total_cost}> руб.</span></div>
                    </div>
                    <a href="/store/order">Оформить заказ</a>
                </div>
            </div>
        </div>
    </div>
<{else}>
    <div class = "bl-small_trash--wrapper">
        <div class = 'header_small_trash'>
            <i></i>
        </div>
    </div>
<{/if}>