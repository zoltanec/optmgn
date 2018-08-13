<?php
try {
	$user = D_Core_Factory::D_Core_User(D::$req->int('uid'));
} catch (Exception $e) {

}
var_dump($_REQUEST);
echo "GO";exit;
?>