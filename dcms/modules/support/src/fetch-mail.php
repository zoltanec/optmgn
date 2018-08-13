<?php
header("Content-type: text/html; charset=UTF-8");
echo "<pre>";
$logs = [];
$recieved_messages = Support_Pop::getNewMessages();
$settings = D::$config->{'support.emails.logins.smtp'};
foreach($recieved_messages AS $account => $msgs) {
	$mail = new Notify_Mail($settings[$account]);

	$ignores = D::$db->fetchlines("SELECT * FROM #PX#_support_ignores WHERE account = '{$account}'");

	foreach($msgs AS $msg) {
		if(empty($msg['headers']['Return-Path'])) {
			$logs[] = "Skip message with empty return path.";
			continue;
		}

		// remove ignored messages from stream
		foreach($ignores AS $rule) {
			$field = $rule['field'];
			$value = $rule['value'];

			if(isset($msg['headers'][$field]) && preg_match($value, $msg['headers'][$field])) {
				$logs[] = "Skip ignored. {$field}: ".$msg['headers'][$field];
				continue 2;
			}
		}

		$code = strtoupper(D_Misc_Random::getString(6));

		$message = str_replace(['%link%','%code%'], [D::$web."/support/".$code, $code ], D::$i18n->translate('TICKETS_REQUEST_RECIEVED'));

		if( preg_match('/\[ID: #([0-9A-Z]+)\]/', $msg['headers']['Subject'], $match) ) {
			$found_code = $match[1];
			// try to find this ticket again
			$topic = Support_Topics::find( ['code' => strtoupper($found_code)], ['limit' => 1] );
			if(empty($topic)) unset($topic);
		}


		if(!isset($topic)) {
			$topic = new Support_Topics();
			$topic->subject = $msg['headers']['Subject'];
			$topic->add_time = $topic->upd_time = time();
			$topic->active = 1;
			$topic->account = $account;
			$topic->author = $msg['headers']['Return-Path'];
			$topic->code = $code;
		} else {
			$topic->upd_time = time();
		}
		//var_dump($topic);
		$topic->save();

		$nmsg = new Support_Messages();
		$nmsg->msg_raw = base64_encode(serialize($msg));
		$nmsg->msg = Support_Pop::getVisibleContent($msg);
		$nmsg->add_time = time();
		$nmsg->tid = $topic->tid;
		$nmsg->save();

		$logs[] = "Saved new message from {$topic->author}";
		unset($topic);
		//$mail->send('john.go.data@gmail.com',$message,"[ID: #".$code."] ".$msg['headers']['Subject'] );
	}

}
//echo htmlspecialchars($msgs[0]['headers']['Return-Path']);
var_dump($logs);
var_dump($recieved_messages);
exit;
?>