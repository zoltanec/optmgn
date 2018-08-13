<?php
try {
	$poll = D_Core_Factory::Polls_Poll(D::$req->int('param3'));
} catch (Exception $e) {
	D::$tpl->Redirect('~/index/err_ERROR_NO_SUCH_POLL/');
}
if(D::$req->textLine('mode') == 'up') {
	$poll->priority--;
} else {
	$poll->priority++;
}
$poll->save();
D::$tpl->Redirect('~/index/');
?>