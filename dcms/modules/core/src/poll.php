<?php
$vote_id = D::$req->int('voteid');
$vote = D_Core_Factory::VoteWidget($vote_id);

if(!$vote) {
	D::$Tpl->PrintText('UNABLE_TO_FIND_VOTE');
}
//надо ли голосовать пользователю
if(D::$req->bool('voteme')) {
	$resultid = D::$req->textLine('result');

	if( $resultid == '') {
		D::$Tpl->PrintText('ERROR_UPDATING');
	}
	$resultsid = array();
	$resultsid = explode('_',$resultid);
	if(D::$user) {
		$uid = D::$user->uid;
	} else {
		$uid = 0;
	}
	$vote->UserVote($uid, $resultsid);
	$vote->nowVoted();
}
$T['vote'] = &$vote;
D::$Tpl->RenderTpl('dwidget:vote;voteresult');
?>