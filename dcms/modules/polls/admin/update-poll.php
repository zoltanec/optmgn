<?php
$poll = D_Core_Factory::Polls_Poll(D::$req->int('param3'));
D::$req->map($poll, array('name' => 'textLine', 'active' => 'bool', 'descr' => 'html', 'final_message' => 'html'));
$poll->save();
D::$Tpl->RedirectOrJSON('~/edit-poll/'.$poll->poll_id, array('status' => 'OK'));
?>