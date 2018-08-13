<?php
try {
	$poll = D_Core_Factory::Polls_Poll(D::$req->int('param1'));
} catch (Exception $e) {
	D::$tpl->Redirect('~/index/');
}
if(D::$req->textLine('param2') == 'restart') {
	Polls_Useranswer::flushAnswersForPoll($poll->poll_id, D::$user->uid);
}
$T['poll'] = &$poll;
?>