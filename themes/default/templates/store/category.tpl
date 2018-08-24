<div class="container l-goods-l">
	<div class="row l-goods-l__header">
		<div class="col-item"><h1 class="title-h1">Мужские кроссовки</h1></div>
	</div>

	<div class="row l-goods-l__section">
		<div class="col-item l-goods-l__filters">
			<div class="collapse filters-wrap" id="filters">
				<div class="urraa-loader urraa-loader-show"><div class="urraa-loader-curtain"></div></div>
			</div>
		</div>
		<div class="col-item l-goods-l__goods ">
			<div class="row">
				<div class="col-item">
					<div class="goods-list__picture jsPromVM">
						<a class="picture "
						href="<{$me.www}>"
						title="Оффер, супер предложение"
						target="_self">
							<img class="picture__image"
							 src="<{$theme.images}>/banner.jpg"
							 alt="Finler"
							 title="Finler">
						</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-item">
					<div class="filter-line">
						<div class="filter-line__top">
							<div class="filter-line-tab filter-line__tab" id="tabs">
								<div class="filter-line-tab__drop" id="collapseTabs">
									<div class="filter-line-tab__list">
										<div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/" >Все товары</a></div>
										<div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/adult/men/krossovki/filter/hit-is-novinki/apply/" >Новинки</a></div>
										<div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/adult/men/krossovki/filter/hit-is-rasprodazha/apply/" >Распродажа</a></div>
										<div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/kids/" >Детская</a></div>
										<div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/adult/" >Взрослая</a></div>
										<div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/ukhod_za_odezhdoy_i_obuvyu/" >Уход за обувью</a></div>
										<div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/adult/men/krossovki/filter/term_of_shipment-is-ekspress/apply/" >Экспресс-отгрузка</a></div>
									</div>
								</div>
							</div>

							<div class="filter-line-size filter-line__size">
								<div class="filter-line-size__title">Показывать по</div>
								<div class="filter-line-size__item"><a class="filter-line-size__link filter-line-size__link_active" href="/catalog/shoes/adult/men/krossovki/?show=20">20</a></div>
								<div class="filter-line-size__item"><a class="filter-line-size__link" href="/catalog/shoes/adult/men/krossovki/?show=60">60</a></div>
								<div class="filter-line-size__item"><a class="filter-line-size__link" href="/catalog/shoes/adult/men/krossovki/?show=100">100</a></div>
							</div>
						</div>

						<div class="filter-line__bottom">
							<!--noindex-->
							<div class="filter-line-sort filter-line__sort" id="sort">
								<a href="#filters" class="filter-line-sort__filter icon icon-filter collapsed" data-toggle="collapse" data-target="#filters">Фильтр</a>
								<a class="filter-line-sort__all collapsed" data-toggle="collapse" href="#collapseSort" data-parent="#sort">Сортировка</a>
								<div class="filter-line-sort__drop collapse" id="collapseSort">
									<div class="filter-line-sort__item">
										<a rel="nofollow"
										   href="/catalog/shoes/adult/men/krossovki/?sort=CREATED&order=asc&PAGEN_1=2"
										   class="filter-line-sort__link filter-line-sort__link_down filter-line-sort__link_active desc CREATED">По новизне</a>
									</div>
									<div class="filter-line-sort__item">
										<a rel="nofollow"
										   href="/catalog/shoes/adult/men/krossovki/?sort=SORT&order=desc&PAGEN_1=2"
										   class="filter-line-sort__link filter-line-sort__link_up  asc SORT">По популярности</a>
									</div>
								</div>
							</div>

							<div class="addBookmark filter-line__view"></div>
							<div class="filter-line-view filter-line__view hidden">
								<div class="filter-line-view__item"><a rel="nofollow" class="filter-line-view__link icon icon-sort-block filter-line-view__link_active" href="/catalog/shoes/adult/men/krossovki/?display=block&PAGEN_1=2" title="плиткой"></a></div>
								<div class="filter-line-view__item"><a rel="nofollow" class="filter-line-view__link icon icon-sort-list " href="/catalog/shoes/adult/men/krossovki/?display=list&PAGEN_1=2" title="списком"></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-item">
				</div>
			</div>

			<div class="row">
				<div class="col-item" data-entity="parent-container">
					<div class="goods-list ga_container" data-entity="container-1" data-list_name="CATALOG_SECTION">
						
						<{if count($products)}>
							<{foreach item=prod from=$products}>
							<div class="goods-list__item goods-card ga_item" data-entity="items-row">
								<div class="goods-card__frame product-item" 
                                    data-prod-id="<{$prod->prod_id}>"
                                    <{if $prod->fields['wholesale-discount-price']->content}>
										data-prod-price="<{$prod->fields['wholesale-discount-price']->content}>"
									<{else}>
										data-prod-price="<{$prod->fields['wholesale-price']->content}>"
									<{/if}>>
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
									
									<div class="goods-card__hover goods__put">
                                        <div class="goods-card__put">
                                            <div class="put put_sm to-cart-block">
                                                <div class="product-item-info-container product-item-hidden" data-entity="quantity-block">
                                                    <div class="put__counter" data-toggle="tooltip" data-original-title="">
                                                        <a class="put__arrow put__arrow_minus product-item-amount-field-btn-disabled" id="" href="#" rel="nofollow">
                                                        </a>
                                                        <input class="put__input" id="" type="tel" name="quantity" value="1" disabled="disabled">
                                                        <a class="put__arrow put__arrow_plus product-item-amount-field-btn-disabled" id="" href="#" rel="nofollow">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div id="">
                                                    <div class="put__btn 
                                                        btn 
                                                        btn_primary 
                                                        btn_size_xs 
                                                        product_add_to_basket_opt 
                                                        to-cart">В корзину</div>
                                                </div>
                                            </div>
                                            <a class="btn btn_primary btn_size_xs put__btn_in_basket" style="display:none" href=",http://sportlandshop.ru/store/order" rel="nofollow"><i class="icon icon-check"></i>В корзине</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<{/foreach}>
						<{/if}>
					</div>

					<!-- items-container -->
					<div class="row" data-use="show-more-1">
						<div class="col-item">
							<div class="loadmore">
								<div class="loadmore__btn">Показать еще</div>
							</div>
						</div>
					</div>
			
					<div data-pagination-num="1">
						<!-- pagination-container -->
						<div class="pagi l-goods-l__pagi">
							<a class="arrow arrow_prev arrow_navi" href="/catalog/shoes/adult/men/krossovki/?PAGEN_1=1"></a>
							<ul class="pagi__list">
								<li class="pagi__item"><a class="pagi__link" href="/catalog/shoes/adult/men/krossovki/" title="">1</a></li>
								<li class="pagi__item"><span class="pagi__active" title="">2</span></li>
								<li class="pagi__item"><a class="pagi__link" href="/catalog/shoes/adult/men/krossovki/?PAGEN_1=3" title="">3</a></li>
								<li class="pagi__item"><a class="pagi__link" href="/catalog/shoes/adult/men/krossovki/?PAGEN_1=4" title="">4</a></li>
								<li class="pagi__item"><span class="pagi__static">...</span></li>
								<li class="pagi__item"><a class="pagi__link" href="/catalog/shoes/adult/men/krossovki/?PAGEN_1=42" title="">42</a></li>
							</ul>

							<a class="arrow arrow_next arrow_navi" href="/catalog/shoes/adult/men/krossovki/?PAGEN_1=3"></a>
						</div>
					</div>
				</div>
			</div>

		</div>
		
	</div>

	<div class="col-itemright_block clearfix catalog">
		
	</div>


	<div class="row">
		<div class="col-item">
			<div class="content l-content__content">
			</div>
		</div>
	</div>
</div>
