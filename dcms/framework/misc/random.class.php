<?php
class D_Misc_Random {
	static public $symbols = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
	                               'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
	                               '0','1','2','3','4','5','6','7','8','9');
	static function getString($length = 6, $dict = array()) {
		if(sizeof($dict) == 0 ) $dict = self::$symbols;

		$string = '';
		for($i = 1; $i <= $length; $i++) {
			$string .= $dict[array_rand($dict)];
		}
		return $string;
	}
}
?>