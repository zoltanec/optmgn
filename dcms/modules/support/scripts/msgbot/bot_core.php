<?php
if(php_sapi_name() != 'cli') {
	exit;
}
$site_path = $argv[1];
require_once $site_path."/configs/core.php";
//загрузчик фреймворка
require_once $cfg['dcmspath']."/init.php";
//подключаем основной загрузчик движка
class D extends D_Core_Runner {
	static public $mainPID = 9999;
}
D::init($cfg);

Event::Log("Loading ICQ class");
require_once "WebIcqPro.class.php";
//максимальный размер отсылаемого сообщения
define("MAX_MSG_SIZE","100000");
$icq = new WebIcqPro();
$icq->setOption('MessageType', 'plain_text');
$icq->setOption('Encoding', 'UTF8');
//$apache=posix_getpwnam("apache");
//posix_setuid($apache['uid']);
//$q_id = msg_get_queue(ftok(D::$config->icqfile, 'R'),0666);
//сбрасываем очередь сообщений
while(1) {
	Event::Log("Connecting to ICQ");
	while($icq->isConnected()) {
		$msg = $icq->readMessage();

		if(is_array($msg)) {
			if(isset($msg['from']) && isset($msg['message'])) {

				if (isset($msg['encoding'])) {
					if ($msg['encoding']['numset'] === 'UNICODE') {
						$msg['realmessage'] = $msg['message'];
						$msg['message'] = mb_convert_encoding($msg['message'], 'UTF-8', 'UTF-16');
					} elseif ($msg['encoding']['numset'] === 'UTF-8') {
						//$msg['realmessage'] = $msg['message'];
						//$msg['message'] = mb_convert_encoding($msg['message'], 'cp1251', 'UTF-8');
					} elseif($msg['encoding']['numset'] === 'LATIN_1') {
						$msg['realmessage'] = $msg['message'];
						$msg['message'] = iconv('cp1251', 'utf-8', $msg['message']);
					} else {
						$msg['realmessage'] = $msg['message'];
						$msg['message'] = mb_convert_encoding($msg['message'], 'UTF-8');
					}
				}

				$m = new Support_ChatMsg();
				$m->type = 'in';
				$m->client = $msg['from'].'_icq';
				$m->stream = 'icq';
				$m->msg = $msg['message'];
				$m->save();
				//echo base64_encode($msg['message']);
				Event::Log("From {$msg['from']}:{$msg['message']}");
			}
		}
		// read message to our stream
		foreach(Support_ChatMsg::find(['stream' => 'icq', 'type' => 'out']) AS $out) {
			$to = str_replace('_icq', '', $out->client);
			$icq->sendMessage($to,  mb_convert_encoding($out->msg, 'cp1251', 'UTF-8') );
			$out->delete();
			Event::Log("Sended to {$to}.");
		}
		time_sleep_until(time() + 2);
	}

	Event::Log("Reconnecting to ICQ");
	unset($icq);
	$icq = new WebIcqPro();
	$icq->setOption('UserAgent', 'miranda');
	if($icq->connect(D::$config->{'support.icq.uin'}, D::$config->{'support.icq.password'})) {
		Event::Log("ICQ connected");
		$last_reconnect = time();
		$icq->setStatus('STARTSTATUS');
		$status = 'STARTSTATUS';
		$icq->setOption('Timeout',0.5);
		$errors_count=1;
	} else {
		Event::Log($icq->error);
		$errors_count++;
		$sleep_time = $errors_count * $errors_count;
		Event::Log("Sleeping for {$sleep_time} seconds");
		time_sleep_until( time() + $sleep_time );
	}
}
?>
