<div class="container l-goods-l">
	<div class="row l-goods-l__header"><div class="col-item"><h1 class="title-h1">Обувь оптом</h1></div></div>
	<div class="row l-goods-l__section">
		<div class="col-item l-goods-l__filters">
			<div class="collapse filters-wrap" id="filters">
				<div class="filters__item bx_filter_parameters_box " data-expanded="Y" data-prop_code="type" property_id="334">
					<div class="filters__title  " data-toggle="collapse" data-target="#filter_type">
						<div data-toggle="tooltip" title="" data-original-title="">Категория</div>
					</div>
					<div class="filters__block collapse in" id="filter_type">
						<div class="bx_filter_parameters_box_container ">
							<label class="filters__search icon icon-zoom">
								<input class="filters__search-input input-text" type="text" placeholder="Поиск..." data-search="#filterItemsTYPE" name="filter_elements">
							</label>
							<div class="filters__contain scroller mCustomScrollbar _mCS_1">
								<div id="mCSB_1" class="mCustomScrollBox mCS-inset mCSB_vertical mCSB_inside" style="max-height: 300px;" tabindex="0">
									<div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
										<div class="scroller__content" id="filterItemsTYPE">
											<label class="checkbox " data-role="label_SMART_FILTER_334_3484748419" for="SMART_FILTER_334_3484748419">
												<input class="checkbox__input" type="checkbox" value="Y" name="SMART_FILTER_334_3484748419" id="SMART_FILTER_334_3484748419" onclick="smartFilter.click(this)">
												<span class="checkbox__text">Балетки&nbsp;(<span data-role="count_SMART_FILTER_334_3484748419">618</span>)</span>
											</label>
											<label class="checkbox " data-role="label_SMART_FILTER_334_651603894" for="SMART_FILTER_334_651603894">
												<input class="checkbox__input" type="checkbox" value="Y" name="SMART_FILTER_334_651603894" id="SMART_FILTER_334_651603894" onclick="smartFilter.click(this)">
												<span class="checkbox__text">Босоножки&nbsp;(<span data-role="count_SMART_FILTER_334_651603894">1128</span>)</span>
											</label>																			
										</div>
									</div>
									<div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-inset mCSB_scrollTools_vertical" style="display: block;">
										<div class="mCSB_draggerContainer">
											<div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 84px; max-height: 290px; top: 0px;">
												<div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
											</div>
										<div class="mCSB_draggerRail"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		<div class="col-item l-goods-l__goods ">
			<div class="row">
				<div class="col-md-6">
					<h4 class="slider-title">Хиты продаж</h4>
				</div>
				<div class="col-md-6">
					<div class="arrow-div">
						<a class="arrow arrow_prev arrow_navi slider slider-prev"></a>
						<a class="arrow arrow_next arrow_navi slider slider-next"></a>
					</div>
				</div>
			</div>
			<div class="row slider-div">
				<div class="col-item" data-entity="parent-container">
					<div class="goods-list ga_container" data-entity="container-1" data-list_name="CATALOG_SECTION">
						<{foreach item=prod from=$hit}>
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
			<!--NEW-->
			<div class="row">
				<div class="col-md-6">
					<h4 class="slider-title">Новинки</h4>
				</div>
				<div class="col-md-6">
					<div class="arrow-div">
						<a class="arrow arrow_prev arrow_navi slider slider-prev"></a>
						<a class="arrow arrow_next arrow_navi slider slider-next"></a>
					</div>
				</div>
			</div>
			<div class="row slider-div">
				<div class="col-item" data-entity="parent-container">
					<div class="goods-list ga_container" data-entity="container-1" data-list_name="CATALOG_SECTION">
						<{foreach item=prod from=$new}>
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
			<!--Sale-->
			<div class="row">
				<div class="col-md-6">
					<h4 class="slider-title">Распродажа</h4>
				</div>
				<div class="col-md-6">
					<div class="arrow-div">
						<a class="arrow arrow_prev arrow_navi slider slider-prev"></a>
						<a class="arrow arrow_next arrow_navi slider slider-next"></a>
					</div>
				</div>
			</div>
			<div class="row slider-div">
				<div class="col-item" data-entity="parent-container">
					<div class="goods-list ga_container" data-entity="container-1" data-list_name="CATALOG_SECTION">
						<{foreach item=prod from=$sale}>
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
	</div>
</div>
