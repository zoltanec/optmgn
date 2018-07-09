<div id="gallery_wrapper">
	<div class="gw_menu">
	<{if $parent_category->category_code!='hand_made' && $category->category_code!='drinks'}>
		<div id="sorting">
    <div id="sorting_title">Показывать только:</div>
    <input type="hidden" name="category" value="<{$req->textLine('param1')}>" />
    <{if $parent_category->category_code=='japan'}><div id="sorting_input"><input type="checkbox" name="without_fish" value="1" /><div>Без сырой рыбы</div></div><{/if}>
    <div id="sorting_input"><input type="checkbox" name="vega" value="1" /><div>Вегетарианские</div></div>
   </div>
   <{/if}>
		<ul>
			<li class="<{if $category->category_code==$parent_category->category_code}>active skew<{/if}>"><a href="<{$me.path}>/category/<{$parent_category->category_code}>#products"><span>Все</span></a><span>Все</span></li>
			<{foreach item=category_item from=Store_Category::getChildCategories($parent_category->category_id, 0, false)}>
				<li class="<{if $category_item->category_code==$category->category_code}>active skew<{/if}>"><a href="<{$me.path}>/category/<{$category_item->category_code}>#products"><span><{$category_item->category_name}></span></a><span><{$category_item->category_name}></span></li>
			<{/foreach}>
				<li class="<{if $category->category_code=="drinks"}>active skew<{/if}>"><a href="<{$me.path}>/category/drinks/<{$parent_category->category_code}>/#products"><span>Напитки</span></a><span>Напитки</span></li>
		</ul>
	</div>
	<!--GALLERY-->
	<a name="products"></a>
	<div class="gallery wok_product">
		<{foreach item=category_item from=Store_Category::getChildCategories($category->category_code, 0, false)}>
		<{assign var='products' value=Store_Product::getBySearchCond("category_id=`$category_item->category_id`")}>
		<{if $products->total}>
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
						<div class="product_price <{if $prod->fields['discount_price']->content}>old_price<{/if}>"><{if $prod->fields['discount_price']->content}><{$prod->price}><{else}><span class="prod_price"><{if $discount}><{floor($prod->price*$discount)}><{else}><{$prod->price}><{/if}></span><{/if}> руб.</div>
						<{if $prod->fields['discount_price']->content}><div class="product_price discount"><span class="prod_price"><{if $discount}><{floor($prod->current_price*$discount)}><{else}><{$prod->current_price}><{/if}></span> руб.</div><{/if}>
					</a>

					<div class="product_buy ">
					<select class="wok_select">
						<option value=''>Выберите основу</option>
						<option value='Рис'>Рис</option>
						<option value='Пшеничная лапша'>Пшеничная лапша</option>
						<option value='Лапша Удон'>Лапша Удон</option>
						<option value='Лапша стеклянная'>Лапша стеклянная</option>
            <option value='Лапша соба'>Лапша соба</option>
					</select>
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
		<{assign var='drinks' value=Store_Product::getBySearchCond("category_code='drinks'")}>
		<div class="titles"><span>Напитки</span></div>
		<{foreach item=prod from=$drinks}>
			<div class="product product_item" data-type="product" data-prod-id="<{$prod->prod_id}>" data-prod-price="<{$prod->price}>">
				<div class="product_block">
					<a href="<{$me.www}>/store/show-product/<{$category->category_code}>/product_<{$prod->prod_id}>" title="<{$prod->prod_name}> <{$prod->desc}>">
						<div class="product_img">
						<img alt="<{$prod->prod_name}>" title="<{$prod->prod_name}>" class="product_image" src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" alt="<{$prod->prod_name}>" />
						</div>
						<div class="product_name"><{$prod->prod_name}></div>
							<div class="product_price"><span class="prod_price"><{if $discount}><{floor($prod->price*$discount)}><{else}><{$prod->price}><{/if}></span> руб.</div>


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
	<!--END GALLERY-->
</div>
<!--END GALLERY WRAPPER-->