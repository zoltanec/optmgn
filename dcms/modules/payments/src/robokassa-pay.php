<?php
$order = D_Core_Factory::Payments_Orders(D::$req->int('param1'));

$T['mrh_login'] = D::$config->{'payments.robokassa.login'};
$T['mrh_pass1'] = D::$config->{'payments.robokassa.password1'};

// номер заказа
// number of order
$T['inv_id'] = $order->ordid;

$T['inv_desc'] = $order->userdescr;

// сумма заказа
// sum of order
$T['out_summ'] = $order->sum;

// предлагаемая валюта платежа
// default payment e-currency
$T['in_curr'] = "";

// язык
// language
$T['culture'] = "ru";

// формирование подписи
// generate signature
$T['crc']  = md5("{$T['mrh_login']}:{$T['out_summ']}:{$T['inv_id']}:{$T['mrh_pass1']}");