<?php

$T['order'] = D_Core_Factory::Store_Cart(D::$req->int('param3'));
D::$tpl->addBC('~/orders-archive/',D::$i18n->translate('STORE_ORDER_LIST'));
?>