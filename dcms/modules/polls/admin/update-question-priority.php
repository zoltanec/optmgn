<?php
try {
	$question = D_Core_Factory::Polls_Question(D::$req->int('param3'));
} catch (Exception $e) {
	D::$tpl->Redirect('~/index/err_ERROR_NO_SUCH_QUESTION/');
}
if(D::$req->textLine('mode') == 'up') {
	$question->priority--;
} else {
	$question->priority++;
}
$question->save();
D::$tpl->Redirect('~/edit-poll/'.$question->poll->poll_id);