<?php
$admin_settings = [
'admin.auth_mode' => 'config',
'admin.users' => ['service' => md5('administrator_default')]
];
// list of default module settings
D::$config->loadDefaultSettings($admin_settings);