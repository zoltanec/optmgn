<?php
function smarty_modifier_dectocolor($color) {
	return '#'.dechex($color);
}
?>