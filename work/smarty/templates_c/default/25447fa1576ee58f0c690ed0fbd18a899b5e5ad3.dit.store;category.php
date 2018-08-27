<?php /* Smarty version Smarty3-RC3, created on 2018-08-27 21:49:01
         compiled from "dit:store;category" */ ?>
<?php /*%%SmartyHeaderCode:455650775b6ae50f7471d4-61375334%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25447fa1576ee58f0c690ed0fbd18a899b5e5ad3' => 
    array (
      0 => 'dit:store;category',
      1 => 1535388466,
    ),
  ),
  'nocache_hash' => '455650775b6ae50f7471d4-61375334',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<input type="hidden" id="category_page">
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
						href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
"
						title="Оффер, супер предложение"
						target="_self">
							<img class="picture__image"
							 src="<?php echo $_smarty_tpl->getVariable('theme')->value['images'];?>
/banner.jpg"
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
						
						<?php if (count($_smarty_tpl->getVariable('products')->value)){?>
							<?php  $_smarty_tpl->tpl_vars['prod'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['prod']->key => $_smarty_tpl->tpl_vars['prod']->value){
?>
							<div class="goods-list__item goods-card ga_item" data-entity="items-row">
								<div class="goods-card__frame product-item" 
                                    data-prod-id="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
"
                                    <?php if ($_smarty_tpl->getVariable('prod')->value->fields['wholesale-discount-price']->content){?>
										data-prod-price="<?php echo $_smarty_tpl->getVariable('prod')->value->fields['wholesale-discount-price']->content;?>
"
									<?php }else{ ?>
										data-prod-price="<?php echo $_smarty_tpl->getVariable('prod')->value->fields['wholesale-price']->content;?>
"
									<?php }?>>
									<a class="goods-card__link" 
									href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/show-product/product_<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
" 
									title="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
"
									data-entity="image-wrapper">
										<div class="goods-card__img-wrap">
											<img class="goods-card__img" 
												src="http://sportlandshop.ru/content/media/thumbs/product<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
/<?php echo $_smarty_tpl->getVariable('prod')->value->picture->fileid;?>
"
												alt="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
" >
											<div class="goods-labels goods-card__labels">
												<div class="goods-labels__list">
													<?php if ($_smarty_tpl->getVariable('prod')->value->fields['new']->content){?><div class="icon goods-labels__item goods-label goods-label_new" title="Новинки"></div><?php }?>
													<?php if ($_smarty_tpl->getVariable('prod')->value->fields['wholesale-discount-price']->content){?><div class="icon goods-labels__item goods-label goods-label_stock-persent">Sale</div><?php }?>
												</div>
											</div>
										</div>
										<div class="goods-card__brand">
											<?php if ($_smarty_tpl->getVariable('prod')->value->fields['brand']->content){?>
												<?php echo $_smarty_tpl->getVariable('prod')->value->fields['brand']->content;?>

											<?php }else{ ?>
												<?php echo preg_replace("#(.*?)\s.*#","$"."1",$_smarty_tpl->getVariable('prod')->value->prod_name);?>

											<?php }?>
										</div>
										<div class="goods-card__name"><?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
</div>
										<div class="goods-card__price price">
											от <span class="price__value"><?php echo $_smarty_tpl->getVariable('prod')->value->getCurrentPrice();?>
</span> руб./шт</div>
											<?php if ($_smarty_tpl->getVariable('prod')->value->getDefPrice()){?>
												<div class="goods-card__price_old price price_old">
													от <span class="price__value"><?php echo $_smarty_tpl->getVariable('prod')->value->getDefPrice();?>
</span> руб./шт
												</div>
											<?php }?>
                                        <div class="goods-card__wholesale">
                                            оптом по
                                            <span class="goods-card__wholesale-value"><?php echo $_smarty_tpl->getVariable('prod')->value->getBoxQt();?>
</span> шт.
											<div class="goods-card__wholesale-price price">от
												<span class="price__value" id=""><?php echo $_smarty_tpl->getVariable('prod')->value->getBoxQt()*$_smarty_tpl->getVariable('prod')->value->getCurrentPrice();?>
</span> руб./уп.
											</div>
											<?php if ($_smarty_tpl->getVariable('prod')->value->getDefPrice()){?>
												<div class="goods-card__wholesale_old price price_old">от
													<span class="price__value" id=""><?php echo $_smarty_tpl->getVariable('prod')->value->getBoxQt()*$_smarty_tpl->getVariable('prod')->value->getDefPrice();?>
</span> руб./уп.
												</div>
                                            <?php }?>
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
							<?php }} ?>
						<?php }?>
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
							<?php  $_smarty_tpl->tpl_vars['prod'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('hit')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['prod']->key => $_smarty_tpl->tpl_vars['prod']->value){
?>
								<div class="goods-list__item goods-card ga_item item-hit" data-entity="items-row">
									<a class="goods-card__link"
									   href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/show-product/product_<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
"
									   title="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
"
									   data-entity="image-wrapper">
										<div class="goods-card__img-wrap">
											<img class="goods-card__img"
												 src="http://sportlandshop.ru/content/media/thumbs/product<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
/<?php echo $_smarty_tpl->getVariable('prod')->value->picture->fileid;?>
"
												 alt="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
" >
											<div class="goods-labels goods-card__labels">
												<div class="goods-labels__list">
													<?php if ($_smarty_tpl->getVariable('prod')->value->fields['new']->content){?><div class="icon goods-labels__item goods-label goods-label_new" title="Новинки"></div><?php }?>
													<?php if ($_smarty_tpl->getVariable('prod')->value->fields['wholesale-discount-price']->content){?><div class="icon goods-labels__item goods-label goods-label_stock-persent">Sale</div><?php }?>
												</div>
											</div>
										</div>
										<div class="goods-card__brand">
											<?php if ($_smarty_tpl->getVariable('prod')->value->fields['brand']->content){?>
											<?php echo $_smarty_tpl->getVariable('prod')->value->fields['brand']->content;?>

											<?php }else{ ?>
											<?php echo preg_replace("#(.*?)\s.*#","$"."1",$_smarty_tpl->getVariable('prod')->value->prod_name);?>

											<?php }?>
										</div>
										<div class="goods-card__name"><?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
</div>
										<div class="goods-card__price price">
											от <span class="price__value"><?php echo $_smarty_tpl->getVariable('prod')->value->getCurrentPrice();?>
</span> руб./шт</div>
										<?php if ($_smarty_tpl->getVariable('prod')->value->getDefPrice()){?>
										<div class="goods-card__price_old price price_old">
											от <span class="price__value"><?php echo $_smarty_tpl->getVariable('prod')->value->getDefPrice();?>
</span> руб./шт
										</div>
										<?php }?>
										<div class="goods-card__wholesale">
											оптом по
											<span class="goods-card__wholesale-value"><?php echo $_smarty_tpl->getVariable('prod')->value->getBoxQt();?>
</span> шт.
											<div class="goods-card__wholesale-price price">от
												<span class="price__value" id=""><?php echo $_smarty_tpl->getVariable('prod')->value->getBoxQt()*$_smarty_tpl->getVariable('prod')->value->getCurrentPrice();?>
</span> руб./уп.
											</div>
											<?php if ($_smarty_tpl->getVariable('prod')->value->getDefPrice()){?>
											<div class="goods-card__wholesale_old price price_old">от
												<span class="price__value" id=""><?php echo $_smarty_tpl->getVariable('prod')->value->getBoxQt()*$_smarty_tpl->getVariable('prod')->value->getDefPrice();?>
</span> руб./уп.
											</div>
											<?php }?>
										</div>
									</a>
								</div>
							<?php }} ?>
						</div>
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
