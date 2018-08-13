<?php
//обновление информации о новости
$news = D_Core_Factory::News_News(D::$req->intID('nid'));
D::$req->map($news,array('title'=>'textLine', 'source'=>'textLine',
                         'alias'=>'textLine', 
                        'author'=>'textLine', 'sid'=>'intID',
                        'active'=>'bool', 'content_preview' => 'html',
                         'icon' => 'textLine', 'ontop'=>'bool', 'comments_status'=>'bool'));

$news->mode = D::$req->select('mode',array('html','bbcode'));
if($news->mode == 'html') {
	$news->content = D::$req->raw('content');
} else {
	$news->content = D::$req->bbText('content');
}
if($news->content_preview == '') {
	$preview = preg_replace(array('/\[\w+\]/','/\[\/\w+\]/'),array('',''),strip_tags(addslashes($news->content)));
	$preview = trim($preview);
	if(mb_strlen($preview) > 700) {
		$preview = mb_substr($preview,0,strpos($preview,' ', 700));
    }
    $news->content_preview = $preview;
}
if(!$news->alias)
	$news->alias = strtolower(D_Core_I18n::translit($news->title));
//Заменяем лишние символы на нижнюю черту
$news->alias = preg_replace('/[^a-zA-Z0-9\-_\-\.]/','_',$news->alias);

$tags = D::$req->textLine('tags');
if($tags != $news->tags) {
	$news->tags = $tags;
	$news->rebuildTags();
}
$news->save();
D::$Tpl->RedirectOrJSON("~/edit-news/nid_{$news->nid}/", array('status' => 'OK'));
?>