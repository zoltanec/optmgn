<?php
class Core_I18n_TranslatedNet extends D_Core_Object {
	private $username = '';
	private $password = '';
	private $api = 'http://www.translated.net/hts/';

	function __construct() {
		$this->username = D::$config->{'core.i18n.translatednet.username'};
		$this->password = D::$config->{'core.i18n.translatednet.password'};
	}

	function quote($text, $from, $to ) {
		$request = $this->request(['f' => 'quote', 'text' => $text, 's' => $from, 't' => $to]);

		$i = ['code' => '0', 'msg' => 'NO_CODE', 'time' => '0000-00-00T00:00:00', 'words' => '0', 'price' => '0', 'pid' => 0];

		list($i['code'], $i['msg'], $i['time'], $i['words'], $i['price'], $i['pid'] ) = explode("\n", $request);
		return $i;
	}

	private function request($data) {
		$data['cid'] = $this->username;
		$data['p'] = $this->password;
		return D_Misc_Url::FetchDocument($this->api, $data);
	}

	function approve($pid) {
		$request = $this->request(['f' => 'confirm', 'pid' => intval($pid), 'c' => 1 ]);
		return $request;
	}

	function langs() {
		var_dump($this->request(['f' => 'll']));
	}
}