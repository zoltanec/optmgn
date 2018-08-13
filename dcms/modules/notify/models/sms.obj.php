<?php
class Notify_Sms {
	static function send($number, $message) {
		switch(D::$config->{'notify.sms.provider'}) {
			case 'smspilot':
				$sms = new Notify_Sms_SmsPilot(D::$config->{'notify.sms.smspilot_key'} );
				$sms->send($number, $message, D::$config->{'notify.sms.smspilot_from'} );
				break;
			case 'websms':
				$sms = new Notify_Sms_WebSMS(D::$config->{'notify.sms.user'}, D::$config->{'notify.sms.pwd'} );
				$sms->send($number, $message, D::$config->{'notify.sms.smsru_from'} );
				break;
			default:
				$sms = new Notify_Sms_SmsRu(D::$config->{'notify.sms.smsru_key'});
				$sms->send($number, $message, D::$config->{'notify.sms.smsru_from'});
		}
		return true;
	}
}
?>