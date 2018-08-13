<?php

class Notify_Sms_SmsRu extends D_Core_Object {
	// максимальное количество пользователей на которые будет отсылаться смс
	const MAX_USERS_COUNT = 100;
	//  API url
	public $api_url = 'http://sms.ru/sms/send';
	// autorization key
	public $api_key = '';

	public function __construct($api_key = '', $api_url = '') {
		$this->api_key = (!empty($api_key)) ? $api_key : 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';
		if(!empty($api_url)) $this->api_url = $api_url;
	}

	public function send($to_raw = 0, $message = '', $from = '') {
		if(is_array($to_raw)) {
			// send array is too big, we need to split it
			if(sizeof($to_raw) > self::MAX_USERS_COUNT) {
				// split our array to chunks
				$chunked = array_chunk($to_raw, self::MAX_USERS_COUNT);
				foreach($chunked AS $to_list) {
					$request = ['text'=> $message, 'to' => implode(',', $to_list), 'api_id' => $this->api_key];
					if(!empty($from)) {
						$request['from'] = $from;
					}

					D_Misc_Url::FetchDocument($this->api_url, $request);
				}
				return true;
			} else {
				$to = implode(',', $to_raw);
			}
		} else {
			$to = $to_raw;
		}
		$request = ['text'=> $message, 'to' => $to, 'api_id' => $this->api_key];
		if(!empty($from)) {
			$request['from'] = $from;
		}
		return D_Misc_Url::FetchDocument($this->api_url, array('from' => $from, 'text'=> $message, 'to' => $to, 'api_id' => $this->api_key));
	}
}
?>
