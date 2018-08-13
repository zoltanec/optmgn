<?php
//управление комментариями
$T['comments'] = dCommentsList::all(array('mode' => D::$req->select('mode',array('all','unapproved'))));
$T['comments']->page = D::$req->page('cmpage');
//$T['comments']->order = 'desc';
//$T['comments']->select_mode = D::$req->select('mode',array('unapproved','all'))
?>