<?php
header("Content-Type: plain/text; charset=utf-8");
$list = D::$db->fetchlines("SELECT a.name, a.phone, a.sex FROM #PX#_users a WHERE a.subscribe");
foreach($list AS $info) {
	echo $info['name'].':::'.$info['phone'].':::'.$info['sex'].";;;\n";
}
exit;
?>