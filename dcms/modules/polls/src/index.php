<?php
$polls = Polls_Poll::getPollsList();
$result_array = array();
// we need list of loaded polls_ids
$polls_ids = array();
foreach($polls AS $poll) {
	if($poll->active) {
		$polls_ids[] = $poll->poll_id;
	}
}
// and we need to load progress for this polls
$progress = Polls_Useranswer::getAnsweredCountForPolls($polls_ids, D::$user->uid);
// now set progress percents
foreach($polls AS $poll) {
	if(!$poll->active) continue;
	$poll->progress = ( $poll->questions_count == 0 || !isset($progress[$poll->poll_id])) ? 0 : floor(100 * $progress[$poll->poll_id]['answered'] / $poll->questions_count);
	if($poll->progress > 100) $poll->progress = 100;
	$result_array[] = $poll;
}
$T['polls'] = &$result_array;
$T['progress'] = &$progress;
?>