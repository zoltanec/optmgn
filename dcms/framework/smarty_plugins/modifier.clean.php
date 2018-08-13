<?php
function smarty_modifier_clean($text) {
	return preg_replace("/<!--\[if gte mso 9\]>(.*)<!--\[endif] -->/","\1", $text );
}
?>