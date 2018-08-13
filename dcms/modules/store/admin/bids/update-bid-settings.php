<?php
try {
	$bid = D_Core_Factory::Store_Bids_Sessions(D::$req->int('prod_id'));
} catch (Exception $e) {
	$bid = new Store_Bids_Sessions();
	$bid->prod_id = D::$req->int('prod_id');
}
$str_time = D::$req->datetime('str_time');
$cls_time = D::$req->datetime('cls_time');

$bid->step = D::$req->float('step');
$bid->start_price = D::$req->int('start_price');
$bid->str_time = $str_time->timestamp;
$bid->cls_time = $cls_time->timestamp;
$bid->save();

D::$tpl->Redirect('~/edit-product/pid_'.$bid->prod_id);