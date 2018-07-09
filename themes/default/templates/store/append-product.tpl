<{assign var=discount value=Store_Cart::getDiscount()}>
<div class="product_show product_item" data-prod-id="<{$prod->prod_id}>" data-prod-price="<{$prod->price}>">
	<div class="product_show_wrap pull">
		<table>
			<tr>
				<td><div style="min-height:400px"><img class="product_image_preloader" style="width:auto; margin-top:184px" src="<{$theme.images}>/preloader.gif">
					<img class="product_image_original" style="display:none;" class="image_invisible" onclick="return D.modules.store.next(event, '<{$prod->prod_id}>');"  src="<{$me.content}>/media/<{$prod->picture->parentid}>/<{$prod->picture->fileid}>" /></td>
				</div><td>
				<div class="ps_name"><{$prod->prod_name}></div>
				<div class="ps_composition"><{$prod->description}> <{$prod->weight}>гр. <{$prod->psc}>шт.<{if $prod->fields['diametr']}>, диаметр <{$prod->fields['diametr']->content}> см<{/if}></div>
				<div class="ps_weight"><{$prod->weight}>гр.</div>
				<div class="product_price <{if $prod->fields['discount_price']->content}>old_price<{/if}>"><{if $prod->fields['discount_price']->content}><{$prod->price}><{else}><span class="prod_price"><{if $discount}><{floor($prod->price*$discount)}><{else}><{$prod->price}><{/if}></span><{/if}> руб.</div>
				<{if $prod->fields['discount_price']->content}><div class="product_price discount"><span class="prod_price"><{if $discount}><{floor($prod->current_price*$discount)}><{else}><{$prod->current_price}><{/if}></span> руб.</div><{/if}>
				<div class="button"><div class="buy_button" ><span class="button_small_text"><{if Store_Cart::checkProd($prod->prod_id)}>еще<{else}>в корзину<{/if}></span></div></div>
				</td>
			</tr>
		</table>
	</div>
</div>