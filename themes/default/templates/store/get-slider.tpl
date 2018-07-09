<{assign var=discount value=Store_Cart::getDiscount()}>
		<div class="nav left_arrow trans_back"></div>
		<div class="nav right_arrow trans_back"></div>
		<img id="loader" src="<{$theme.images}>/loader.gif" />
		<div id="slider_wrap">
			<{foreach item=prod from=Store_Product::getBySearchCond($cond)}>
				<div class="product_show product_item" data-prod-id="<{$prod->prod_id}>" data-prod-price="<{$prod->price}>">
				 <div class="product_show_wrap pull">
				 <{*if $prod->fields['hit']->content}><div id="hit"></div><{/if*}>
					<{*if $prod->fields['spicy']->content}><div id="spicy"></div><{/if*}>
				  <table>
				   <tr>
					<td><img title="<{$prod->description}>" src="<{$me.content}>/media/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" alt="<{$prod->prod_name}>" /></td>
					<td>
					 <{if $prod->fields['new']->content}><div class="ps_event">Новинка! </div><{/if}>
					 <div class="ps_name"><{$prod->prod_name}></div>
					 <div class="ps_composition"><{$prod->description}></div>
					 <div class="product_price <{if $prod->fields['discount_price']->content}>old_price<{/if}>"><{if $prod->fields['discount_price']->content}><{$prod->price}><{else}><span class="prod_price"><{if $discount}><{floor($prod->price*$discount)}><{else}><{$prod->price}><{/if}></span><{/if}> руб.</div>
						<{if $prod->fields['discount_price']->content}><div class="product_price discount"><span class="prod_price"><{if $discount}><{floor($prod->current_price*$discount)}><{else}><{$prod->current_price}><{/if}></span> руб.</div><{/if}>
					 <div class="button"><div class="buy_button" ><span class="button_small_text"><{if Store_Cart::checkProd($prod->prod_id)}>еще<{else}>В корзину<{/if}></span></div></div>
					</td>
				   </tr>
				  </table>
				 </div>
				</div>
			<{/foreach}>
		</div>
		<!--end product_show-->
		<div id="mininav">
		    <div class="nav dot_arrow_left trans_back"><!--когда размер окна меньше 1600px, появляются маленькие стрелки, которые берут на себя функцию больших. --></div>
			<div id="slider_dots">
			  <{foreach item=prod name="dots" from=Store_Product::getBySearchCond($cond)}>
			  <div <{if $smarty.foreach.dots.index==0}>class="active"<{/if}>></div>
			  <{/foreach}>
			</div>
			<div class="nav dot_arrow_right trans_back"></div>
		</div>