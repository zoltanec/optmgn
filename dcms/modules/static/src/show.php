<?php
//пустой путь
$path = '';
//обрабатывать будем максимум 10 уровней вложенности
for($i=1;$i<=10;$i++) {
    $path.= D::$req->textID('param'.$i);
    //если запрошенный объект является файлом html
    if(is_file(D::$content_path."/static/".$path.".html")) {
        D::$Tpl->show(D::$content_path."/static/".$path.".html");
        D::sysExit();
    } elseif(is_dir(D::$content_path."/static/".$path)) {
        $path.="/";
    } else {
    	trigger_error("Can't find static template file: {$path}",E_USER_NOTICE);
    }
}
?>