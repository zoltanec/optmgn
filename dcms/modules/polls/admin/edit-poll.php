<?php
$poll = D_Core_Factory::Polls_Poll(D::$req->int('param3'));
$T['poll'] = &$poll;
D::$tpl->addBC('~/edit-poll/'.$T['poll']->poll_id, $T['poll']->name);
?>