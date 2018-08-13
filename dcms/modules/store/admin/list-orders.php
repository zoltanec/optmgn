<?php
if(D::$req->isAjax()) {
	$max_upd_time = (D::$req->int('max_upd_time') == 0 ) ? time() - D_Core_Time::SECONDS_IN_DAY : D::$req->int('max_upd_time');

	$orders = Store_Cart::find(['upd_time' => ['>', $max_upd_time] ], ['order' => 'upd_time ASC']);

	if(sizeof($orders) == 0 ) {
		D::$tpl->PrintText('');
	}
	$T['order'] = $orders[0];
	sleep(1);
	D::$tpl->RenderTpl('admin/single-order');
}
?>