<?php
$pattern = D::$req->textLine('pattern');
$parent = D::$req->int('parent_id');
$urls = D::$req->textLine('urls');
$urls = preg_split('#\r\n#si', $_POST['urls']);
foreach($urls as $url) {
	$page = new Pages_StaticPage();
	$page->parent_id = $parent;
	Core_Parser::parseByUrl( $url, $page, Core_Parser::$patterns[$pattern], true );
	//$page->save();
}
D::$tpl->printText('OK');
?>