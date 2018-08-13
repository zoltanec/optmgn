<?php
try {
	$topic = dFactory::ForumTopic(D::$req->int('tid'));
} catch (Exception $e) {
	throw new dRuntimeException('NO_SUCH_TOPIC');
}
//права доступа
if( !(D::$user AND D::$user->reqRights('delete/forum/forumtopic/') ) ) {
	throw new dRuntimeException('PERMISSION_DENIED');
}
$topic->delete();
//$topic->section->runStatRebuild();
D::$Tpl->Redirect('~/section/sid_'.$topic->sid);
?>