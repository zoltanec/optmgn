<?php
$mode = D::$req->select('mode', array('up','down'));

/*if(!D::$user) {
	D::$Tpl->PrintText(json_encode(array('result' => 'UNAUTH')));
}
if(!D::$user->KarmingAvailable()) {
	D::$Tpl->PrintText(json_encode(array('result' => 'KARMA_BLOCKED')));
}
*/
if(!isset($_SESSION['requests']) or $_SESSION['requests'] == 1) {
	D::$Tpl->PrintText(json_encode(array('result' => 'KARMA_BLOCKED')));
}


$comid = D::$req->int('comid');
$comment = dObject::dComment($comid);
if(!$comment) {
	D::$Tpl->PrintText(json_encode(array('result' => 'NO_SUCH_COMMENT-'.$comid)));
}

if(D::$user and ( $comment->uid == D::$user->uid)) {
    D::$Tpl->PrintText(json_encode(array('result' => 'SELF_KARMING')));
}

if(isset($_SESSION['votedposts']) and in_array($comid, $_SESSION['votedposts'])) {
   D::$Tpl->PrintText(json_encode(array('result' => 'OK', 'karma' => $comment->comment_karma )));
} elseif(isset($_SESSION['votedposts'])) {
    $_SESSION['votedposts'][] = $comid;
} else {
    $_SESSION['votedposts'] = array($comid);
}
$karma = $comment->UpdateKarma($mode);

if(D::$user) {
	D::$user->VoteKarma();
}
D::$Tpl->PrintText(json_encode(array('result' => 'OK', 'karma' => $karma )));

/**
$mode = D::$req->select('mode', array('up','down'));

/*if(!D::$user) {
	D::$Tpl->PrintText(json_encode(array('result' => 'UNAUTH')));
}
if(!D::$user->KarmingAvailable()) {
	D::$Tpl->PrintText(json_encode(array('result' => 'KARMA_BLOCKED')));
}

if(!isset($_SESSION['requests']) or $_SESSION['requests'] == 1) {
	D::$Tpl->PrintText(json_encode(array('result' => 'KARMA_BLOCKED')));
}

if(isset($_SESSION['lastkarma']) and $_SESSION['lastkarma'] > time() - 180) {
	D::$Tpl->PrintText(json_encode(array('result' => 'KARMA_BLOCKED')));
}
$comid = D::$req->int('comid');
$comment = dObject::dComment($comid);
if(!$comment) {
	D::$Tpl->PrintText(json_encode(array('result' => 'NO_SUCH_COMMENT-'.$comid)));
}

if(D::$user and ( $comment->uid == D::$user->uid)) {
	D::$Tpl->PrintText(json_encode(array('result' => 'SELF_KARMING')));
}
$karma = $comment->UpdateKarma($mode);

$_SESSION['lastkarma'] = time();
if(D::$user) {
	D::$user->VoteKarma();
}
D::$Tpl->PrintText(json_encode(array('result' => 'OK', 'karma' => $karma )));

*/
?>