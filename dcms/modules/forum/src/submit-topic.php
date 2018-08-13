<?php
//находим раздел в котором хотят разместить топик
$section = dObject::ForumSection(D::$req->int('sid'));
if(D::$user and $section and !$section->readonly) {
	//если у нас превью
	if(D::$req->flag('preview-me')) {
		$T['preview'] = array('title' => D::$req->textLine('title'), 'descr' => D::$req->textLine('descr'), 'content' => D::$req->bbText('content'));
		//раздел
		$T['section'] = &$section;
		D::$Tpl->show('new-topic');
	} elseif (D::$req->flag('post-me')) {
		$topic = new ForumTopic();
		//проециируем
		D::$req->map($topic, array('title'=> 'textLine', 'sid'=> 'int', 'descr' => 'textLine'));
		//заносим инфо о пользователе
		list($topic->uid, $topic->username) = array(D::$user->uid, D::$user->username);
		//сохраняем наш топик и редиректим на него
		$tid = $topic->save();
		$topic->content= D::$req->bbText('content');
		D::$Tpl->redirect("~/topic/tid_{$tid}/");
	} else D::$Tpl->redirect("~/section/sid_{$section->sid}/");
} else D::$Tpl->redirect('~/');
?>