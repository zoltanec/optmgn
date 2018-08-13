<?php
try {
	$poll_id = (D::$req->int('param3') != 0 ) ? D::$req->int('param3') : D::$req->int('poll_id');
	$poll = D_Core_Factory::Polls_Poll($poll_id);
} catch (Exception $e) {
	D::$tpl->redirect('~/');
}
if( sizeof($poll->questions) != 0 ) {
	D::$tpl->PrintJSON(array('status' => 'ERROR_NOT_EMPTY' ));
}
//$poll->delete();
D::$tpl->RedirectOrJSON('~/', array('status' => 'OK'));
?>