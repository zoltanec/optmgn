<?php
$page = D_Core_Factory::Pages_StaticPage(D::$req->int('content_id'));
if(!$page) {
	throw new D_Core_Exception('NO_SUCH_STATIC_PAGE');
}
$page->delete();
D::$tpl->RedirectOrJSON('~/', array('status' => 'OK'));
?>