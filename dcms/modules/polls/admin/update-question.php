<?php
$question = D_Core_Factory::Polls_Question(D::$req->int('param3'));
D::$req->map($question, array('question' => 'textLine', 'active' => 'bool','answers' => 'bbText', 'help' => 'textLine', 'catid' => 'int' ));
$question->mode = D::$req->select('mode', array_keys(Polls_Question::getQuestionModes()));
$question->save();
D::$tpl->RedirectOrJSON('~/edit-question/'.$question->qid, array('status' => 'OK'));
?>