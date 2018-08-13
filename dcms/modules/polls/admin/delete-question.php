<?php
try {
	$question = D_Core_Factory::Polls_Question(D::$req->int('param3'));
} catch (Exception $e) {
	D::$tpl->redirect('~/index/err_NO_SUCH_QUESTIONS/');
}
$question->delete();
Polls_Useranswer::flushAnswersForQuestion($question->qid);
D::$tpl->redirect('~/edit-poll/'.$question->poll_id);
?>