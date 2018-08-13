<?php
function smarty_modifier_moneysplit($value) {

	if($value % 1 == 0 ) {
		$value = intval($value);
		$dec = 0;
	} else {
		$dec = 2;
	}
	if($value < 1000) {
		return $value;
	}
	return number_format($value, $dec, ',', '&nbsp;');
}
