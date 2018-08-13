<?php
$service=D::$req->textLine("service");
$manage=D::$req->textLine("manage");
$detail_manage=D::$req->textLine("detail_manage");
$info=D::$req->textLine("info");
$detail_info=D::$req->textLine("detail_info");
$usefull=D::$req->textLine("usefull");
$detail_usefull=D::$req->textLine("detail_usefull");
$takeagain=D::$req->textLine("takeagain");
$detail_takeagain=D::$req->textLine("detail_takeagain");
$addon=time();
if ($service=='Если «да», то укажите пожалуйста, ориентировочную дату заезда и место размещения') {
	$service='';
}
if ($detail_manage=='При выборе ответов «удовлетворительно» и «плохо», укажите пожалуйста, в чем заключалась некомпетентность сотрудника'){
	$detail_manage='';
}
if ($detail_info=='При выборе ответов «слабое соответствие» и «абсолютно не соответствует», укажите пожалуйста в чем были основные различия'){
	$detail_info='';
}
D::$db->exec("INSERT INTO #PX#_anketa (addon, ans1, ans2, ans3, ans4, ans5, ans6, ans7, ans8, ans9) 
VALUES({$addon}, '{$service}','{$manage}','{$detail_manage}','{$info}','{$detail_info}','{$usefull}','{$detail_usefull}','{$takeagain}','{$detail_takeagain}')");
?>