<?php
$news = new News_News();
D::$req->map($news,array('active'=>'bool'));
$news->title = 'Draft';
$nid = $news->save();
D::$Tpl->Redirect('~/edit-news/nid_'.$nid);
?>