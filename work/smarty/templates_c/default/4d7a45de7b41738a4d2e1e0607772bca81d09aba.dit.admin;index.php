<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 14:29:52
         compiled from "dit:admin;index" */ ?>
<?php /*%%SmartyHeaderCode:5774154775b432b10651d93-77172017%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4d7a45de7b41738a4d2e1e0607772bca81d09aba' => 
    array (
      0 => 'dit:admin;index',
      1 => 1520075627,
    ),
  ),
  'nocache_hash' => '5774154775b432b10651d93-77172017',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1>Добро пожаловать на главную страницу системы управления сайтом dCMS</h1>

<?php if ($_smarty_tpl->getVariable('user')->value->reqRights('god')){?>
<ul>
 <li><a href="<?php echo $_smarty_tpl->getVariable('me')->value['path'];?>
/run/core/list-modules/">Список доступных модулей системы</a></li>
 <li><a href="<?php echo $_smarty_tpl->getVariable('me')->value['path'];?>
/menu-items/">Управление меню администраторской панели</a></li>
 <li><a href="<?php echo $_smarty_tpl->getVariable('me')->value['path'];?>
/run/core/entity.index">Управление информационными блоками</a></li>
 <li><a href="<?php echo $_smarty_tpl->getVariable('me')->value['path'];?>
/run/core/entity.add-module">Добавление нового модуля</a></li>
</ul>
<?php }?>

