<?php
try {
	$news = D_Core_Factory::News_News(D::$req->int('nid'));
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/all-news/', array('status' => 'ERROR_NO_SUCH_OBJECT'));
}
$news->delete();
D::$Tpl->RedirectOrJSON("~/all-news/", array('status' => 'OK'));
?>