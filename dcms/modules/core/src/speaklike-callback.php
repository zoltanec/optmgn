<?php
$mail = new Notify_Mail(D::$config->mail_settings);
$mail->send(D::$config->{'notify.admin_email'}, print_r($_REQUEST,true), "SpeakLike Callback");
echo "OK";
exit;