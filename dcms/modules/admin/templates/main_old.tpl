<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Панель управления администратора // <{$config->site_name}></title>
 		<link href="<{$config->cdn_hostname}>/css/admin.css" rel="stylesheet" type="text/css">
 		<link href="<{$config->cdn_hostname}>/css/jquery.treeview.css" rel="stylesheet" type="text/css">
 		<script type="text/javascript" src="<{$config->jscripts_path}>/tiny_mce/tiny_mce.js"></script>
 		<script type="text/javascript" src="<{$config->cdn_hostname}>/jscripts/jquery.js"></script>
 		<script type="text/javascript" src="<{$config->jscripts_path}>/d.js"></script>
 		<script type="text/javascript" src="<{$config->jscripts_path}>/ui.js"></script>
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
		tinyMCE.init({relative_urls: 0,	convert_urls: 0, mode : "specific_textareas",  editor_selector : "cms_rich", theme : "advanced", theme_advanced_toolbar_location : "top", plugins: "table", elements: "rich"});
		</script>
		<script type="text/javascript" src="<{$config->jscripts_path}>/admin.functions.js"></script>
		<script type="text/javascript" src="<{$me.www}>/core/get-javascript-translates/"></script>
		<script type="text/javascript" src="<{$me.www}>/filemanager/list_url"></script>
        <script type="text/javascript" src="<{$config->cdn_hostname}>/jscripts/jquery.tmpl.min.js"></script>
        <script type="text/javascript" src="<{$config->cdn_hostname}>/jscripts/jquery.datepicker.js"></script>
        <script type="text/javascript" src="<{$config->jscripts_path}>/core.functions.js"></script>
        <script type="text/javascript" src="<{$config->cdn_hostname}>/jscripts/jquery.treeview-1.4.1.js" ></script>
	</head>
	<body>
		<div id="HEADER">
  			<div id="TOP_MENU">
   				<div id="top_text">
    				<div id="PYA">Панель управления администратора</div>
    				<div id="site_name"><span>Сайт</span> &laquo;<{$config->site_name}>&raquo;</div>
   				</div>
   			<div id="help_menu">
     			<div id="faq">
     				<img src="<{$config->cdn_images}>/admin/faq.png">
     				<div id="faq_text">Справка</div>
     			</div>
     			<div id="sourse">
     				<img src="<{$config->cdn_images}>/admin/sourse.png">
     				<div id="sourse_text">Тех. поддержка</div>
     			</div>
   			</div>
 		</div>

		<div id="BOTTOM_MENU">
   			<div onclick="document.location.href='<{$me.path}>/';" class="menu_buttons"><a href="<{$me.path}>/">Главная</a></div>
  <{foreach item=menu_item from=Admin_MenuItem::getActiveMenus()}>
    <div onclick="document.location.href='<{$me.path}>/<{$menu_item->uri}>';" class="menu_buttons"><a href="<{$me.path}>/<{$menu_item->uri}>"><{$menu_item->menu_name}></a></div>
  <{/foreach}>
 </div>
</div>
<div>
<div class="cms_admin_breadcrumbs" style="padding: 20px;">
	<{foreach item=breadcrumb from=$tpl->getBreadCrumbs()}>
		<a href="<{$breadcrumb.link}>"><{$breadcrumb.name}></a> &rarr;
	<{/foreach}>
</div>
<div id="content">
  <{include file=$moduletemplate}>
</div>

</body>
</html>
