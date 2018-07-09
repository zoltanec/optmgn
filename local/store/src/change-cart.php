<?php
$cart = D::$session['cart'];
$pack_id = D::$req->int('pack');
$hash = D::$req->textID('hash');

if(empty($hash)) D::$tpl->renderTpl('order-content');

$action = D::$req->textID('action');
$cart = D::$session['cart'];

switch($action) {
	// delete product from pack
	case "del" :
		if(!isset($cart[$pack_id])) {
			break;
		}
		if(!isset($cart[$pack_id][$hash])) {
			break;
		}
		unset($cart[$pack_id][$hash]);

		//delete empty pack
		if(sizeof($cart[$pack_id]) == 0 ) {
			unset($cart[$pack_id]);
		}
		break;

	// duplicate packet in pack
	case "dubl":
		if(!$pack_id){
			$_SESSION['cart'][count($_SESSION['cart'])+1] = array();
		}else{
			$_SESSION['cart'][count($_SESSION['cart'])+1] = $_SESSION['cart'][$pack_id];
		}
		break;

	case "plus":
	case "minus":
		if(!isset($cart[$pack_id])) break;
		if(!isset($cart[$pack_id][$hash])) break;

		if($action == 'plus') {
			$cart[$pack_id][$hash]['quantity']++;
		} else {
			if($cart[$pack_id][$hash]['quantity'] > 0 ) {
				$cart[$pack_id][$hash]['quantity']--;
			}
		}
		break;
}
D::$session['cart'] = $cart;

$T['cart'] = Store_Cart::sortCart();
$T['cart_total'] = Store_Cart::getCartSum();

$total = Store_Cart::getPackSum($pack_id);
D::$tpl->PrintJSON(["success" => "1", "total" => $total['total_cost']]);
?>