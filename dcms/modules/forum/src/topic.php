<?php
$T['topic'] = D_Core_Factory::Forum_Topic(D::$req->intID('tid'));
if(!$T['topic']) {
	D::$Tpl->Redirect('~/');
}
D::$Tpl->title = $T['topic']->title;
$T['topic']->updateReaded();
?>