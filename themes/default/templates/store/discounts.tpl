<div id="gallery_wrapper">
	<div  class="gw_menu">
	<{*if $parent_category->category_code!='hand_made' && $category->category_code!='drinks'}>
		<div id="sorting">
    <div id="sorting_title">Показывать только:</div>
    <input type="hidden" name="category" value="" />
    <div id="sorting_input"><input type="checkbox" name="vega" value="1" /><div>Вегетарианские</div></div>
   </div>
   <{/if*}>
		<ul>
			<li class="<{if $category->category_code==$parent_category->category_code}>active skew<{/if}>"><a href="<{$me.path}>/discounts#products"><span>Все</span></a><span>Все</span></li>
			<{foreach item=category_item from=Store_Category::getChildCategories($parent_category->category_id, 0, false)}>
				<{assign var='products' value=Store_Product::getBySearchCond("category_id=`$category_item->category_id`")}>
				<{assign var='products' value=Store_Product::sortByFields($products,'discount_price')}>
				<{if count($products)}>
				<li class="<{if $category_item->category_code==$category->category_code}>active skew<{/if}>"><a href="<{$me.path}>/discounts/<{$category_item->category_code}>#products"><span><{$category_item->category_name}></span></a><span><{$category_item->category_name}></span></li>
				<{/if}>
			<{/foreach}>
		</ul>
	</div>
	<!--GALLERY-->
	<a name="products"></a>
	<div class="gallery">
		<{foreach item=category_item from=Store_Category::getChildCategories($category->category_code, 0, false)}>
		<{assign var='products' value=Store_Product::getBySearchCond("category_id=`$category_item->category_id`")}>
		<{assign var='products' value=Store_Product::sortByFields($products,'discount_price')}>
				<{if count($products)}>
		<div class="titles"><span><{$category_item->category_name}></span></div>
		<{foreach item=prod from=$products}>		
			<div class="product product_item" data-type="product" data-prod-id="<{$prod->prod_id}>" data-prod-price="<{$prod->current_price}>">
				<div class="product_block">
					<{if $prod->fields['spicy']->content}><div <{if $prod->fields['hit']->content}>class="left_pos"<{/if}>id="spicy"></div><{/if}>
					<a href="<{$me.www}>/store/show-product/product_<{$prod->prod_id}>" title="<{$prod->prod_name}>">
						<div class="product_img">
						<img alt="<{$prod->prod_name}>" title="<{$prod->description}>" class="product_image" onload="this.style.opacity = 1" src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" data-src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" alt="<{$prod->prod_name}>" />
						</div>
						<div class="product_name"><{$prod->prod_name}></div>
						<div class="product_weight"><{$prod->weight}>гр. <{if $prod->category_id==14}><{$prod->psc}>шт.<{/if}></div>
						<div class="product_price old_price"><span class="prod_price"><{if Store_Cart::checkDelivery()}><{$prod->price}><{else}><{floor($prod->price*0.95)}><{/if}></span> руб.</div>
						<div class="product_price discount"><span class="prod_price"><{$prod->fields['discount_price']->content}></span> руб.</div>
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
		<{/if}>
		<{/foreach}>
	</div>
	<!--END GALLERY-->
</div>
<!--END GALLERY WRAPPER-->