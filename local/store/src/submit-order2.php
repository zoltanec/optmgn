<?php
$cart = Store_Cart::getCart();

if(!$cart){
	$T['status'] = 'EMPTY_CART';
} else {
	$order_phone   = D::$req->textLine('order_phone');
	$order_address = D::$req->textLine('order_address');
	$order_name    = D::$req->textLine('order_name');

	if(empty($order_phone)) {
		D::$tpl->PrintText('ERROR');
	}

	$order = new Store_Cart();
	D::$req->map($order,array('order_name'=>'textLine', 'order_phone'=>'textLine', 'order_address'=>'textLine', 'uid'=>'int', 'description' => 'textLine'));

	$T['status']='OK';
	$username = D::$req->textLine('order_phone');
	if(D::$config->{'store.need_users'}) {
		if(!D::$user) {
			try {
				D::$user = D_Core_Factory::Users_User($username);
			} catch (Exception $e) {
				$storeuser=new Store_Users();
				$storeuser->username = $order->order_phone;
				$storeuser->fullname = $order->order_name;
				$storeuser->address = $order->order_address;
				$storeuser->save();
				$T['status'] = 'REG_USER';
				$order->uid = $storeuser->uid;
				D::$user = $storeuser;
			}
		}
		$order->uid = D::$user->uid;
	} else {
		$order->uid = 0;
	}

	$order->payment = D::$req->select('payment',array_keys(Store_Cart::getPaymentModes()));
	$order->delivery = D::$req->int('delivery');
	if(D::$req->int('discount'))
		$order->discount=5;
	$order->save();
	$order->saveItems();
	if(D::$config->{'store.notify_client'}) {
		Notify_Sms::send($order->order_phone, D::$i18n->translate("STORE_YOUR_ORDER_ACCEPTED")." ".$order->code);
	}
	if(D::$config->{'store.notify_admin'}) {
		switch(D::$config->{'store.notify_admin_type'}) {
			case 'sms':
				Notify_Sms::send(D::$config->{'store.notify_admin_number'}, "Recieved new order. Call:".$username);
				break;
			default:
				$x = 0;
				break;
		}
	}
}