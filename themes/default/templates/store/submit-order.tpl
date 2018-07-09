
                    
                    
                    
                    <div id="content" class="clearfix w100p pz">
				<script type="text/javascript" src="/component/ex/assets/url.min.js?v=1462528904"></script><script type="text/javascript" src="/component/ex/assets/jquery.kladr.min.js?v=1480409142"></script><link href="/component/ex/assets/trash.css?v=1519118653" rel="stylesheet" type="text/css"><link href="/component/ex/assets/order.css?v=1516166898" rel="stylesheet" type="text/css"><script type="text/javascript" src="/component/ex/assets/order.js?v=1517296715"></script><script type="text/javascript" src="/component/ex/assets/scrolltotop.js?v=1493191190"></script><link href="/theme/index/css/jquery.mCustomScrollbar.min.css?v=1456304480" rel="stylesheet" type="text/css"><script type="text/javascript" src="/theme/index/js/jquery.mCustomScrollbar.concat.min.js?v=1456304480"></script>					<div class="bl-wrapper-order--main">
						<div class="bl-wrapper-order--header">
						    <div class="bl-step--header">
								<a href="#" class="approve" onclick="return Order.step(1)">Данные</a>
								<a href="#" onclick="return Order.step(2)" class="approve">Доставка</a>
								<a href="#" onclick="return Order.step(3)" class="active">Оплата</a>
							</div>
							<div class="bl-label--header">
								Оформление заказа
							</div>
						</div>
						<div class="bl-wrapper-order--content">	<div class="bl-fix-height--wrapper">
		<table class="pay">
			<tbody><tr>
				<th class="tl pl30">Способ оплаты</th>
				<th class="tl col-700"></th>
				<th class="col-150">Выбрать</th>
			</tr>
												<tr class="item active" onclick="return Order.checkPay(7, this)">
						<td data-title="Способ оплаты" class="pay-method pl fl">WalletOne</td>
						<td data-title="Описание" class="pay-desc">банковские карты Visa, Mastercard, МИР</td>
						<td data-title="Выбрать" class="pay-choise"><span class="circle active"></span></td>
					</tr>
									</tbody></table>
		<div class="bl-pay-alert"></div>
		<div class="bl-detail-bottom">
			<div class="bl-detail-order-wrapper clearfix">
				<div class="bl-orient--right">
					<div class="head-text">Мой заказ</div>
					<div class="order-info">
																					<div class="line ">
									<span class="label">Итого стоимость товаров:</span>
									<span class="value">3 690 руб.</span>
								</div>
															<div class="line ">
									<span class="label">Доставка:</span>
									<span class="value">0 руб.</span>
								</div>
															<div class="line strong">
									<span class="label">Итого к оплате:</span>
									<span class="value">3 690 руб.</span>
								</div>
																		</div>
				</div>
			</div>
			<div class="bl-nav-bnt--wrapper clearfix">
				<div class="left-btn">
					<a href="#" onclick="return Order.step(2)">Назад</a>
				</div>
				<div class="right-btn">
					<a href="#" onclick="return Order.submit()">Оплатить</a>
				</div>
			</div>
		</div>
	</div>
	<div class="bl-bottom-note--wrapper">
		<p>*Нажав на кнопку "Оплатить", Вы будете перенаправлены на страницу оплаты</p>
	</div>
</div>
					</div>			</div>
                    
                    
              ///walletone.com


