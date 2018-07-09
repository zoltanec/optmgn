<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 16:25:08
         compiled from "dit:/home/www/kuksha/www.sportlopt.ru/public_html/themes/default/theme.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18714261675b434615013da0-69657342%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10de9cab127449c4e6eb9f6f111ac2bde546ef4f' => 
    array (
      0 => 'dit:/home/www/kuksha/www.sportlopt.ru/public_html/themes/default/theme.tpl',
      1 => 1531135483,
    ),
  ),
  'nocache_hash' => '18714261675b434615013da0-69657342',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="Мужские кроссовки, недорого купить оптом от производителя в Москве, интернет-магазин СЛОПТ, sportlopt.ru" />
    <meta name="description" content="Интернет-магазин sportlopt предлагает оптом широкий ассортимент качественной мужской обуви от производителя.
        У нас на сайте вы можете дешево купить мужские кроссовки по низкой цене. 
        В наличии большой выбор моделей. Бесплатная доставка по России, в Республику Беларусь и Казахстан.
        Гарантия качества. Наш телефон: <?php echo $_smarty_tpl->getVariable('config')->value['phone'];?>
" />
    <link href="<?php echo $_smarty_tpl->getVariable('theme')->value['css'];?>
/core.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value->jscripts_path;?>
/theme/jquery-1.10.2.min.js@v=1444923200"></script>
    <title>
        <?php if ($_smarty_tpl->getVariable('meta')->value['title']){?>
            <?php echo $_smarty_tpl->getVariable('meta')->value['title'];?>

        <?php }else{ ?>
            Интернет-магазин кроссовок и спортивной одежды
        <?php }?>
    </title>
    <meta name="description" content="Интернет-магазин кроссовок" />
</head>
<body class=" page-inner">
	<div id="bx-panel-wrapper" class="bx-panel-wrapper" style="position: relative; top: 0; left: 0; width: 100%;"></div>
	<div class="topline">
		<div class="fix">
			<div class="topline-contacts contacts">
                <div class="contacts__top">
                    <div class="contacts__phone contacts__phone_moscow">
                        фывфыафы
                    </div>
                </div>
                <div class="contacts__bottom">
                    <span class="contacts__request callback_btn callback_btn_footer" >Заказать звонок</span>
                    <span class="contacts__time">с 9:00 до 18:00</span>
                </div>
            </div>
            <nav class="topline__top-menu">
				<span class="topline__dropdown ">
                    <a class="topline__link icon-after icon-after-angle-down" href="/company/">О компании</a>
					<span class="topline__list">
						<a class="topline__link topline__link_inside" href="/contacts/">Контакты</a>
						<a class="topline__link topline__link_inside" href="/loyalty/">Программа лояльности</a>
					</span>
				</span>
                <a class="topline__link" href="/help/payment/">Оплата</a>
                <a class="topline__link" href="/help/delivery/">Доставка</a>
                <a class="topline__link" href="/info/faq/">Вопрос-ответ</a>
                <a class="topline__link" href="/company/partners/">Партнёрам</a>
                <a class="topline__link" href="/info/brands/">Бренды</a>
			</nav>
			<div class="h-user-block" id="personal_block">
				<div class="topline__auth-menu">
                    <div id="bxdynamic_iIjGFB_start" style="display:none"></div>
                    <div id="bxdynamic_iIjGFB_end" style="display:none"></div>
                </div>
            </div>
		</div>
	</div>
	<header class="header container">
		<div class="header__row row">
			<div class="col-item header-logo">
                <a class="header-logo__link" href="/">
                <img class="header-logo__img" src="/local/templates/main/img/logo.svg" alt="" width="180" height="46">
                </a>
			</div>
			<div class="col-item header-contacts contacts">
				<div class="contacts__top">
                    <div class="contacts__phone contacts__phone-moscow">
                    <a class="contacts__link" href="tel:<?php echo $_smarty_tpl->getVariable('config')->value['phone'];?>
