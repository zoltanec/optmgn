<?php
if(!isset($_SESSION))
	session_start();
$_SESSION['cur_pack'] = D::$req->int('pack');
exit;
?>