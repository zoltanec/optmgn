<?php /* Smarty version Smarty3-RC3, created on 2018-08-27 21:49:02
         compiled from "dit:store;cart-widget" */ ?>
<?php /*%%SmartyHeaderCode:2534128315b842b7e451a65-41880712%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc7d76a088fa4e0451bdce529520234821c60dff' => 
    array (
      0 => 'dit:store;cart-widget',
      1 => 1535388466,
    ),
  ),
  'nocache_hash' => '2534128315b842b7e451a65-41880712',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable(Store_Cart::getCartSum(), null, null);?>
<div class="col-item header-basket">
	<a class="header-basket__frame" href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/store/order">
        <span class="header-basket__baloon"><b>Для вашего региона:</b> <br><b>Минимальный заказ</b> - 10 000 руб. <br>Бесплатная доставка от 50 000 руб.</span>
		<span class="header-basket__cart">
			<span class="header-basket__length"><?php if ($_smarty_tpl->getVariable('total')->value['total_cost']>0){?><?php echo $_smarty_tpl->getVariable('total')->value['total_quantity'];?>
<?php }?></span>
		</span>
		<span class="header-basket__info">

			<span class="header-basket__text">Корзина</span>
			<span class="header-basket__value"><?php if ($_smarty_tpl->getVariable('total')->value['total_cost']>0){?><?php echo $_smarty_tpl->getVariable('total')->value['total_cost'];?>
 руб.<?php }else{ ?>пуста<?php }?></span>
			<span class="header-basket__value"><?php if (count($_smarty_tpl->getVariable('cart')->value[1])>0){?><?php echo count($_smarty_tpl->getVariable('cart')->value[1]);?>
<?php }else{ ?>пуста<?php }?></span>
		</span>
	</a>
</div>
