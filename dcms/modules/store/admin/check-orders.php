<?php
session_start();
if(isset($_SESSION['check_time'])){
	$count=Store_Cart::getnewOrdersCol($_SESSION['check_time']);
	if($count>0){
		unset($_SESSION['check_time']);
		echo $count;exit;
	}
}else{
	$_SESSION['check_time']=time();
}
exit;
?>