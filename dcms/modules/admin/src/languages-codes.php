<?php
$T['languages'] = array('en', 'ru', 'de');
$T['lang'] = D::$req->select('lang',$T['languages']);
$T['messages']=D::$db->fetchlines("SELECT a.msg_code, a.lang, length(a.msg_text) AS strlen FROM #PX#_lng_messages a WHERE a.lang = '{$T['lang']}'");
?>