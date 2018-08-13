<?php
$content_id = D::$req->int('content_id');
try {
	$page = D_Core_Factory::Pages_StaticPage($content_id);
} catch(Exception $e) {	
	D::$tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NO_SUCH_OBJECT'));
}
$T['page'] = $page;
//передаем для tinybrowser
D::getSession();
$_SESSION['tinybrowser_img_path'] = '/content/images/pages/' . $page->alias . '/';
?>