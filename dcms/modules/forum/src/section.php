<?php
try {
	$T['section'] = D_Core_Factory::Forum_Section(D::$req->intID('sid'));
} catch (Exception $e) {
	D::$tpl->PrintText('NO_SUCH_SECTION');
}
$T['list'] = $T['section']->getTopicsList();
$T['list']->perpage = 20;
$T['list']->page = D::$req->page('page');
?>