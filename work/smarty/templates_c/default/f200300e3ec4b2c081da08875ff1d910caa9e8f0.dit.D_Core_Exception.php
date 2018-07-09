<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 14:12:33
         compiled from "dit:core;exceptions/D_Core_Exception" */ ?>
<?php /*%%SmartyHeaderCode:248107355b432701c869b4-66819805%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f200300e3ec4b2c081da08875ff1d910caa9e8f0' => 
    array (
      0 => 'dit:core;exceptions/D_Core_Exception',
      1 => 1520075626,
    ),
  ),
  'nocache_hash' => '248107355b432701c869b4-66819805',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
Error: C<?php echo $_smarty_tpl->getVariable('t')->value['e']->getCode();?>
<br>
Exception: <?php echo $_smarty_tpl->getVariable('t')->value['e']->getMessage();?>


<div class="cms_exception_dump">
<?php if (method_exists($_smarty_tpl->getVariable('e')->value,'renderTrace')){?>
	<?php echo $_smarty_tpl->getVariable('e')->value->renderTrace();?>

<?php }else{ ?>
	<?php echo var_dump($_smarty_tpl->getVariable('e')->value);?>

<?php }?>
</div>