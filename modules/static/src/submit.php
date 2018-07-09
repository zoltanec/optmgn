<?php
$url = 'https://wl.walletone.com/checkout/checkout/Index';
$post_data = [
    'WMI_MERCHANT_ID'    => 179527902334,
    'WMI_PAYMENT_AMOUNT' => 12345,
    'WMI_CURRENCY_ID'    => 643,
    'WMI_DESCRIPTION'    => 'Оплата демонстрационного заказа sportLandShop',
    'WMI_SUCCESS_URL'    => 'http://sportlandshop.ru/store/success',
    'WMI_FAIL_URL'       => 'http://sportlandshop.ru/store/fail',
];
$res = D_Misc_Url::curlInfo($url, $post_data);
D::$tpl->redirect($res['url']);