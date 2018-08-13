<?php
try {
	$question = D_Core_Factory::Polls_Question(D::$req->int('qid'));
} catch (Exception $e) {
	D::$Tpl->PrintJSON(array('status' => 'ERROR_WRONG_QUESTION'));
}
$answer = new Polls_Useranswer();
$answer->qid = $question->qid;
$answer->poll_id = $question->poll_id;
$answer->uid = D::$user->uid;
$answer->think_time = D::$req->int('think_time');
$answer->answers_list = D::$req->textLine('answers_list');
$answer->own_answer = D::$req->textLine('own_answer');
$answer->save();
D::$tpl->PrintJSON(array('status' => 'OK'));
?>