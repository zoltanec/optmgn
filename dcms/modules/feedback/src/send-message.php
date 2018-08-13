<?php
session_start();
$captcha=D::$req->textLine('captcha');

if (!isset($_SESSION['captcha_code']) || $captcha==$_SESSION['captcha_code']) {
	$msg=new Feedback_FeedbackMsg();
	D::$req->map($msg,array('name'=>'textLine','email'=>'textLine','phone'=>'textLine','content'=>'textLine','know'=>'textLine',
	'company'=>'textLine','country_id'=>'int','region_id'=>'int','city_id'=>'int','did'=>'int','csid'=>'int','rid'=>'int','subscribe'=>'bool'));
	if(D::$config->feedback_type=='db'){
		$msg->addtime=time();
		$msg->save();
	}else{
		$mailmsg="<br /><b>Сообщение</b>:<br />{$msg->content}";
		D::appendmoduleNameSpace("core");
		$mailer=new Core_Mailer('develop@dinix.ru','12345g','smtp.yandex.ru');
			$email=D::$config->email;
		$attachment='';
		if(isset($_FILES['attachment']))
			$attachment=$_FILES['attachment'];
		@$mailer->send($email, 'Сообщение с сайта', $mailmsg, $attachment);
		echo 'success';
		exit;
	}
} else {
	echo "wrong_code";
	exit;
}
?>