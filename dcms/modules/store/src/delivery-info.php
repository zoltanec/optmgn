<?php
$area = D::$req->textLine('area');
$region = D::$req->textLine('region');
$T['freeDelivery'] = true;
$T['postPrice'] = 490;
$T['sdekPrice'] = 590;

if($region == 'Башкортостан' 
    || $region == 'Оренбургская' 
    || $region == 'Челябинская' 
    || $region == 'Свердловская') {
    $T['postPrice'] = 290;
    $T['sdekPrice'] = 490;
}

if($region == 'Сахалинская' 
    || $region == 'Саха /Якутия/' 
    || $region == 'Чукотский' 
    || $region == 'Магаданская'
    || $region == 'Камчатский'
    || $region == 'Амурская'
    || $region == 'Приморский'
    || $region == 'Хабаровский'
    || $region == 'Еврейская'
    || $area == 'Таймырский Долгано-Ненецкий') {
    $T['freeDelivery'] = false;
}