<?php
//код который надо отобразить
	$mailmsg="<b>e-mail</b>: ".D::$req->textLine('email')."<br />Сообщение:<br />".D::$req->textLine('msg');
	D::appendmoduleNameSpace("core");
	$mailer=new Core_Mailer("develop@dinix.ru","12345g","smtp.yandex.ru");
	$cur_city=Contacts_Contact::getContactByCity($_COOKIE['region']);
	$mailer->send( $cur_city->email, "Сообщение с сайта", $mailmsg);
	//echo "success";
	//exit;
?>
