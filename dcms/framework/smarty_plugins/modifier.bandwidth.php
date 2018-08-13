<?php
function smarty_modifier_bandwidth($value, $format = 'NO') {
	$mb = 1048576;
	$gb = 1073741824;
	if($value > $gb ) {
		return round($value / $gb, 1)." GB";
	} elseif ($value > $mb) {
		return round($value / $mb, 2)." MB";
	} else {
		return round($value / 1024)." KB";
	}
}