<?php
$day = D::$req->date('day');
if($day == '1970-01-01') {
	$day = D_Core_Time::now()->format('%Y-%m-%d');
}
$orders = Store_Cart::find(["DATE(FROM_UNIXTIME(add_time))" => $day], ["order" => "add_time DESC"]);

$T['cday'] = new D_Core_Time($day." 00:00:00");

// lets calculate sum and other statistics
$stat = ['count' => 0, 'sum' => 0];
foreach($orders AS &$order) {
	$stat['count']++;
	$stat['sum'] += $order->sum;
}
$T['stat'] = &$stat;
$T['orders'] = &$orders;
$month=$T['cday']->format('%m');
$year=D_Core_Time::now()->format('%Y');
$T['calendar']=D_Core_Time::getCalendar($month,$year);
?>