<?php
$cfg['dcmspath'] = '/home/www/kuksha/www.sportlopt.ru/public_html/dcms';
$cfg['path'] = dirname(dirname(__FILE__));
$cfg['default_module'] = 'static';
$cfg['debug'] = true;
$cfg['sys.core.allow_actions_override'] = true;
$cfg['databases'] = array('db' => array('user' => 'sportLand',
                                   'password' => 'stockwearAndry',
                                       'name' => 'sportLandStock_ru',
                                     'prefix' => 'sh'));
$cfg['site_name'] = "sportLand";

$cfg['admin_auth_mode'] = "config";
$cfg['admin.users'] = array('user' => md5('gfhjkm'));
$cfg['store.notify_admin_number'] = '89128053535';
$cfg['notify.sms.smsru_key']  = '561C754B-B46B-41B4-C878-1F6EAEFA413A';
$cfg['notify.sms.smsru_from'] = '79615785433';
$cfg['store.notify_admin'] = true;
$cfg['store.notify_admin_type'] = 'sms';
$cfg['store.orders.minimum_amount'] = 300;
$cfg['store.delivery.self_discount'] = 5;
$cfg['store.statuses']  = ['Ожидает оплаты', 'Оплачен', 'Доставка', 'Завершен'];
$cfg['store.discounts'] = [
    '20 000' => [
		'bound' => 20000,
        'class' => 'green',
        'title' => 'Зелёная',
        'cff'   => 0.95,
    ],
    '80 000' => [
		'bound' => 80000,
        'class' => 'blue',
        'title' => 'Синяя',
        'cff'   => 0.93,
    ],
    '200 000' => [
		'bound' => 200000,
        'class' => 'red',
        'title' => 'Красная',
        'cff'   => 0.9,
    ],
];

$cfg['notify.sms.provider'] = 'smsru';
$cfg['notify.sms.user'] = 'bnman';
$cfg['notify.sms.pwd'] = 'ghjcnfr';

$cfg['vk.social']        = 'https://vk.com/club158884504';
$cfg['instagram.social'] = 'https://www.instagram.com/sportlandshopp/';
$cfg['feedback_type'] = 'email';
$cfg['email'] = 'sportlandshop@mail.ru';
$cfg['phone'] = '8 912 805-35-35';
$cfg['messanger'] = '8 951 448-00-00';
?>
