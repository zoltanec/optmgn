<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>
        <{if $meta.title}>
            <{$meta.title}>
        <{else}>
            Интернет-магазин кроссовок и спортивной одежды sportlopt
        <{/if}>
    </title>
    <meta name="keywords" content="Мужские кроссовки, недорого купить оптом от производителя в Москве, интернет-магазин кроссовок, sportlopt.ru" />
    <meta name="description" content="Интернет-магазин sportlopt предлагает оптом широкий ассортимент качественной мужской обуви от производителя.
        У нас на сайте вы можете дешево купить мужские кроссовки по низкой цене. 
        В наличии большой выбор моделей. Бесплатная доставка по России, в Республику Беларусь и Казахстан.
        Гарантия качества. Наш телефон: <{$config.phone}>" />
    <link href="<{$theme.css}>/core.css" rel="stylesheet" type="text/css"/>
	<{$tpl->getJsHeaders('full')}>
</head>
<body class=" page-inner">
	<script type="text/javascript" src="<{$config->jscripts_path}>/store.functions.js"></script>
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
                <a class="topline__link" href="/company/partners/">Оптовикам</a>
                <a class="topline__link" href="/info/brands/">Организаторам СП</a>
				<a class="topline__link" href="/info/brands/">Дропшипинг</a>
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
                    <a class="contacts__link" href="tel:<{$config.phone}>" rel="nofollow"><{$config.phone}></a>
					</div>
                </div>
            </div>
            <div class="contacts__bottom">
                <span class="contacts__timeRange">с 9:00 до 18:00</span>
            </div>
			<form action="/catalog/" id="title-search" class="col-item header-search" >
				<input class="header-search__input input-text" id="title-search-input" type="text" name="q" value="" size="40" maxlength="50" autocomplete="off" placeholder="Поиск по сайту" />
				<button class="header-search__button icon icon-zoom" type="submit"></button>
				<input type="hidden" value="Поиск" class="button icon" />
			</form>
			<{include file='store;cart-widget'}>
		</div>
    </header>

	<div class="menu" id="menu">
		<div class="menu__container">
            <div class="menu-list">
                <a class="menu-list__item " href="<{$me.www}>/store/category/manfootwear">Кроссовки мужские</a>
				<div class="menu-list__item-wrapper">
					<a class="menu-list__item menu-list__item_actions" href="<{$me.www}>/store/category/womenfootwear" >Кроссовки женские</a>
					<div class="menu-list__dropdown">
						<div class="menu-actions ">
							<ul class="menu-actions__list">
								<li class="menu-actions__item">
									<a class="menu-actions__link" href="">Скидка до 10% на подгузники Insinse</a></li>
								<li class="menu-actions__item">
									<a class="menu-actions__link" href="">Скидки до 30% на сезонные куртки</a></li>
								<li class="menu-actions__item">
									<a class="menu-actions__link" href="">Шапки поштучно по супер-цене</a></li>
								<li class="menu-actions__item">
									<a class="menu-actions__link" href="">Шапки оптом по супер-цене</a></li>
								<li class="menu-actions__item">
									<a class="menu-actions__link" href="">Скидка 30% на ВСЕ экспресс товары</a></li>
								<li class="menu-actions__item">
									<a class="menu-actions__link" href="">Горячие скидки</a></li>
							</ul>
						</div>
					</div>
				</div>
            <a class="menu-list__item " href="<{$me.www}>/store/category/childrenfootwear">Детские кроссовки</a>
            <a class="menu-list__item " href="<{$me.www}>/store/category/manwear">Мужская одежда</a>
			<a class="menu-list__item " href="<{$me.www}>/store/category/womenwear">Женская одежда</a>
            <a class="menu-list__item " href="<{$me.www}>/store/category/accessories">Сумки и рюкзаки</a>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row"></div>
	</div>


	<{include file=$moduletemplate}>


    <footer class="footer">
        <div class="container">
            <div class="footer__top">
                <div class="footer__contacts contacts">
                    <div class="contacts__top">
                        <div class="contacts__phone">
                            <a class="contacts__link" href="tel:<{$config.phone}>" rel="nofollow"><{$config.phone}></a>
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
                            <img class="footer-cards__img" src="<{$theme.images}>/credit/mastercard.svg" alt="" height="20">
                            <img class="footer-cards__img" src="<{$theme.images}>/credit/visa.svg" alt="" height="12">
                            <img class="footer-cards__img" src="<{$theme.images}>/credit/mir.svg" alt="" height="12">
                            <img class="footer-cards__img" src="<{$theme.images}>/credit/mir-accept.svg" alt="" height="18">
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