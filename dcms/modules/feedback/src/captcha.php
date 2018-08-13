<?php
//код который надо отобразить
session_start();
$code=substr(md5(rand(0,100).$_SERVER['REMOTE_ADDR']),0,6);
$_SESSION['captcha_code'] = $code;
$image=imagecreate(80, 20);
imagecolorallocate($image, 255, 255, 255);
$textcolor = imagecolorallocate($image, 0, 0, 0);
imagestring($image, 5, 8, 0, $code, $textcolor);
header("Content-type: image/png");
imagePNG($image);
exit;
?>