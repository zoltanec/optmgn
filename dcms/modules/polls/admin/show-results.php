<?php
$search_id = D::$req->textID('search');
try {
	$poll = D_Core_Factory::Polls_Poll(D::$req->int('param3'));
} catch (Exception $e) {
	D::$tpl->Redirect('~/index/');
}
if ($search_id != '' && isset($_SESSION['result_search_'.$search_id])) {
	$filter = $_SESSION['result_search_'.$search_id];
} else {
	$filter = array();
	$filter['city'] = D::$req->textLine('city');
	$filter['age_from'] = D::$req->textLine('age_from');
	$filter['age_to'] = D::$req->textLine('age_to');
	$filter['sex'] = D::$req->select('sex', array('none','m','w'));
	$filter['completed'] = D::$req->select('completed', array('nomatter','full','partial') );
	$filter['search_id'] = md5(print_r($_SERVER,true));
	$filter['questions'] = sizeof($poll->active_questions);
	$_SESSION['result_search_'.$filter['search_id']] = $filter;
}
$T['poll'] = &$poll;
$T['filter'] = &$filter;
//var_dump($filter);exit;
// загружаем список результатов пользователей
$results_list = Polls_Useranswer::getResultsList($poll->poll_id, $filter);
$results_list->page = D::$req->page('param4');
$T['results_list'] = &$results_list;
?>