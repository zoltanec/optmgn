<?php
$poll = D_Core_Factory::Polls_Poll(D::$req->int('param3'));
D::$tpl->addBC('~/edit-poll/'.$poll->poll_id, $poll->name);
$T['poll'] = &$poll;
?>