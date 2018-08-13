<?php
function smarty_modifier_ruquotes($str) {
	if( strpos($str, '"') === false ) return $str;

	$left = true;
	$count = substr_count($str, '"');
	for($x = 0; $x< $count; $x++ ) {
		$str = ( $left ) ? preg_replace('/"/', '&laquo;', $str, 1) : preg_replace('/"/', '&raquo;', $str, 1);
		$left = !$left;
	}
	return $str;
}
?>