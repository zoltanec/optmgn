<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 14:29:55
         compiled from "dit:store;admin/toolbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8486865555b432b13653959-68810353%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d1ff36414651f697aa47af1ebd3b5d9a60ea056' => 
    array (
      0 => 'dit:store;admin/toolbar.tpl',
      1 => 1520075627,
    ),
  ),
  'nocache_hash' => '8486865555b432b13653959-68810353',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('user')->value->reqRights('view_store_categories')){?>
	<a href="<?php echo $_smarty_tpl->getVariable('run')->value['me'];?>
/edit-category/catid_0/">Категории</a>&nbsp;&nbsp;
<?php }?>
<?php if ($_smarty_tpl->getVariable('user')->value->reqRights('add_store_product')){?>
	<?php if (is_object($_smarty_tpl->getVariable('category')->value)){?>
		<a href="<?php echo $_smarty_tpl->getVariable('run')->value['me'];?>
/add-product/catid_<?php echo $_smarty_tpl->getVariable('category')->value->category_id;?>
/">Добавить товар в <?php echo $_smarty_tpl->getVariable('category')->value->category_name;?>
</a>
	<?php }else{ ?>
		<a href="<?php echo $_smarty_tpl->getVariable('run')->value['me'];?>
/add-product/catid_<?php echo $_smarty_tpl->getVariable('category')->value->category_id;?>
/">Добавить товар</a>
	<?php }?>
<?php }?>
&nbsp;&nbsp;
<a href="<?php echo $_smarty_tpl->getVariable('run')->value['me'];?>
/orders-archive/">Архив заказов</a>&nbsp;&nbsp;
<a href="<?php echo $_smarty_tpl->getVariable('run')->value['me'];?>
/add-order/">Добавить заказ</a>