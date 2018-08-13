<?php
$forum = new ForumSection();
$forum->name = 'Root';
$forum->save();
D::$Tpl->redirect('~/');
?>