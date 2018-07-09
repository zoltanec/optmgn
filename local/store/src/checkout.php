<?php
$cart = Store_Cart::getCart();
if (!$cart) {
   D::$Tpl->redirect('/'); 
}

$step = D::$req->textLine('action');

if (!$step) {
    $T['step'] = $step = 'order-form';
}
$T['cart_total']   = Store_Cart::getCartSum();
$T['deliveryInfo'] = $deliveryInfo = D::$session['delivery'];
$T['payInfo']      = $payInfo      = D::$session['payment'];
$userInfo          = D::$session['formData'];
if($T['cart_total']['total_cost'] > 5000) {
    $T['prepay'] = true;
} else {
    $T['prepay'] = false;
}

if (D::$req->textLine('param1') == 'delivery') {
    $formData = false;
    if($_POST['form-data']) {
        $formData = D::$req->textLineArray('form-data');
    }
    
    $errorFilled = [];
    $formFilled = [];
    
    if ($formData) {
        foreach($formData as $field) {
            $formFilled[$field['name']] = $field['value'];
            if ($field['name'] == 'u_korpus' || $field['name'] == 'u_note' || $field['name'] == 'u_area')
                continue;
            if (preg_match('/^\s*$/', $field['value'], $match)) {
                $errorFilled[] = $field['name'];
            }
        }
        
        if ($errorFilled) {
            D::$session['errorFilled'] = $errorFilled;
            D::$tpl->PrintJSON(["error" => true, "msg" => "Заполните обязательные поля!", "step" => 0]);
        }
        
        $orderData['order_phone']   = $formFilled['u_tel'];
        $orderData['order_email']   = $formFilled['u_mail'];
        $orderData['order_descr']   = $formFilled['u_note'];
        $orderData['order_name']    = $formFilled['u_family'] . ' '
            . $formFilled['u_name'] . ' ' 
            . $formFilled['u_otch'];
        $orderData['order_address'] = $formFilled['u_region'] . ' ' 
            . $formFilled['u_zip']  . ' '
            . $formFilled['u_city'] . ' '
            . $formFilled['u_area'] . ' '
            . $formFilled['u_street'] . ' '
            . $formFilled['u_home'] . ' '
            . $formFilled['u_korpus'] . ' '
            . $formFilled['u_room'] . ' '
            . $formFilled['u_pref_region'] . ' '
            . $formFilled['u_pref_district'] . ' '
            . $formFilled['u_pref_city'] . ' ';
        D::$session['formData']    = $orderData;
        D::$session['formFilled']  = $formFilled;
        D::$session['errorFilled'] = [];
    }
    
    $area = $formFilled['u_area'];
    $region = $formFilled['u_region'];
    $T['freeDelivery'] = true;
    $T['postPrice'] = 490;
    $T['sdekPrice'] = 590;
    
    if($region == 'Башкортостан' 
        || $region == 'Оренбургская' 
        || $region == 'Челябинская' 
        || $region == 'Свердловская') {
        $T['postPrice'] = 290;
        $T['sdekPrice'] = 490;
    }

    if($region == 'Сахалинская' 
        || $region == 'Саха /Якутия/' 
        || $region == 'Чукотский' 
        || $region == 'Магаданская'
        || $region == 'Камчатский'
        || $region == 'Амурская'
        || $region == 'Приморский'
        || $region == 'Хабаровский'
        || $region == 'Еврейская'
        || $area == 'Таймырский Долгано-Ненецкий') {
        $T['freeDelivery'] = false;
    }
    
}

if (D::$req->textLine('param1') == "check-delivery") {
    $deliveryId = D::$req->textLine('deliveryId');
    D::$session['delivery'] = ['id' => $deliveryId, 'cost' => D::$req->textLine('deliveryCost')];
    D::$tpl->PrintJSON(["success" => "1", "action" => $step, "deliveryId" => $deliveryId]);
}

if (D::$req->textLine('param1') == "check-pay") {
    $payMethodId = D::$req->textLine('payMethodId');
    D::$session['payment'] = ['id' => $payMethodId];
}

if (D::$req->textLine('param1') == "submit") {
    if (!$deliveryInfo) {
        D::$tpl->PrintJSON(["error" => true, "msg" => "Выберите способ доставки!", "type" => "delivery", "step" => 1]);
    }
    
    if (!$payInfo && $deliveryInfo['id'] != 7 && $deliveryInfo['id'] != 8) {
        D::$tpl->PrintJSON(["error" => true, "msg" => "Выберите способ оплаты!", "type" => "pay", "step" => 2]);
    }
    
    $order = new Store_Cart();

    $order->order_name    = D::$session['formData']['order_name'];
    $order->order_phone   = D::$session['formData']['order_phone'];
    $order->order_address = D::$session['formData']['order_address'];
    $order->description   = D::$session['formData']['order_descr'];

    //$order->payment = D::$req->select('payment',array_keys(Store_Cart::getPaymentModes()));
	$order->delivery = D::$session['delivery']['id'];
    $order->delivery_payment = D::$session['delivery']['cost'];
    
	$order->discount = 0;
	$order->save();
	$order->saveItems();
    
	if(D::$config->{'store.notify_admin'} = false) {
		switch(D::$config->{'store.notify_admin_type'}) {
			case 'sms':
				Notify_Sms::send(D::$config->{'store.notify_admin_number'}, "Recieved new order. Call:".$username);
				break;
			default:
				$x = 0;
				break;
		}
	}
    
    $checkoutCost = $T['cart_total']['total_cost'];

    if($order->delivery != 8) {
        if($order->delivery == 7) {
            $checkoutCost = 1000;
        }
        $url = 'https://wl.walletone.com/checkout/checkout/Index';
        $post_data = [
            'WMI_MERCHANT_ID'    => 179527902334,
            'WMI_PAYMENT_AMOUNT' => $checkoutCost,
            'WMI_CURRENCY_ID'    => 643,
            'WMI_DESCRIPTION'    => 'Оплата заказа в интернет магазине sportLandShop.ru',
            'WMI_SUCCESS_URL'    => 'http://sportlandshop.ru/store/success-pay',
            'WMI_FAIL_URL'       => 'http://sportlandshop.ru/store/fail-pay',
        ];
        $res = D_Misc_Url::curlInfo($url, $post_data);
    } else {
        $res['url'] = 'http://sportlandshop.ru/store/success-pay';
    }
    D::$tpl->PrintJSON(["success" => true, "type" => "pay", "form" => 0, "url" => $res['url']]);
}

if (D::$req->textLine('param1') == "pay" && !$deliveryInfo) {
    D::$tpl->PrintJSON(["msg" => "Выберите способ доставки!", "step" => 1]);
}

$T['totalCost'] = $T['cart_total']['total_cost'] + $T['deliveryInfo']['cost'];

if (D::$req->isAjax()) {
    if($step == 'pay' && $deliveryInfo['id'] == 8) {
        $step = 'post';
    }
    $html = D::$tpl->fetch_output("store;" . $step);
    D::$tpl->PrintJSON(["success" => "1", "html" => $html, "action" => $step]);
}