" rel="nofollow"><?php echo $_smarty_tpl->getVariable('config')->value['phone'];?>
</a>
                </div>
            </div>
            <div class="contacts__bottom">
                <span class="contacts__timeRange">с 9:00 до 18:00</span>
            </div>
		</div>
        <form action="/catalog/" id="title-search" class="col-item header-search" >
            <input class="header-search__input input-text" id="title-search-input" type="text" name="q" value="" size="40" maxlength="50" autocomplete="off" placeholder="Поиск по сайту" />
            <button class="header-search__button icon icon-zoom" type="submit"></button>
            <input type="hidden" value="Поиск" class="button icon" />
        </form>
        <div class="col-item header-basket">
            <a class="header-basket__frame" href="/basket/">
                <span class="header-basket__baloon"><b>Для вашего региона:</b> <br><b>Минимальный заказ</b> - 10 000 руб. <br>Бесплатная доставка от 50 000 руб.</span>
                <span class="header-basket__cart">
                    <span class="header-basket__length"></span>
                </span>
                <span class="header-basket__info">
                    <span class="header-basket__text">Корзина</span>
                    <span class="header-basket__value">пуста</span>
                </span>
            </a>
        </div>
    </header>

	<div class="menu" id="menu">
		<div class="menu__container">
            <div class="menu-list">
                <a class="menu-list__item    " href="/catalog/new/"  >Новинки</a><div class="menu-list__item-wrapper">
                <a class="menu-list__item menu-list__item_actions" href="/catalog/actions/" >Акции</a>
                    <div class="menu-list__dropdown">
                        <div class="menu-actions ">
                            <ul class="menu-actions__list">
                                <li class="menu-actions__item"><a class="menu-actions__link" href="/catalog/actions/skidka_do_10_na_podguzniki_insinse/">
                                    Скидка до 10% на подгузники Insinse</a></li>
                                    <li class="menu-actions__item"><a class="menu-actions__link" href="/catalog/actions/skidki_do_30_na_sezonnye_kurtki/">Скидки до 30% на сезонные куртки</a></li>
                                    <li class="menu-actions__item"><a class="menu-actions__link" href="/catalog/actions/shapki_poshtuchno_po_super_tsene/">Шапки поштучно по супер-цене</a></li>
                                    <li class="menu-actions__item"><a class="menu-actions__link" href="/catalog/actions/shapki_optom_po_super_tsene/">Шапки оптом по супер-цене</a></li>
                                    <li class="menu-actions__item"><a class="menu-actions__link" href="/catalog/actions/skidka_30_na_vse_ekspress_tovary/">Скидка 30% на ВСЕ экспресс товары</a></li>
                                    <li class="menu-actions__item"><a class="menu-actions__link" href="/catalog/actions/goryachie_skidki/">Горячие скидки</a></li>
                            </ul>
                        </div>
                    </div>
            </div>
            <a class="menu-list__item    " href="/catalog/rasprodazha/"  >Распродажа</a>
            <a class="menu-list__item    " href="/services/fotouslugi/"  >Фотостудия</a>
            <a class="menu-list__item    " href="/services/warehouse-logistics"  >Складская логистика<span class="menu-list__item-new" title="Новинки">new</span></a>
        </div>
        </div>
        </div>

	<div class="container">
		<div class="row"></div>
     </div>
    </div>
    </div>
    </div>
</div>

	<div class="container l-goods-l">
