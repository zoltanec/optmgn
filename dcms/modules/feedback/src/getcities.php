<?php
$rid=D::$req->int('rid');
	if(isset($rid)){
		echo json_encode(D::$db->fetchlines("SELECT * FROM #PX#_city WHERE region_id={$rid}"));
		exit;
	}
?>