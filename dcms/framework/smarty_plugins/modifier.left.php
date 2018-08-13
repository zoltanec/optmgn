<?php
function smarty_modifier_left($text, $length) {
	$str = mb_substr($text,0,intval($length));
	if(mb_strlen($text) > $length) {
		$str.="&nbsp;&#8230;";
	}
	return $str;
}
?>