<div class="row l-goods-l__header"><div class="col-item"><h1 class="title-h1">Мужские кроссовки</h1></div></div>
	
	<div class="row l-goods-l__section">
		<div class="col-item l-goods-l__filters">
			<div class="collapse filters-wrap" id="filters">
				<div id="bxdynamic_CxqOHg_start" style="display:none"></div><div class="urraa-loader urraa-loader-show"><div class="urraa-loader-curtain"></div></div><div id="bxdynamic_CxqOHg_end" style="display:none"></div>			</div>
		</div>
	<div class="col-item l-goods-l__goods ">
								<div class="row">
				<div class="col-item">
					<div class="goods-list__picture jsPromVM" id="bx_3685039667_1712997"  data-id="1712997" data-name="Finler" data-href="https://urraa.ru/catalog/shoes/adult/men/filter/brand-is-finler/apply/"  data-target="_self" >
						<a class="picture "
					   href="https://urraa.ru/catalog/shoes/adult/men/filter/brand-is-finler/apply/"
					   title="Finler"
					   target="_self"
					><img class="picture__image"
					 src="/upload/iblock/3d2/3d2cb6620742e850c1b9025cdc24f7f8.jpg"
					 alt="Finler"
					 title="Finler"></a>					</div>
				</div>
			</div>
								<div class="row">
				<div class="col-item">

					<div class="filter-line">
						<div class="filter-line__top">

								<div class="filter-line-tab filter-line__tab" id="tabs">
		<div class="filter-line-tab__drop" id="collapseTabs">
			<div class="filter-line-tab__list">
			<div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/" >Все товары</a></div><div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/adult/men/krossovki/filter/hit-is-novinki/apply/" >Новинки</a></div><div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/adult/men/krossovki/filter/hit-is-rasprodazha/apply/" >Распродажа</a></div><div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/kids/" >Детская</a></div><div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/adult/" >Взрослая</a></div><div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/ukhod_za_odezhdoy_i_obuvyu/" >Уход за обувью</a></div><div class="filter-line-tab__item"><a class="filter-line-tab__link" href="/catalog/shoes/adult/men/krossovki/filter/term_of_shipment-is-ekspress/apply/" >Экспресс-отгрузка</a></div>			</div>
		</div>
	</div>


							<div id="bxdynamic_QWlxgr_start" style="display:none"></div>																	<div class="filter-line-size filter-line__size">
										<div class="filter-line-size__title">Показывать по</div>
										<div class="filter-line-size__item"><a class="filter-line-size__link filter-line-size__link_active" href="/catalog/shoes/adult/men/krossovki/?show=20">20</a></div><div class="filter-line-size__item"><a class="filter-line-size__link" href="/catalog/shoes/adult/men/krossovki/?show=60">60</a></div><div class="filter-line-size__item"><a class="filter-line-size__link" href="/catalog/shoes/adult/men/krossovki/?show=100">100</a></div>									</div>
															<div id="bxdynamic_QWlxgr_end" style="display:none"></div>						</div>

						<div class="filter-line__bottom">
							<!--noindex-->
							<div id="bxdynamic_TIAvmK_start" style="display:none"></div>								<div class="filter-line-sort filter-line__sort" id="sort">
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
																					<div class="filter-line-sort__item">
												<a rel="nofollow"
												   href="/catalog/shoes/adult/men/krossovki/?sort=NAME&order=asc&PAGEN_1=2"
												   class="filter-line-sort__link filter-line-sort__link_down  desc NAME">По алфавиту</a>
											</div>
																					<div class="filter-line-sort__item">
												<a rel="nofollow"
												   href="/catalog/shoes/adult/men/krossovki/?sort=PRICE_BOX&order=desc&PAGEN_1=2"
												   class="filter-line-sort__link filter-line-sort__link_up  asc PRICE_BOX">По цене за уп.</a>
											</div>
																					<div class="filter-line-sort__item">
												<a rel="nofollow"
												   href="/catalog/shoes/adult/men/krossovki/?sort=PRICE&order=desc&PAGEN_1=2"
												   class="filter-line-sort__link filter-line-sort__link_up  asc PRICE">По цене за шт.</a>
											</div>
																			</div>
								</div>

                            <div class="addBookmark filter-line__view"></div>

								<div class="filter-line-view filter-line__view hidden">
																			<div class="filter-line-view__item"><a rel="nofollow" class="filter-line-view__link icon icon-sort-block filter-line-view__link_active" href="/catalog/shoes/adult/men/krossovki/?display=block&PAGEN_1=2" title="плиткой"></a></div>
																			<div class="filter-line-view__item"><a rel="nofollow" class="filter-line-view__link icon icon-sort-list " href="/catalog/shoes/adult/men/krossovki/?display=list&PAGEN_1=2" title="списком"></a></div>
																	</div>
							<div id="bxdynamic_TIAvmK_end" style="display:none"></div>							<!--/noindex-->
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
                        <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('moduletemplate')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
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

		<a class="arrow arrow_next arrow_navi" href="/catalog/shoes/adult/men/krossovki/?PAGEN_1=3"></a>	</div>
			<!-- pagination-container -->
	</div>
										<div id="bxdynamic_6FQJJ1_end" style="display:none"></div>
									</div>
			</div>

		<div class="l-goods-l__section-addon ">
                
			<div class="row">
			<div class="col-item">
				<div class="slider-tabs js-slider-tabs_goods" data-entity="container">
					<div class="slider-tabs__arrows">
						<div class="arrow arrow_slider arrow_prev"></div>
						<div class="arrow arrow_slider arrow_next"></div>
					</div>
					<div class="slider-tabs__tabs">
						<div class="slider-tabs__tabs">
																								<span class="slider-tabs__item-tabs " data-toggle="tab">Хиты продаж</span>
																													</div>
					</div>
					<div class="slider-tabs__pane">
						                            <form class="main_offrs_ajax_flag" >
                                <input type="hidden" name="tab_id" value="1000" />
                                <input type="hidden" name="tab_name" value="Хиты продаж" />
                                <input type="hidden" name="tab_code" value="MARKETING_POPULAR_SECTION" />
                                <input type="hidden" name="tab_product_id" value="" />
                                <input type="hidden" name="tab_section_id" value="350" />
                                <input type="hidden" name="tab_inline" value="4" />
                                <input type="hidden" name="tab_active" value="Y" />
                                <input type="hidden" name="tab_ga_list" value="CATALOG_SECTION_VIEWED" />
                                <input type="hidden" name="tmp_path" value="/local/templates/main/components/oorraa/main.offers/main_offers" />
                            </form>
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

    <footer class="footer">
        <div class="container">
            <div class="footer__top">
                <div class="footer__contacts contacts">
                    <div class="contacts__top">
                        <div class="contacts__phone">
                            <a class="contacts__link" href="tel:<?php echo $_smarty_tpl->getVariable('config')->value['phone'];?>
