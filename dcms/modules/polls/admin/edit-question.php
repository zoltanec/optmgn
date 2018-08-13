<?php
$question = D_Core_Factory::Polls_Question(D::$req->int('param3'));
D::$tpl->addBC('~/edit-poll/'.$question->poll->poll_id, $question->poll->name);
D::$tpl->addBC('~/edit-question/'.$question->qid, 'QID: '.$question->qid);
$T['question'] = &$question;
?>