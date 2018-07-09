<!--LINE TITLE-->
<div class="line_title"><span>Хиты продаж</span></div>
<!--GALLERY-->
<div class="gallery">
		<{foreach item=prod from=$products}>		
			<div class="product product_item" data-type="product" data-prod-id="<{$prod->prod_id}>" data-prod-price="<{$prod->current_price}>">
				<div class="product_block">
					<{*if $prod->fields['spicy']->content}><div id="spicy"></div><{/if*}>
					<a href="<{$me.www}>/store/show-product/product_<{$prod->prod_id}>" title="<{$prod->prod_name}>">
						<div class="product_img">
						<img alt="<{$prod->prod_name}>" title="<{$prod->description}>" class="product_image" data-src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" alt="<{$prod->prod_name}>" />
						</div>
						<div class="product_name"><{$prod->prod_name}></div>
							<div class="product_weight"><{$prod->weight}>гр. <{if $prod->category_id==14}><{$prod->psc}>шт.<{/if}></div>
							<div class="product_price <{if $prod->fields['discount_price']->content}>old_price<{/if}>"><{if $prod->fields['discount_price']->content}><{$prod->price}><{else}><span class="prod_price"><{if $discount}><{floor($prod->price*$discount)}><{else}><{$prod->price}><{/if}></span><{/if}> руб.</div>
						<{if $prod->fields['discount_price']->content}><div class="product_price discount"><span class="prod_price"><{if $discount}><{floor($prod->current_price*$discount)}><{else}><{$prod->current_price}><{/if}></span> руб.</div><{/if}>
						
					</a>
					<div class="product_buy">
					<div class="button buy_button">
						<div>
							<span class="button_small_text"><{if Store_Cart::checkProd($prod->prod_id)}>Еще<{else}>В корзину<{/if}></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<{/foreach}>
</div>