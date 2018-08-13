<?php
$poll = D_Core_Factory::Polls_Poll(D::$req->int('param3'));
$category = new Polls_Category();
$category->poll_id = $poll->poll_id;
$category->save();
D::$tpl->redirect('~/view-categories/'.$poll->poll_id);
?>