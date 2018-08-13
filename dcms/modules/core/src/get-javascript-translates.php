<?php
D::$tpl->setClearRendering();
$messages = D::$i18n->getJavaScriptMessages();
$translates = array();
foreach($messages AS $message) {
	$translates[] = "'".$message['msg_code']."':'".htmlspecialchars($message['msg_text'],ENT_QUOTES)."'";
}
Header("Expires: " . gmdate("D, d M Y H:i:s", time() + 3600 * 5) . " GMT");
Header("Cache-Control: max-age=864000, public");
Header("Content-type: text/javascript; charset=UTF-8");
Header("Pragma: public");
echo "D._({".implode(",\n",$translates)."});";
exit;
?>