<?php /* Smarty version Smarty3-RC3, created on 2018-07-09 14:29:52
         compiled from "dit:admin;main" */ ?>
<?php /*%%SmartyHeaderCode:11411278115b432b1053cb36-71478578%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '68d4254ee2e23eb546e5d7ad7546eec26baaab19' => 
    array (
      0 => 'dit:admin;main',
      1 => 1527781480,
    ),
  ),
  'nocache_hash' => '11411278115b432b1053cb36-71478578',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin site</title>

<link href="<?php echo $_smarty_tpl->getVariable('theme')->value['admin']['css'];?>
/admin.css" rel="stylesheet" type="text/css" />
<?php echo $_smarty_tpl->getVariable('tpl')->value->getCssHeaders();?>

<?php echo $_smarty_tpl->getVariable('tpl')->value->getJsHeaders();?>


<script type="text/javascript">
		var D = new D({www: '<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
', context: 'admin'});
		var siteVars = new function() {
    		this.path = '<?php echo $_smarty_tpl->getVariable('me')->value['path'];?>
';
    		this.images = '<?php echo $_smarty_tpl->getVariable('theme')->value['images'];?>
';
    		this.mimages = '<?php echo $_smarty_tpl->getVariable('theme')->value['mimages'];?>
';
    		this.www = '<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
';
		};
		function toggleEditor(id) {
		    	if (!tinyMCE.get(id))
		   			tinyMCE.execCommand('mceAddControl', false, id);
		    	else
		    	   	tinyMCE.execCommand('mceRemoveControl', false, id);
		}
		//tinyMCE.init({relative_urls: 0,	convert_urls: 0, mode : "specific_textareas",  editor_selector : "cms_rich", theme : "advanced", theme_advanced_toolbar_location : "top", plugins: "table", elements: "rich"});
		</script>

		<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value->jscripts_path;?>
/admin.functions.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value->jscripts_path;?>
/core/upload.functions.js"></script>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/core/get-javascript-translates/"></script>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value->jscripts_path;?>
/core.functions.js"></script>
</head>

<body>
<div id="admin_notification_block"></div>

<div id="header">
 <div id="header_name">
   <span id="header_name_title">Сайт <a target="_blank" href="<?php echo $_smarty_tpl->getVariable('me')->value['www'];?>
/">&laquo;<?php echo $_smarty_tpl->getVariable('config')->value->site_name;?>
&raquo;</a> <span>Панель управления администратора</span></span>
   <div id="header_name_quit">
    <span>Вы:<span id="admin_name"><?php echo $_smarty_tpl->getVariable('user')->value->username;?>
</span></span>
    <div id="quit"></div>
   </div>
 </div>
 <div id="header_menu">
  <a target="_blank" href="http://dinix.ru/" ><div id="dinix_logo"></div></a>
  <ul>
   <?php if ($_smarty_tpl->getVariable('user')->value->reqRights('site_control')){?><li onclick="document.location.href='<?php echo $_smarty_tpl->getVariable('me')->value['path'];?>
/index/';" class="menu_buttons">Управление сайтом</li><?php }?>
 <?php  $_smarty_tpl->tpl_vars['menu_item'] = new Smarty_Variable;
 $_from = Admin_MenuItem::getActiveMenus(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['menu_item']->key => $_smarty_tpl->tpl_vars['menu_item']->value){
?>
  	<?php if ($_smarty_tpl->getVariable('user')->value->reqRights($_smarty_tpl->getVariable('menu_item')->value->object_id())){?>
    	<li onclick="document.location.href='<?php echo $_smarty_tpl->getVariable('me')->value['path'];?>
/<?php echo $_smarty_tpl->getVariable('menu_item')->value->uri;?>
';" class="menu_buttons"><?php echo $_smarty_tpl->getVariable('menu_item')->value->menu_name;?>
</li>
    <?php }?>
  <?php }} ?>
  </ul>
 </div>
</div>

<div>
<div class="cms_admin_breadcrumbs" style="padding: 20px;">
	<?php  $_smarty_tpl->tpl_vars['breadcrumb'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('tpl')->value->getBreadCrumbs(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['breadcrumb']->key => $_smarty_tpl->tpl_vars['breadcrumb']->value){
?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['breadcrumb']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['breadcrumb']->value['name'];?>
</a> <span>&rarr;</span>
	<?php }} ?>
</div>
<div id="content">
  <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('moduletemplate')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
</div>
</body>
</html>
