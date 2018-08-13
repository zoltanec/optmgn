<?php
$order = D_Core_Factory::Payments_Orders(D::$req->int('param1'));
$T['order'] = $order;
D::$tpl->setClearRendering();