<?php
try {
	$T['ticket'] = D_Core_Factory::Support_Topics(D::$req->int('tid'));
} catch (Exception $e) {
	D::$tpl->PrintText('NO_SUCH_TOPIC');
}
?>