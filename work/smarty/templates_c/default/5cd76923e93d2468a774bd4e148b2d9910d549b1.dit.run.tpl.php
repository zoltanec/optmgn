<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 14:29:55
         compiled from "dit:run.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3533814075b432b13616205-37744126%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5cd76923e93d2468a774bd4e148b2d9910d549b1' => 
    array (
      0 => 'dit:run.tpl',
      1 => 1520075627,
    ),
  ),
  'nocache_hash' => '3533814075b432b13616205-37744126',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value->jscripts_path;?>
/<?php echo $_smarty_tpl->getVariable('run')->value['module'];?>
.functions.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value->jscripts_path;?>
/admin/<?php echo $_smarty_tpl->getVariable('run')->value['module'];?>
.functions.js"></script>
<link href="<?php echo $_smarty_tpl->getVariable('theme')->value['css'];?>
/admin/<?php echo $_smarty_tpl->getVariable('run')->value['module'];?>
.css" rel="stylesheet" type="text/css">

<div class="adm_toolbar"><?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('module_toolbar')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?></div>

<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('run_template')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
