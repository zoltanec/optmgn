<?php
if(!isset($_SESSION))
	session_start();
if(D::$req->int('cartid'))
	$_SESSION['cart'][count($_SESSION['cart'])+1]=$_SESSION['cart'][D::$req->int('cartid')];
if(D::$req->isAjax()){
	D::$Tpl->renderTpl("store;list-cart-prod");
}else exit;
?>