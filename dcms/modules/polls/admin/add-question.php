<?php
$poll = D_Core_Factory::Polls_Poll(D::$req->int('param3'));
$question = new Polls_Question();
$question->poll_id = $poll->poll_id;
$question->priority = sizeof($poll->questions);
$question->save();
D::$Tpl->Redirect('~/edit-question/'.$question->qid);
?>