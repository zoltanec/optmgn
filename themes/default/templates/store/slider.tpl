<div class="slider-wrap">
	<div class="row">
		<div class="col-md-6">
			<h4 class="slider-title"><{$sliderTitle}></h4>
		</div>
		<div class="col-md-6">
			<div class="slider-nav arrow-div">
				<a class="arrow arrow_prev arrow_navi slider slider-prev"></a>
				<a class="arrow arrow_next arrow_navi slider slider-next"></a>
			</div>
		</div>
	</div>
	<div class="row slider-div">
		<div class="col-item" data-entity="parent-container">
			<div class="goods-list ga_container" data-entity="container-1" data-list_name="CATALOG_SECTION">
				<{foreach item=prod from=$productList}>
				<div class="goods-list__item goods-card ga_item item-hit" data-entity="items-row">
					<a class="goods-card__link"
					   href="<{$me.www}>/store/show-product/product_<{$prod->prod_id}>"
					   title="<{$prod->prod_name}>"
					   data-entity="image-wrapper">
						<div class="goods-card__img-wrap">
							<img class="goods-card__img"
								 src="http://sportlandshop.ru/content/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>"
								 alt="<{$prod->prod_name}>" >
							<div class="goods-labels goods-card__labels">
								<div class="goods-labels__list">
									<{if $prod->fields['new']->content}><div class="icon goods-labels__item goods-label goods-label_new" title="Новинки"></div><{/if}>
									<{if $prod->fields['wholesale-discount-price']->content}><div class="icon goods-labels__item goods-label goods-label_stock-persent">Sale</div><{/if}>
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
							от <span class="price__value"><{$prod->getCurrentPrice()}></span> руб./шт</div>
						<{if $prod->getDefPrice()}>
						<div class="goods-card__price_old price price_old">
							от <span class="price__value"><{$prod->getDefPrice()}></span> руб./шт
						</div>
						<{/if}>
						<div class="goods-card__wholesale">
							оптом по
							<span class="goods-card__wholesale-value"><{$prod->getBoxQt()}></span> шт.
							<div class="goods-card__wholesale-price price">от
								<span class="price__value" id=""><{$prod->getBoxQt() * $prod->getCurrentPrice()}></span> руб./уп.
							</div>
							<{if $prod->getDefPrice()}>
							<div class="goods-card__wholesale_old price price_old">от
								<span class="price__value" id=""><{$prod->getBoxQt() * $prod->getDefPrice()}></span> руб./уп.
							</div>
							<{/if}>
						</div>
					</a>
				</div>
				<{/foreach}>
			</div>
		</div>
	</div>
</div>