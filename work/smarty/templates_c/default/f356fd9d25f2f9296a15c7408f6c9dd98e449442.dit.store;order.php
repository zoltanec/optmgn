<?php /* Smarty version Smarty3-RC3, created on 2018-08-08 17:40:12
         compiled from "dit:store;order" */ ?>
<?php /*%%SmartyHeaderCode:15659226695b6ae4ac3b7903-71493951%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f356fd9d25f2f9296a15c7408f6c9dd98e449442' => 
    array (
      0 => 'dit:store;order',
      1 => 1533571642,
    ),
  ),
  'nocache_hash' => '15659226695b6ae4ac3b7903-71493951',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="container">
	<div class="row ">
		<div class="col-item">
			<h1 class="title-h1">Корзина</h1>
		</div>
	</div>
</div>
<div class="container l-cart">
	<?php if ($_smarty_tpl->getVariable('cart')->value){?>
    <div id="basket-replace">
			<div class="row">
				<div class="col-item">
					<div class="tabs-cart l-cart__tabs">
						<div class="tabs-cart__list l-cart__tabs-list basket_sort">
							<div class="tabs-cart__item  wrap_li active" item-section="AnDelCanBuy" data-hash="tab_AnDelCanBuy" data-type="AnDelCanBuy">
								<a class="tabs-cart__link" href="">
									Готовые к заказу (<span id="basket_ready_product-cnt">5</span>)
								</a>
							</div>
							<div class="tabs-cart__item  wrap_li tabs-cart__item-delay hidden ">
								<a class="tabs-cart__link" href="/basket/delayed/"> 
									Избранные (<span id="basket_delay_product-cnt">0</span>)
								</a>
							</div>
							<div class="remove_all_basket tabs-cart__close btn btn_size_xs icon icon-cross button grey_br transparent AnDelCanBuy cur">
									Очистить
							</div>
						</div>
                        
                        <div class="system-message notetext info-block info-block_info">
                            <div class="text">
                                <p class="info-block__string">
                                    <b class="text text--bold">Тип Вашей цены - <span class="price-type"><?php echo $_smarty_tpl->getVariable('config')->value['store.discounts']['20 000']['title'];?>
</span>.</b></p>
                                <p class="info-block__string">Общая сумма в Вашей корзине: <span class="text text--orange"><?php echo $_smarty_tpl->getVariable('cart_total')->value['total_cost'];?>
 руб.</span></p>
                            </div>
                        </div>
                        <div class="tabs-cart__content l-cart__tabs-content">
                            <div class="tabs-cart__panel active" id="AnDelCanBuy">
                                <span class="basket_product_type_delay hidden" data-val="N"></span>
                                <table class="cart-table">
                                    <tbody>
                                    <tr class="cart-table__tr">
                                        <th class="cart-table__th"></th>
                                        <th class="cart-table__th">Наименование</th>
                                        <th class="cart-table__th">Цена за единицу</th>
                                        <th class="cart-table__th">Цена за упаковку/короб</th>
                                        <th class="cart-table__th cart-table__th_center">Количество</th>
                                        <th class="cart-table__th">Сумма</th>
                                        <th class="cart-table__th"></th>
                                    </tr>
                                    <?php  $_smarty_tpl->tpl_vars['pack'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['pack_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('cart')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pack']->key => $_smarty_tpl->tpl_vars['pack']->value){
 $_smarty_tpl->tpl_vars['pack_id']->value = $_smarty_tpl->tpl_vars['pack']->key;
?>
                                        <?php $_smarty_tpl->tpl_vars['pack_summ'] = new Smarty_variable(0, null, null);?>
                                        <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['hash'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['pack']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value){
 $_smarty_tpl->tpl_vars['hash']->value = $_smarty_tpl->tpl_vars['data']->key;
?>
                                            <?php if ($_smarty_tpl->tpl_vars['data']->value['visible']){?>
                                                <?php $_smarty_tpl->tpl_vars['prod_id'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['prod_id'], null, null);?>
                                                <?php $_smarty_tpl->tpl_vars['prod'] = new Smarty_variable(D_Core_Factory::Store_Product($_smarty_tpl->getVariable('prod_id')->value), null, null);?>
                                                <?php $_template = new Smarty_Internal_Template('store;order-content', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
                                            <?php }?>
                                        <?php }} ?>
                                    <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="system-message notetext info-block info-block_info">
                                <div class="text">В&nbsp;Вашей корзине находятся товары со&nbsp;стандартным сроком отгрузки. 
                                    Отгрузка Вашего заказа будет осуществлена через 4-7 рабочих дня после оплаты заказа.</div>
                            </div>        
                        </div>
					</div>
				</div>
			</div>
			<div class="row row_ver_sm l-cart__row-total">
				<!-- Сумма -->

				<div class="col-item order-total order-total_all">
					<table>
						<tbody>
                            <tr>
								<td class="order-total__td content"></td>
								<td class="order-total__td l-index__content info-td_economy">
									<strike><?php echo $_smarty_tpl->getVariable('cart_total')->value['total_cost'];?>
 руб.</strike>
								</td>
							</tr>
							<tr>
								<td class="order-total__td content">
									Скидка за объем:
								</td>
								<td class="order-total__td info-td_economy">
									19&nbsp;020.14 руб.
								</td>
							</tr>
							<tr>
								<td class="order-total__td content">
									<span class="info-label_economy info-label_economy_title">Экономия:</span>
								</td>
								<td class="order-total__td info-td_economy" colspan="2">
									<span class="info-label_economy info-label_economy_value">19&nbsp;020.14 руб.</span>
								</td>
							</tr>
														<tr>
							<td class="order-total__td content" rowspan="1">
								<div class="h6">Итого:</div>
							</td>
							<td class="order-total__td info-td_economy">
								<div class="price"><span class="price__value">462&nbsp;668.64</span> руб.
								</div>
							</td>
						</tr>
					</tbody></table>
				</div>
			</div>
						
			<!-- Продолжить покупки / Оформить заказ -->
			<div class="row">
				<div class="col-item">
					<div class="btn-line btn-line_right btn-line_border">
						<a class="btn btn_size_m" href="/catalog/">Продолжить покупки</a>
						<div class="btn btn_primary btn_size_m submitBasket" data-text="Начало оформления заказа">Оформить заказ</div>
					</div>
				</div>
			</div>
		</form>
	</div>
    <?php }else{ ?>
        <div class="row">
            <div class="col-item">
                <div class="tabs-cart l-cart__tabs">
                    <div class="tabs-cart__list l-cart__tabs-list basket_sort">
                        <div class="tabs-cart__item  wrap_li active" item-section="AnDelCanBuy" data-hash="tab_AnDelCanBuy" data-type="AnDelCanBuy">
                            <a class="tabs-cart__link" href="#">
                                Готовые к заказу (<span id="basket_ready_product-cnt">0</span>)
                            </a>
                        </div>

                        <div class="tabs-cart__item  wrap_li tabs-cart__item-delay  ">
                            <a class="tabs-cart__link" href="#"> 
                                Избранные (<span id="basket_delay_product-cnt">0</span>)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-item content">
                <img class="pull-left margin_right_20 margin_bottom_10" src="/local/templates/main/images/empty_cart.png" alt="">
                <h3>К сожалению, ваша корзина пуста</h3>
                <p>Исправить это недоразумение очень просто:&nbsp;<a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
">выберите в магазине</a> интересующий товар и нажмите кнопку «В корзину».</p>
                <a class="btn btn_size_s btn_primary margin_top_20">Вернуться</a>
            </div>
        </div>
    <?php }?>
</div>
<?php if ($_smarty_tpl->getVariable('cart')->value){?>
	<div class="bl-trash--footer">
		<div class="btn_back">
			<a href="javascript: window.history.back();">Назад</a>
		</div>
		<div class="step_order_form">
			<div class="summ-trash">
				<span class="label">Стоимость товаров:</span>
				<span class="value_sum"> руб.</span>
			</div>
			<a href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/checkout">Оформить заказ</a>
		</div>
	</div>
<?php }?>