<div id="content" class="clearfix">
				<script type="text/javascript" src="/component/ex/assets/jquery.kladr.min.js?v=1480409142"></script><link href="/component/cabinet/assets/css/cabinet.css?v=1514281285" rel="stylesheet" type="text/css"><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css?v=1514281285" rel="stylesheet" type="text/css"><link href="/component/cabinet/assets/css/bootstrap.min.css?v=1464758478" rel="stylesheet" type="text/css"><link href="/component/cabinet/assets/css/cropper.min.css?v=1464758478" rel="stylesheet" type="text/css"><link href="/component/cabinet/assets/css/main.css?v=1464758478" rel="stylesheet" type="text/css"><script type="text/javascript" src="/component/cabinet/assets/js/bootstrap.min.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/cropper.min.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/main.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/inputmask.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/cabinet.js?v=1514281285"></script>			<div class="bl-cabinet--wrapper">
				<div class="bl-cabiner--header">
					<div class="title--cabinet">
						Личный кабинет
					</div>
					<div class="cabinet--tabs">
						<ul class="row tabs">
			            					<li onclick="return Cabinet.section('favorite');" data-section="favorite" class="">Избранное</li>				<li onclick="return Cabinet.section('sale');" data-section="sale" class="">Скидка</li>				<li onclick="return Cabinet.section('orders');" data-section="orders" class="active">Заказы</li>				<li class="" onclick="return Cabinet.section('main');" data-section="main">Данные</li>
			            </ul>
					</div>
					<div class="clear"></div>
				</div>
				<div class="bl-cabinet--content bl-content--wrapper"><div class="bl-cabinet-orders--wrapper">
	<table class="orders">
		<tbody>
			<tr>
				<th class="col-150">Номер заказа</th>
				<th class="col-150">Дата</th>
				<th class="tl pdl-40">Статус</th>
				<th class="col-120">Сумма</th>
			</tr>
												<tr class="item" onclick="return Cabinet.openOrder('7b3c30b3cce571faf0ec75ac38be2e83');">
						<td data-title="Номер заказа"><u>185005</u></td>
						<td data-title="Дата">09.04.2018</td>
						<td data-title="Статус" class="tl pdl-40">
							Ожидает оплаты
														<br>Заказ в резерве. Осталось только оплатить заказ в течение 60 минут.
						</td>
						<td data-title="Сумма">3 690 руб.</td>
					</tr>
									</tbody>
	</table>
</div></div>
			</div>			</div>


              

<div id="content" class="clearfix">
				<script type="text/javascript" src="/component/ex/assets/jquery.kladr.min.js?v=1480409142"></script><link href="/component/cabinet/assets/css/cabinet.css?v=1514281285" rel="stylesheet" type="text/css"><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css?v=1514281285" rel="stylesheet" type="text/css"><link href="/component/cabinet/assets/css/bootstrap.min.css?v=1464758478" rel="stylesheet" type="text/css"><link href="/component/cabinet/assets/css/cropper.min.css?v=1464758478" rel="stylesheet" type="text/css"><link href="/component/cabinet/assets/css/main.css?v=1464758478" rel="stylesheet" type="text/css"><script type="text/javascript" src="/component/cabinet/assets/js/bootstrap.min.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/cropper.min.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/main.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/inputmask.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/cabinet.js?v=1514281285"></script>			<div class="bl-cabinet--wrapper">
				<div class="bl-cabiner--header">
					<div class="title--cabinet">
						Личный кабинет
					</div>
					<div class="cabinet--tabs">
						<ul class="row tabs">
			            					<li onclick="return Cabinet.section('favorite');" data-section="favorite" class="">Избранное</li>				<li onclick="return Cabinet.section('sale');" data-section="sale" class="active">Скидка</li>				<li onclick="return Cabinet.section('orders');" data-section="orders" class="">Заказы</li>				<li class="" onclick="return Cabinet.section('main');" data-section="main">Данные</li>
			            </ul>
					</div>
					<div class="clear"></div>
				</div>
				<div class="bl-cabinet--content bl-content--wrapper"><div class="bl-cabinet-sale--wrapper">
	<div class="bl-info_block--wrapper">
					<p><strong>У Вас пока нет скидки</strong></p>
			<p>Чтобы получить скидку достаточно совершить одну покупку на нашем сайте, и после поступления оплаты за заказ Вы станете участником клубной</p>
			<p>программы. Размер скидки назначается в зависимости от суммы покупок на сайте.</p>
			</div>
	<div class="bl-content--card">
		<div class="separate"></div>
		<p><img src="/theme/index/images/exclam.png">Скидка закрепляется за Вашей учетной записью на сайте, с которой был оформлен и выкуплен заказ.</p>
					<p><img src="/theme/index/images/exclam.png">Сумма покупок на сайте по разным учетным записям не объединяется.</p>
			<div class="separate"></div>
			<p style="padding-left: 30px;">С подробной информацией по клубной программе Вы можете ознакомиться <a href="/programma">здесь</a></p>
			<p style="padding-left: 30px;">Если у Вас возникли вопросы по сумме накоплений и клубной программе - обратитесь к операторам контакт-центра.</p>
			</div>
</div></div>
			</div>			</div>

              

              
