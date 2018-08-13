<?php
$T['newslist'] = News_News::getSearchList();
$T['newslist']->page = D::$req->page('param3');
//список новостей
?>