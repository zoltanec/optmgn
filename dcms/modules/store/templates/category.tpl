<div id="all_product_wrap">
	<{assign var='products' value=Store_Product::getProductsByCategory($category->category_id)}>
	<{if $products->total}>
	<table class="product_table">
		<tr>
			<td class="category_name"><canvas width="30px" height="270px" data-text="<{$category->category_name}>"></canvas></td>
			<td class="at_product_content">
			<{foreach item=prod from=$products}>		
				<div class="product">
					<div class="product_img"><a href="<{$me.www}>/store/show-product/<{$category->category_code}>/product_<{$prod->prod_id}>" title="<{$prod->prod_name}>">
						<img src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" alt="<{$prod->prod_name}>" /></a></div>
					<div class="product_discr">
						<a class="pd_link" href="<{$me.www}>/store/show-product/<{$category->category_code}>/product_<{$prod->prod_id}>" title="<{$prod->prod_name}>"><{$prod->prod_name}></a><br />
						<span class="pd_weight"><{$prod->weight}>гр. <{$prod->psc}>шт.</span><br />
						<form class="add-cart" action="<{$me.www}>/store/add-to-cart/product_<{$prod->prod_id}>" method="post">
							<span class="pd_price"><input name="quantity" value="1" align="right" type="text" /><{$prod->price}><span class="pd_rub">&#8399;</span><span class="pd_black">/<{if $main_category=='food'}>порция<{else}>шт.<{/if}></span></span>
							<!--a class="pd_btn_buy" href="#"></a-->
							<input class="bybtn pd_btn_buy" type="submit" value="">
						</form>
					</div>
				</div>
			<{/foreach}>
			</td>
		</tr>
	</table>
	<{/if}>
</div>