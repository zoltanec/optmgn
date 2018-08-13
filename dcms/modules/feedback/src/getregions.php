<?php
$cid=D::$req->int('cid');
	if(isset($cid)){
		echo json_encode(D::$db->fetchlines("SELECT * FROM #PX#_region WHERE country_id={$cid}"));
		exit;
	}
?>