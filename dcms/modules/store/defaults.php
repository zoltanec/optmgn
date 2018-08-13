<?php
$store_settings = [
    'store.products_perpage' => 500,
    'store.main_perpage' => 30,
    'store.auction' => false,
    'store.need_users' => false,
    'store.auto_create_users' => false,
    'store.notify_client' => false,
    'store.notify_admin'  => false,
    'store.notify_admin_type' => 'sms',
    'store.notify_admin_number' => '',
    'store.statuses' => ['0' => 'Waiting for approval', 1 => 'Approved', 2 => 'Waiting for payment', 3 => 'Paid', 4 => 'In progress', 5 => 'Completed'],
];
// list of default module settings
D::$config->loadDefaultSettings($store_settings);