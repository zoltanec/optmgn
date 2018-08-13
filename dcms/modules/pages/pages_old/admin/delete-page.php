<?php
$page = D_Core_Factory::Pages_StaticPage(D::$req->int('contentid'));
if(!$page) {
	throw new D_Core_Exception('NO_SUCH_STATIC_PAGE');
}
$page->delete();
D::$Tpl->RedirectOrJSON('~/', array('status' => 'OK', 'content_id' => $page->content_id));
?>