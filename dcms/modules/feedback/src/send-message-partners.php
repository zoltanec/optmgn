<?php
//код который надо отобразить
session_start();
$captcha=D::$req->textLine('captcha');
if (!isset($_SESSION['captcha_code']) || $captcha==$_SESSION['captcha_code']) {
		$mailmsg="<b>Имя:</b> ".D::$req->textLine('name')."<br />E-mail: ".D::$req->textLine('email');
		$mailmsg.="<br /><b>Телефон:</b> ".D::$req->textLine('phone');
		$mailmsg.="<br /><b>Тип партнерства:</b> ".D::$req->textLine('partnership');
		$mailmsg.="<br /><b>Организация:</b> ".D::$req->textLine('org_name');
		$mailmsg.="<br /><b>Тип организации:</b> ".D::$req->textLine('org_type');
		$mailmsg.="<br /><b>Сайт:</b> ".D::$req->textLine('sitename');
		$mailmsg.="<br /><b>Регион:</b> ".D::$req->textLine('region');
		$mailmsg.="<br /><b>Опыт (лет):</b> ".D::$req->textLine('experience');
		$mailmsg.="<br /><b>Наличие строительной бригады:</b> ".D::$req->textLine('brigade');
		$mailmsg.="<br /><b>Возможности предприятия и планы продвижения продукта:</b><br />".D::$req->textLine('content');
		D::appendmoduleNameSpace("core");
		$mailer=new Core_Mailer('develop@dinix.ru','12345g','smtp.yandex.ru');
		$attachment='';
		if(isset($_FILES['attachment']))
			$attachment=$_FILES['attachment'];
		if(@$mailer->send('corp@glavfundament.ru', 'Сообщение с сайта', $mailmsg, $attachment))
			echo 'success'; 
		exit;
} else {
	echo "wrong_code";
	exit;
}
?>
