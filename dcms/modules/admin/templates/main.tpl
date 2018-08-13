<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin site</title>

<link href="<{$theme.admin.css}>/admin.css" rel="stylesheet" type="text/css" />
<{$tpl->getCssHeaders()}>
<{$tpl->getJsHeaders()}>

<script type="text/javascript">
		var D = new D({www: '<{$me.www}>', context: 'admin'});
		var siteVars = new function() {
    		this.path = '<{$me.path}>';
    		this.images = '<{$theme.images}>';
    		this.mimages = '<{$theme.mimages}>';
    		this.www = '<{$me.www}>';
		};
		function toggleEditor(id) {
		    	if (!tinyMCE.get(id))
		   			tinyMCE.execCommand('mceAddControl', false, id);
		    	else
		    	   	tinyMCE.execCommand('mceRemoveControl', false, id);
		}
		//tinyMCE.init({relative_urls: 0,	convert_urls: 0, mode : "specific_textareas",  editor_selector : "cms_rich", theme : "advanced", theme_advanced_toolbar_location : "top", plugins: "table", elements: "rich"});
		</script>

		<script type="text/javascript" src="<{$config->jscripts_path}>/admin.functions.js"></script>
        <script type="text/javascript" src="<{$config->jscripts_path}>/core/upload.functions.js"></script>
		<script type="text/javascript" src="<{$me.www}>/core/get-javascript-translates/"></script>
		<script type="text/javascript" src="<{$config->jscripts_path}>/core.functions.js"></script>
</head>

<body>
<div id="admin_notification_block"></div>

<div id="header">
 <div id="header_name">
   <span id="header_name_title">Сайт <a target="_blank" href="<{$me.www}>/">&laquo;<{$config->site_name}>&raquo;</a> <span>#ADMIN_CONTROL_PANEL#</span></span>
   <div id="header_name_quit">
    <span>Вы:<span id="admin_name"><{$user->username}></span></span>
    <div id="quit"></div>
   </div>
 </div>
 <div id="header_menu">
  <a target="_blank" href="http://dinix.ru/" ><div id="dinix_logo"></div></a>
  <ul>
   <{if $user->reqRights('site_control')}><li onclick="document.location.href='<{$me.path}>/index/';" class="menu_buttons">#ADMIN_SITE_CONTOL#</li><{/if}>
 <{foreach item=menu_item from=Admin_MenuItem::getActiveMenus()}>
  	<{if $user->reqRights($menu_item->object_id())}>
    	<li onclick="document.location.href='<{$me.path}>/<{$menu_item->uri}>';" class="menu_buttons"><{$menu_item->menu_name}></li>
    <{/if}>
  <{/foreach}>
  </ul>
 </div>
</div>

<div>
<div class="cms_admin_breadcrumbs" style="padding: 20px;">
	<{foreach item=breadcrumb from=$tpl->getBreadCrumbs()}>
		<a href="<{$breadcrumb.link}>"><{$breadcrumb.name}></a> <span>&rarr;</span>
	<{/foreach}>
</div>
<div id="content">
  <{include file=$moduletemplate}>
</div>
</body>
</html>