<div id="content" class="clearfix">
				<script type="text/javascript" src="/component/ex/assets/jquery.kladr.min.js?v=1480409142"></script><link href="/component/cabinet/assets/css/cabinet.css?v=1514281285" rel="stylesheet" type="text/css"><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css?v=1514281285" rel="stylesheet" type="text/css"><link href="/component/cabinet/assets/css/bootstrap.min.css?v=1464758478" rel="stylesheet" type="text/css"><link href="/component/cabinet/assets/css/cropper.min.css?v=1464758478" rel="stylesheet" type="text/css"><link href="/component/cabinet/assets/css/main.css?v=1464758478" rel="stylesheet" type="text/css"><script type="text/javascript" src="/component/cabinet/assets/js/bootstrap.min.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/cropper.min.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/main.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/inputmask.js?v=1464758478"></script><script type="text/javascript" src="/component/cabinet/assets/js/cabinet.js?v=1514281285"></script>			<div class="bl-cabinet--wrapper">
				<div class="bl-cabiner--header">
					<div class="title--cabinet">
						Личный кабинет
					</div>
					<div class="cabinet--tabs">
						<ul class="row tabs">
			            					<li class="active" onclick="return Cabinet.section('favorite');" data-section="favorite">Избранное</li>				<li onclick="return Cabinet.section('sale');" data-section="sale">Скидка</li>				<li onclick="return Cabinet.section('orders');" data-section="orders">Заказы</li>				<li onclick="return Cabinet.section('main');" data-section="main">Данные</li>
			            </ul>
					</div>
					<div class="clear"></div>
				</div>
				<div class="bl-cabinet--content bl-content--wrapper">
					    <div class="bl-cabinet-favorite--wrapper">
        <div class="bl-attention__cab_favorite--wrapper">
            <img src="/lib/Favorite/assets/img/attention.svg">
            <span>Товар в избранном не резервируется, его могут выкупить в любой момент.</span>
        </div>
        <div class="catalogue">
            <div class="icat">
                				<a href="/catalogue/obuv/muzhskaya/krossovki-adidas-terrex-fastshell-2-0_11106.html">
					<div class="photos ">
															<div class="photo p1 current"><div class="timg"><img src="/goodsimg/00000011036/~1DSC_1276.jpg__small__.jpg" alt="Кроссовки Adidas Terrex Fastshell 2.0"></div><span></span></div>									<div class="photo p2"><div class="timg"><img src="/goodsimg/00000011036/2DSC_1279.jpg__small__.jpg" alt="Кроссовки Adidas Terrex Fastshell 2.0"></div><span></span></div>									<div class="photo p3"><div class="timg"><img src="/goodsimg/00000011036/5DSC_4897.jpg__small__.jpg" alt="Кроссовки Adidas Terrex Fastshell 2.0"></div><span></span></div>
						<div class="novinka skidka_prew"></div>
						<div class="bl-favorite__cabinet__link--wrapper">
    <span onclick="return FireFavorite.event(10238, 'cabinet', 'remove');"><img src="/lib/Favorite/assets/img/close.svg"></span>
</div>

					</div>
					<div class="name">
											<b>Adidas</b>
					<div class="upp">Terrex Fastshell 2.0</div>
					
					<b>3290 руб.</b>
					
					</div>
									<div class="size">
					<span>Размеры в наличии:</span>
					40 | 41 | 42 | 43 | 44
				</div>
					
				</a>
            </div>
        </div>
    </div>

				</div>
			</div>			</div>              
              
              
              
              
              
              
              
              
              
              
              
              
              
<div class="pull">
 <br><br><br>
 <div id="order_sucessfull">
  <div id="os_img_ok"></div>
  <div id="os_title">Ваш заказ принят</div>
  <div id="os_discr">В течении 10 минут вам позвонит оператор для подтверждения заказа.
  <br><br><br><br><br>Также, у оператора вы можете заказать пиво и закуски с нашего второго сайта:</div>
  <br><br>
  <a href="http://pivoprovod.com/"><img src="<{$theme.images}>/pivoprovod_mini.png"></a><br><br>
  <a class="static_link" href="http://pivoprovod.com/">www.pivoprovod.com</a>
 </div>
 <br><br><br><br><br><br><br><br><br><br><br><br>
</div>