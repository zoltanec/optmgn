<?php
$T['product'] = D_Core_Factory::Store_Product(D::$req->int('pid'));
D::$tpl->addBC('~/edit-product/pid_'.$T['product']->prod_id, $T['product']->name);
