<?php
$topic = D_Core_Factory::Support_Topics(D::$req->int('tid'));

$nmsg = new Support_Messages();
$nmsg->msg = D::$req->textLine('message');
$nmsg->add_time = time();
$nmsg->tid = $topic->tid;
$nmsg->mtype = 'out';
$nmsg->save();

$reply_header = "RE: [ID: #{$topic->code}] ".$topic->subject;

$settings = D::$config->{'support.emails.logins.smtp'};

$message = $nmsg->msg."\n\nLink: ".D::$web."/support/view-topic/".$topic->code;
//var_dump($topic);exit;

//var_dump($settings);exit;
if(isset($settings[$topic->account])) {
	$mail = new Notify_Mail($settings[$topic->account]);
	$mail->send($topic->author, $message, $reply_header);
}

D::$tpl->Redirect('~/view-ticket/tid_'.$topic->tid);