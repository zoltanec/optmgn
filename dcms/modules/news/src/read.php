<?php
$nid = D::$req->intID('param1');
$news = D_Core_Factory::News_News(D::$req->intID('param1'));
D::$tpl->title = $news->title;
$news->countReads();
$T['news'] = &$news;
$T['section'] = $news->section;
?>