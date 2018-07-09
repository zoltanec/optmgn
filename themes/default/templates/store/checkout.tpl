<div id="content" class="clearfix w100p pz">
    <link href="<{$theme.css}>/catalog/trash.css" rel="stylesheet" type="text/css"/>
    <link href="<{$theme.css}>/catalog/order.css" rel="stylesheet" type="text/css"/>
    <link href="<{$config->jscripts_path}>/theme/jquery.mCustomScrollbar.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/scrolltotop.js"></script>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="<{$config->jscripts_path}>/theme/catalog/order.js"></script>
    <div class="bl-wrapper-order--main">
        <div class="bl-wrapper-order--header">
            <div class="bl-step--header">
                <a href="#" class="approve" onclick="return Order.step(1)" class="active">Данные</a>
                <a href="#" onclick="return Order.step(2)">Доставка</a>
                <a href="#" onclick="return Order.step(3)">Оплата</a>
            </div>
            <div class="bl-label--header">
                Оформление заказа
            </div>
        </div>
        <div class="bl-wrapper-order--content">
            <{include file="store;`$step`"}>
        </div>
	</div>
</div>
