<?php
class Notify_Sms_SmsPilot extends D_Core_Object {
	// максимальное количество пользователей на которые будет отсылаться смс
	const MAX_USERS_COUNT = 200;
	//  API url
	public $api_url = 'http://smspilot.ru/api.php';
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
					D_Misc_Url::FetchDocument($this->api_url, array('from' => $from, 'send'=> $message, 'to' => implode(',', $to_list), 'apikey' => $this->api_key));
				}
				return true;
			} else {
				$to = implode(',', $to_raw);
			}
		} else {
			$to = $to_raw;
		}
		$data = D_Misc_Url::FetchDocument($this->api_url, array('from' => $from, 'send'=> $message, 'to' => $to, 'apikey' => $this->api_key));
		return true;
	}
}