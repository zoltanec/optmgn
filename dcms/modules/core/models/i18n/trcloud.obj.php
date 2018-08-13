<?php
class Core_I18n_Trcloud {
	public $key = '';

	function __construct($key) {
		$this->key = $key;
	}

	function request($text, $from, $to) {
		$callback = D::$web."/core/trcloud-callback/";
		$words = explode(' ', $text);
		if(sizeof($words) > 2) {
			$mode = 'post_edit';
		} else {
			$mode = 'machine';
		}

		$data = ['dst' => $to, 'key' => $this->key, 'src' => $from, 'text' => $text, 'translation_type' => $mode, 'test' => 'n', 'callback' => $callback];

		$request = D_Misc_Url::FetchDocument('https://translationcloud.net/api/create/project', $data);
		$xml=new DOMDocument();
		$xml->loadXML($request);
		return $xml->getElementsByTagName("translation")->item(0)->nodeValue;

		//return $request;
	}

	function getTranslators($from = 'en', $to = 'en') {
		$data = ['dst' => $to, 'src' => $from, 'key' => $this->key];
		$request = D_Misc_Url::FetchDocument('https://translationcloud.net/api/available_translators', $data);
		echo htmlspecialchars($request);

		$xml =new DOMDocument();
		$xml->loadXML($request);
		return  $xml->getElementsByTagName("available_translators")->item(0)->nodeValue;

	}

	function price($text, $from, $to) {
		echo htmlspecialchars(D_Misc_Url::FetchDocument('https://translationcloud.net/api/get_price/project', ['dst' => $to, 'key' => $this->key, 'src' => $from, 'text' => $text, 'translation_type' => 'post_edit']));
	}
}