" rel="nofollow"><?php echo $_smarty_tpl->getVariable('config')->value['phone'];?>
</a>
                        </div>
                    </div>
                    <div class="contacts__bottom">
                        <span class="contacts__time">с 9:00 до 18:00</span>
                    </div>
                </div>
            </div>
            <div class="footer__bottom row">
                <div class="col-item footer__info footer-info">
                    <div class="footer-info__copyright">2018 &#169; ООО &laquo;Спорттовары&raquo; </div>
                    <div class="footer-info__cards">
                        <div class="footer-cards">
                            <img class="footer-cards__img" src="<?php echo $_smarty_tpl->getVariable('theme')->value['images'];?>
/credit/mastercard.svg" alt="" height="20">
                            <img class="footer-cards__img" src="<?php echo $_smarty_tpl->getVariable('theme')->value['images'];?>
/credit/visa.svg" alt="" height="12">
                            <img class="footer-cards__img" src="<?php echo $_smarty_tpl->getVariable('theme')->value['images'];?>
/credit/mir.svg" alt="" height="12">
                            <img class="footer-cards__img" src="<?php echo $_smarty_tpl->getVariable('theme')->value['images'];?>
/credit/mir-accept.svg" alt="" height="18">
                        </div>
                    </div>
                    <a class="footer-info__sitemap" href="/map/">Карта сайта</a>
                </div>
                
                <div class="col-item footer__social footer-social">
                    <a class="footer-social__item social icon-vk" href="//vk.com/oorraa" target="_blank" rel="nofollow"></a>
                    <a class="footer-social__item social icon-ok" href="//ok.ru/group/53471715328237" target="_blank" rel="nofollow"></a>
                    <a class="footer-social__item social icon-fb" href="//www.facebook.com/oorraamarketplace" target="_blank" rel="nofollow"></a>
                    <a class="footer-social__item social icon-ig" href="//www.instagram.com/urraa.ru/" target="_blank" rel="nofollow"></a>
                    <a class="footer-social__item social icon-gp" href="//plus.google.com/u/1/118433346833350316580" target="_blank" rel="nofollow"></a>
                    <div class="clearfix addBookmark addBookmarkMain"></div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>