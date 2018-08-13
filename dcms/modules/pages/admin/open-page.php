<?php
	$page = D_Core_Factory::Pages_StaticPage(D::$req->int('content_id'));
	D::$tpl->RedirectOrJSON('~/', array('status' => 'OK', 'url' => D::$web.'/pages/'.$page->alias));
?>