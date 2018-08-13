<?php
$searchquery = D::$req->textLine('search');
$search  = str_replace('.','/',D::$req->textLine('searchstring'));
if(empty($search) and !empty($searchquery)) {
	D::$Tpl->redirect("~/find-news/searchstring_".str_replace('/','.',base64_encode($searchquery))."/");
} elseif(!empty($search)) {
	$query = base64_decode($search);
	// запрос
	$T['query'] = $query;
	// теперь формируем список
	$T['newslist'] = News_News::getSearchList(array('title' => $query));
	D::$Tpl->show('admin/all-news');
}
?>