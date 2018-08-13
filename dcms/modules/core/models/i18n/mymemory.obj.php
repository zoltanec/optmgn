<?php
class Core_I18n_MyMemory {
	static function getTranslationObject($string, $from, $to) {
		$data = D_Misc_Url::FetchDocument('http://mymemory.translated.net/api/get', ['q' => $string , 'langpair' => "{$from}|{$to}", 'mt' => '0' ]);
		return json_decode($data);
	}

	static function getTranslation($string, $from, $to) {
		$data = self::getTranslationObject($string, $from, $to);
		if(!isset($data->responseData)) {
			throw new D_Core_Exception('Wrong response');
		}

		if(empty($data->responseData->translatedText)) {
			throw new D_Core_Exception('Bad answer');
		}

		return $data->responseData->translatedText;

		//var_dump($data);exit;
		//if(!empty($data->re))
	}
}