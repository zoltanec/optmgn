<?php
$news = new News();
D::$req->map($news,array('title'=>'textLine','source'=>'textLine',	'author'=>'textLine', 'sid'=>'intID', 'active'=>'bool'));
$news->mode = D::$req->select('mode',array('html','bbcode'));
if($news->mode == 'html') {
	$news->content = D::$req->html('content');
} else {
	$news->content = D::$req->bbText('content');
}
$news->save();
D::$Tpl->redirect("~/edit-news/nid_{$news->nid}/");
?>