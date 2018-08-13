<?php

if ( D::$req->int('content_id') != 0 ) {
	$page = D_Core_Factory::Pages_StaticPage(D::$req->int('content_id'));
} else {
	$page = new Pages_StaticPage();
	//$page->pagetitle = 'New page';
	//$page->parent_id = D::$req->int("parent_id");
	//$page->alias = 'new-page';
}

D::$req->map($page, array(
	'parent_id' => 'int',
	'title' => 'textLine',
	'pagetitle' => 'textLine',
	'menutitle' => 'textLine',
	'keywords' => 'textLine',
	'description' => 'textLine',
	'metatags' => 'textLine',
	'link_attributes' => 'textLine',
	'alias' => 'textLine',
	'content' => 'raw', //был html
	'content_type' => 'textLine',
	'template' => 'textLine',
	'priority' => 'int',
    'active' => 'bool', 
	'menu' => 'bool',
	'comments' => 'bool',
	'redirect' => 'bool'
	));
	
if(D::$req->int('clear')) {
	//Убираем лишние стили, теги, аттрибуты, пустые теги
	//Чтобы верстка контента была чистой
	$page->content=preg_replace('#&nbsp;#si','',$page->content);
	$page->content=preg_replace('#[\r\n]#','',$page->content);
	$page->content=preg_replace('#<dl.*?><dt.*?></dt></dl>#','',$page->content);
	/*$page->content=preg_replace('#<a.*?></a>#','',$page->content);*/
	$page->content=preg_replace('#<p.*?>#si','<p>',$page->content);
	$page->content=preg_replace('#(<td.*?>)<p.*?>(.*?)</p>(</td>)#','$1$2$3',$page->content);
	$page->content=preg_replace('#<font.*?>#si','',$page->content);
	$page->content=preg_replace('#</font>#si','',$page->content);
	$page->content=preg_replace('#<strong.*?>#si','<strong>',$page->content);
	$page->content=preg_replace('#<span.*?>#si','',$page->content);
	$page->content=preg_replace('#</span>#si','',$page->content);
	$page->content=preg_replace('#<b.*?>#si','<strong>',$page->content);
	$page->content=preg_replace('#</b>#si','</strong>',$page->content);
	$page->content=preg_replace('#style=".*?"#si','',$page->content);
	/*$page->content=preg_replace('#st.{0,3}y.{0,3}le=".*?"#si','',$page->content);*/
	$page->content=preg_replace('#class=".*?"#si','',$page->content);
	$page->content=preg_replace('#(<td.*?)width=".*?"#si','$1',$page->content);
	$page->content=preg_replace('#(<t[dh].*?)style=".*?"#si','$1',$page->content);
/*	$page->content=preg_replace('#height=".*?"#si','',$page->content);*/
	$page->content=preg_replace('#border=".*?"#si','',$page->content);
	$page->content=preg_replace('#cellpadding=".*?"#si','',$page->content);
	$page->content=preg_replace('#cellspacing=".*?"#si','',$page->content);
	$page->content=preg_replace('#bgcolor=".*?"#si','',$page->content);
	$page->content=preg_replace('#<table.*?>#si','<table class="data">',$page->content);
	//table class data
}

//Сохраняем контент в зависимости от типа
if($page->content_type == 'link') {
	$page->content = D::$req->url('link');
} elseif($page->content_type == 'module') {
	$page->content = D::$req->textID('module') . '/' . D::$req->raw('action');
} else {
	if( !$page->alias || $page->alias=='new_page' )
		$page->alias = strtolower(D_Core_I18n::translit($page->pagetitle));
	//Заменяем лишние символы на нижнюю черту
	$page->alias = preg_replace('/[^a-zA-Z0-9\-_\-\.]/','_',$page->alias);
	//Перед сохранением экранируем спец символы
	$page->content=addslashes($page->content);
}
$page->lang = D::$req->select('lang', D::$config->languages);
$page->stat_mode = D::$req->select('stat_mode', Pages_StaticPage::$stat_modes);
$page->save();
D::$tpl->RedirectOrJSON('~/', array('status' => 'OK','object' => $page));
?>