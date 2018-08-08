<?php /* Smarty version Smarty3-RC3, created on 2018-08-08 15:05:52
         compiled from "dit:store;show-product" */ ?>
<?php /*%%SmartyHeaderCode:17932243675b6ac080ebb612-30785392%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e17a814b925bca02dc10d58783c3edd6b0d1bd1a' => 
    array (
      0 => 'dit:store;show-product',
      1 => 1533569770,
    ),
  ),
  'nocache_hash' => '17932243675b6ac080ebb612-30785392',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="container l-goods-i">
	<div class="row l-goods-i__row_title ga_container" data-list_name="CATALOG_DETAIL">
		<div class="col-item ga_item">
			<h1 class="title-h1"><?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
</h1>
		</div>
		<div class="col-item">
			<div class="goods-sticker">
				<div class="goods-sticker__item goods-sticker__item_factory">
					<b>Производитель: </b><a class="goods-sticker__link" href="#" title="<?php echo $_smarty_tpl->getVariable('prod')->value->fields['brand']->content;?>
" onclick="return false;"><?php echo $_smarty_tpl->getVariable('prod')->value->fields['brand']->content;?>
</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row l-goods-i__section" id="">
		<div class="col-item l-goods-i__frame" id="">
			<div class="goods-frame">
				<div class="goods-frame__share goods-share">
					<div class="goods-share__item goods-share__item_share js-share-drop" title="Поделиться">
						<div class="goods-share__popover popover bottom">
							<div class="arrow"></div>
							<div class="popover-content">
								<div id="yashare" data-services="vkontakte,facebook,odnoklassniki,moimir,twitter"></div>
							</div>
						</div>
					</div>
				</div>

				<div class="goods-frame__list-big" 
				data-entity="images-container" 
				style="background: url('') no-repeat center;">
					<div data-entity="image" 
					data-id="" 
					class="goods-frame__item-big product-item-detail-slider-image active">
						<a href="" title="Кроссовки мужские летние">
						<img src="http://sportlandshop.ru/content/media/product<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
/<?php echo $_smarty_tpl->getVariable('prod')->value->picture->fileid;?>
" alt="Кроссовки мужские летние" title="Кроссовки мужские летние" class="goods-frame__image-big" itemprop="image"></a>
					</div>
				</div>

				<div class="goods-frame__label goods-labels goods-frame__products_lables">
					<div class="goods-labels__list">
						<?php if ($_smarty_tpl->getVariable('prod')->value->fields['new']->content){?><div class="icon goods-labels__item goods-label goods-label_new goods-label_stock-persent" title="Новинки"></div><?php }?>
						<?php if ($_smarty_tpl->getVariable('prod')->value->fields['wholesale-discount-price']->content){?><div class="icon goods-labels__item goods-label goods-label_lg goods-label_stock-persent">Sale</div><?php }?>
					</div>
				</div>

				<div class="goods-frame__list-sml">
					<div class="product-item-detail-slider-controls-block" id="bx_117848907_1795201_slider_cont_1795203" style="display: ;">
						<?php  $_smarty_tpl->tpl_vars['picture'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('prod')->value->pictures; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['picture']->key => $_smarty_tpl->tpl_vars['picture']->value){
?>
							<div class="goods-frame__item-sml active" data-entity="slider-control" data-value="1795203_9675931">
								<img class="goods-frame__image-sml" src="http://sportlandshop.ru/content/media/thumbs/product<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
/<?php echo $_smarty_tpl->getVariable('picture')->value->fileid;?>
" alt="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_name;?>
">
							</div>
						<?php }} ?>
					</div>
				</div>
				<div class="modal fade lightbox-modal" id="lightbox">
					<div class="modal-close icon icon-cross lightbox-modal__close" data-dismiss="modal"></div>
					<div class="modal-dialog lightbox-modal__dialog">
						<div class="lightbox-modal__list"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-item l-goods-i__details l-goods-i__details_left">
			<div class="l-goods-i__block">
				<div class="goods-price">
					<div class="goods-price__offer">
						Оптом по <?php echo $_smarty_tpl->getVariable('boxQt')->value;?>
 шт.
						<span class="goods-price__hint">
							<span class="hint" data-toggle="tooltip" title="Скидки действуют при покупке на определенную сумму"></span>
							</span>
					</div>
					<!-- Цена за коробку -->
					<div class="goods-price__item">
						<?php if (!$_smarty_tpl->getVariable('prod')->value->fields['wholesale-discount-price']->content){?>
							<div class="goods-price__cost price">
								<span class="price__value" id="bx_117848907_1795201_urraa_price" style="font-size: 28px;"><?php echo $_smarty_tpl->getVariable('boxQt')->value*$_smarty_tpl->getVariable('prod')->value->fields['wholesale-price']->content;?>
</span> руб.
							</div>
						<?php }else{ ?>
							<div class="goods-price__cost price">
								<span class="price__value" id="bx_117848907_1795201_urraa_price" style="font-size: 28px;"><?php echo $_smarty_tpl->getVariable('boxQt')->value*$_smarty_tpl->getVariable('prod')->value->fields['wholesale-discount-price']->content;?>
</span> руб.
							</div>
							<div class="goods-price__cost goods-price__cost_old price price_old">
								<span class="price__value" id="bx_117848907_1795201_urraa_price_old"><?php echo $_smarty_tpl->getVariable('boxQt')->value*$_smarty_tpl->getVariable('prod')->value->fields['wholesale-price']->content;?>
</span> руб.
							</div>
						<?php }?>
						<div class="goods-price__for">Цена за кор.</div>
					</div>
					<!-- Цена за штуку/пару -->
					<div class="goods-price__item">
						<?php if (!$_smarty_tpl->getVariable('prod')->value->fields['wholesale-discount-price']->content){?>
							<div class="goods-price__cost goods-price__cost_single price">
								<span class="price__value" id="bx_117848907_1795201_urraa_price_piece"><?php echo $_smarty_tpl->getVariable('prod')->value->fields['wholesale-price']->content;?>
</span> руб.
							</div>
						<?php }else{ ?>
							<div class="goods-price__cost goods-price__cost_single price">
								<span class="price__value" id="bx_117848907_1795201_urraa_price_piece"><?php echo $_smarty_tpl->getVariable('prod')->value->fields['wholesale-discount-price']->content;?>
</span> руб.
							</div>
							<div class="goods-price__cost goods-price__cost_old-single price price_old">
								<span class="price__value" id="bx_117848907_1795201_urraa_price_piece_old"><?php echo $_smarty_tpl->getVariable('prod')->value->fields['wholesale-price']->content;?>
</span> руб.
							</div>
						<?php }?>
						<div class="goods-price__for">Цена за пару</div>
					</div>
				</div>
			</div>
			<div class="l-goods-i__block">
				<div class="info-text info-text_success">
					<span class="info-text__text">
						Стандартный срок отгрузки товара.
						<span class="hint" 
						data-toggle="tooltip" 
						data-original-title="Ориентировочный срок 
							отгрузки товара до 
							транспортной компании - 
							через 4-7 рабочих дней 
							после оплаты заказа."></span>
					</span>
				</div>
			</div>
			
			<div class="l-goods-i__block">
				<div class="l-goods-i__title">Состав коробки</div>
				<div class="goods-box">
					<table class="goods-box__table">
						<tbody>
							<tr class="goods-box__tr">
								<th class="goods-box__th">Размер</th>
								<?php  $_smarty_tpl->tpl_vars['cols'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['size'] = new Smarty_Variable;
 $_from = unserialize($_smarty_tpl->getVariable('prod')->value->fields['wholesale-size']->content); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['cols']->key => $_smarty_tpl->tpl_vars['cols']->value){
 $_smarty_tpl->tpl_vars['size']->value = $_smarty_tpl->tpl_vars['cols']->key;
?>
									<?php if ($_smarty_tpl->tpl_vars['cols']->value['checked']&&$_smarty_tpl->tpl_vars['cols']->value['value']){?>
										<td class="goods-box__td"><?php echo $_smarty_tpl->tpl_vars['size']->value;?>
</td>
									<?php }?>
								<?php }} ?>
							</tr>
							<tr class="goods-box__tr">
								<th class="goods-box__th">Кол-во</th>
								<?php  $_smarty_tpl->tpl_vars['cols'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['size'] = new Smarty_Variable;
 $_from = unserialize($_smarty_tpl->getVariable('prod')->value->fields['wholesale-size']->content); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['cols']->key => $_smarty_tpl->tpl_vars['cols']->value){
 $_smarty_tpl->tpl_vars['size']->value = $_smarty_tpl->tpl_vars['cols']->key;
?>
									<?php if ($_smarty_tpl->tpl_vars['cols']->value['checked']&&$_smarty_tpl->tpl_vars['cols']->value['value']){?>
										<td class="goods-box__td"><?php echo $_smarty_tpl->tpl_vars['cols']->value['value'];?>
</td>
									<?php }?>
								<?php }} ?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<!--noindex-->
			<div class="l-goods-i__block l-goods-i__cart-put-in product_actions" data-prod-id="<?php echo $_smarty_tpl->getVariable('prod')->value->prod_id;?>
" data-entity="main-button-container">
				<div id="busket-actions">
					<div class="l-goods-i__title">Количество кор.</div>
					<div class="goods__put">
						<div class="put to-cart-block">
							<div class="product-item-detail-info-container" data-entity="quantity-block">
								<div class="put__counter" data-toggle="tooltip" data-original-title="">

									<a class="put__arrow put__arrow_minus product-item-amount-field-btn-disabled" href="#" rel="nofollow">
									</a>

									<input class="put__input" name="quantity" type="tel" value="1" disabled="disabled">

									<a class="put__arrow put__arrow_plus product-item-amount-field-btn-disabled" href="#" rel="nofollow">
									</a>

								</div>
							</div>
							<div class="put__btn btn btn_primary btn_size_m product_add_to_basket_opt to-cart" id="bx_117848907_1795201_add_basket_link">В корзину</div>
						</div>
						<div class="l-goods-i__incart" style="display:none">
							<div class="l-goods-i__incart_res">
								<a class="l-goods-i__incart_basket" href="/store/order" rel="nofollow">
                                    <i class="icon icon-check"></i>
                                    В корзине <span class="l-goods-i__incart_basket_cnt">4 кор.</span>
                                </a>
								<a class="l-goods-i__incart_add-one" href="#"><i class="icon icon-plus"></i>1 кор.</a>
							</div>
							<a class="l-goods-i__incart_link_basket" href="/store/order">Перейти в корзину</a>
						</div>
					</div>
				</div>
			</div>
			<!--/noindex-->
		</div>
		<div class="col-item l-goods-i__details l-goods-i__details_right">
			<div class="clearfix addBookmark"><a class="link" href="" rel="sidebar">Добавить в закладки</a></div>
			<div class="l-goods-i__block hidden">
				<div class="rrc">
					<div class="rrc__col rrc__title">РРЦ</div>
					<div class="rrc__col rrc__text">Рекомендованная розничная цена</div>
					<div class="rrc__col rrc__cost"><span id="bx_117848907_1795201_urraa_price_rrp">####</span> руб.</div>
				</div>
			</div>
			<div class="l-goods-i__block">
				<div class="type-cost">
					<div class="type-cost__title">Типы цен
						<span class="type-cost__hint">
							<span class="hint" data-toggle="tooltip" title="Оптовая цена при покупке от определенной суммы"></span>
						</span>
					</div>
					<div class="type-cost__table">
						<div class="type-cost__row">
							<div class="type-cost__th">Сумма в корзине</div>
							<div class="type-cost__th">Цена за пару</div>
						</div>
                        <div class="type-cost__row type-cost__row_gray offer_content" 
						data-toggle="tooltip" 
						title="Белая цена: Если сумма в вашей корзине менее 20&nbsp;000&nbsp;руб., то цена за одну пар. будет составлять - <?php echo $_smarty_tpl->getVariable('prod')->value->fields['wholesale-price']->content;?>
&nbsp;руб.">
							<div class="type-cost__td">до 20&nbsp;000&nbsp;руб.</div>
							<div class="type-cost__td"><?php echo $_smarty_tpl->getVariable('prod')->value->fields['wholesale-price']->content;?>
&nbsp;руб.</div>
						</div>
                        <?php  $_smarty_tpl->tpl_vars['discount'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['limit'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('config')->value['store.discounts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['discount']->key => $_smarty_tpl->tpl_vars['discount']->value){
 $_smarty_tpl->tpl_vars['limit']->value = $_smarty_tpl->tpl_vars['discount']->key;
?>
                            <div class="type-cost__row type-cost__row_<?php echo $_smarty_tpl->tpl_vars['discount']->value['class'];?>
 offer_content" 
                            data-toggle="tooltip" 
                            title="<?php echo $_smarty_tpl->tpl_vars['discount']->value['title'];?>
: Если сумма в вашей корзине свыше <?php echo $_smarty_tpl->tpl_vars['discount']->value['value'];?>
 руб., то цена за одну пар. будет составлять - <?php echo floor($_smarty_tpl->tpl_vars['discount']->value['value']*$_smarty_tpl->getVariable('prod')->value->fields['wholesale-price']->content);?>
 руб.">
                                <div class="type-cost__td">от <?php echo $_smarty_tpl->tpl_vars['limit']->value;?>
&nbsp;руб.</div>
                                <div class="type-cost__td"><?php echo floor($_smarty_tpl->tpl_vars['discount']->value['value']*$_smarty_tpl->getVariable('prod')->value->fields['wholesale-price']->content);?>
 руб.</div>
                            </div>
                        <?php }} ?>
					</div>
				</div>
			</div>
		</div>

		<div class="col-item l-goods-i__tags">
		</div>

		<div class="col-item l-goods-i__advantages">
			<div class="advantages advantages_vertical">
				<div class="l-goods-i__advantages_wrap">
					<div class="advantages__item icon icon-truck-free">
						<div class="advantages__title">Доставка по всей России</div>
						<div class="advantages__text">А также в Республику Беларусь и Казахстан</div>
					</div>
					<div class="advantages__item icon icon-credit-cards">
						<div class="advantages__title">Оплата товаров банковской картой  или по счету</div>
						<div class="advantages__text">Оплачивайте покупки любым удобным для&nbsp;вас способом</div>
					</div>
					<div class="advantages__item icon icon-basket-one-five">
						<div class="advantages__title">Широкий  ассортимент  товаров</div>
						<div class="advantages__text">Более 900 брендов и около 50 000 наименований. Новинки каждый день!</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-item l-goods-i__tabs">
			<div class="tabs-goods">
				<ul class="tabs-goods__list">
					<li class="tabs-goods__item active"><a class="tabs-goods__link" href="#home" data-toggle="tab">Характеристики</a></li>
					<li class="tabs-goods__item"><a class="tabs-goods__link" href="#profile" data-toggle="tab">Описание</a></li>
				</ul>

				<div class="tabs-goods__content">
					<div class="tabs-goods__panel active" id="home">
						<?php echo $_smarty_tpl->getVariable('prod')->value->descr;?>

					</div>
					<div class="tabs-goods__panel" id="profile">
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="content" class="clearfix">
    <div class="content w1024">
        <div class="item-info">
            <?php if ($_smarty_tpl->getVariable('prod')->value->fields['new']->content){?>
                <div class="shild-left novinka_cart"></div>
            <?php }?>
            <?php if ($_smarty_tpl->getVariable('prod')->value->fields['club']->content){?>
                <div class="shild-left club_cart" onclick="return Good.scrollToClub();"></div>
            <?php }?>
            <?php if ($_smarty_tpl->getVariable('prod')->value->fields['sale']->content){?>
                <div class="shild-left skidka_ico_cart sale990"></div>
            <?php }?>
            <div class="item-photo owl-carousel owl-theme owl-center owl-loaded" style="visibility: hidden;">
                
            </div>
        </div>
    </div>
</div>