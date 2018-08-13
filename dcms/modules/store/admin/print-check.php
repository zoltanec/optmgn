<?php
$T['order'] = D_Core_Factory::Store_Cart(D::$req->int('param3'));
D::$Tpl->RenderTpl('dit:store;admin/print-check.tpl');return;
?>