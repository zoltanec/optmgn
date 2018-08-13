<?php
$poll = D_Core_Factory::Polls_Poll(D::$req->int('param1'));
Polls_Useranswer::flushAnswersForPoll($poll->poll_id, D::$user->uid);
D::$tpl->Redirect('~/');
?>