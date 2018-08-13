<?php
class D_Misc_Crypt {
	private $rc4m = array();
	private $key = '';

	function __construct($key) {
		$this->key = $key;
	}

	public function rc4($string) {

		if (sizeof($this->rc4m) < 1) {
			// Setup key array
			$keylen = strlen($this->key);
			$m = array();
			for ($i = 0; $i < 256; $i++) {
				$m[$i] = $i;
			}
			$j = 0;
			$k = 0;
			for ($i = 0; $i < 256; $i++) {
				$a = $m[$i];
				$j = ($j + $a + ord($this->key{$k})) & 0xFF;
				$m[$i] = $m[$j];
				$m[$j] = $a;
				if (++$k >= $keylen) {
					$k = 0;
				}
			}
			$this->rc4m = $m;
		}

		// Pack/unpack
		$str = $string;
		$strlen = strlen($str);
		$x = 0;
		$y = 0;
		$m = $this->rc4m;

		for ($i = 0; $i < $strlen; $i++) {
			$x = ($x + 1) & 0xFF;
			$a = $m[$x];
			$y = ($y + $a) & 0xFF;
				$m[$x] = $m[$y];
				$b = $m[$y];
				$m[$y] = $a;
				$str{$i} = chr(ord($str{$i}) ^ ($m[($a + $b) & 0xFF]));
		}
		return($str);
	}

	/**
	 * Hashing with SALT
	 * string $data - data which must be hashed
	 * string $hash - hash example to compare
	 * int $rounds  - how many rounds of hashing we have
	 * int $salt_size - salt string size
	 */
	static function xhash($data, $hash = '', $rounds = 3, $salt_size = 2 ) {
		if(empty($hash)) {
			for($r = 0; $r < $rounds; $r++) {
				$salts[] = D_Misc_Random::getString($salt_size);
			}
		} else {
			$hash_split = explode(':', $hash);
			for($r = 0; $r < sizeof($hash_split) -1; $r++) {
				$salts[] = $hash_split[$r];
			}
		}
		$hash = $data;
		for($round = 0; $round < $rounds; $round++) {
			$hash = md5($salts[$round].$hash);
		}
		return implode(':',$salts).':'.$hash;
	}

	/**
	 * Convert int to another base
	 *
	 * @param int $int - integer which will be converted
	 * @param array $base - base alphabet
	 */
	static function convertToBase($int, $base = array()) {
		if(!is_array($base) && is_string($base)) {
			$base = explode('', $base);
		}

		if(!is_array($base)) return 0;

		$dim = sizeof($base);

		if( $int < $dim ) return $base[$int];

		$res = array();
		$last = $int;
		while(true) {
			$ost = $last % $dim;
			$res[] = $base[$ost];

			$last = floor($last / $dim);

			if($last < $dim ) {
				$res[] = $base[$last];
				break;
			}
		}
		$new = array_reverse($res);
		return implode('',$new);
	}

	/**
	 * Convert from custom base to 10 int
	 *
	 * @param string $string - which we need to convert
	 * @param array $base - base
	 */
	static function convertFromBase($string, $base = array()) {
		$dim = sizeof($base);

		if(empty($string)) return 0;

		if(preg_match('/[^'.implode('',$base).']/', $string)) return 0;

		if(strlen($string) == 1 ) return array_search($string, $base);

		$val = 0;
		$len = strlen($string);
		for($x = $len - 1; $x >= 0; $x--) {
			$dec_value = array_search($string[$x], $base);
			$val += $dec_value * pow($dim, $len - $x - 1);
		}

		return $val;
	}
}
?>