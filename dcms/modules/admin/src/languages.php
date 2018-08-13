<?php
$T['modules']=array('system','account','index','about','prices','manual','check','faq','rules','register','account');
/**
if(isset($_REQUEST['param1'])) {
	switch($_REQUEST['param1']) {
		case "ru": $_TPL['nowlang']=$lng="ru";break;
		case "en": $_TPL['nowlang']=$lng="en";break;
		default: $_TPL['nowlang']=$lng="ru";
	}
} else {
   $_TPL['nowlang']=$lng="ru";
}
if(isset($_REQUEST['param2']) AND $_REQUEST['param2']!="all") {
	$_TPL['nowmodule']=$module=$_REQUEST['param2'];
        $mod_search="a.module = '{$module}' AND";
} else {
	$_TPL['nowmodule']=$module="system";
     $mod_search="";
}*/
$mod_search = '';
$lng="ru";
$T['messages']=D::$db->fetchlines("SELECT a.*,LEFT(a.msg_text,50) AS msg_text_short FROM vpn_lng_messages a WHERE $mod_search a.lang = '{$lng}'");
?>
