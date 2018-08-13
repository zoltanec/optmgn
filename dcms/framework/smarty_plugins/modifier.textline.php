<?php
function smarty_modifier_textline($text) {
	 $return = "";
     for($n=0;$n<strlen($text);$n++) { $return.=$text[$n]."<br>";}
     return $return;
}
?>