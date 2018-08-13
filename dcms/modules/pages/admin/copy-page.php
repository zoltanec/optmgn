<?php
$content_id = D::$req->int('content_id');

try {

	$page = D_Core_Factory::Pages_StaticPage($content_id);
	$new_page = new Pages_StaticPage();
	$new_content_id = $new_page->save();
	$new_page = $page;
	$new_page->content_id = $new_content_id;
	$new_page->save();
	D::$tpl->RedirectOrJSON('~/', array('status' => 'OK'));
	
} catch(Exception $e) {	
	D::$tpl->RedirectOrJSON('~/', array('status' => 'ERROR_COPY_PAGE'));
} 
?>