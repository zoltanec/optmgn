<?php
try {
	$T['order'] = Store_Cart::get(['code' => D::$req->textID('code')],['limit' => 1]);
} catch (Exception $e) {
	D::$tpl->show('no-such-order');
}
if(D::$req->isAjax()) {
	D::$tpl->PrintJSON( [ 'status' => 'OK', 'upd_time' => $T['order']->upd_time ] );
}
?>