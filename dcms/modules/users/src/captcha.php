<?php
//код который надо отобразить
if(isset(D::$session['stamp'])) {
    $stamp=D::$session['stamp'];
} else {
    $stamp = D::$session['stamp'] = md5(print_r($_SERVER,TRUE));
}
$code=substr(md5($stamp.$_SERVER['REMOTE_ADDR']),0,6);
$image=imagecreate(80, 20);
imagecolorallocate($image, 255, 255, 255);
$textcolor = imagecolorallocate($image, 0, 0, 0);
imagestring($image, 5, 8, 0, $code, $textcolor);
D::$session['captcha_code'] = $code;
header("Content-type: image/png");
imagepng($image);
exit;
?>