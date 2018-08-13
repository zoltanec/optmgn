<?php
interface Payments_Payable {
	public function getPaymentDescr();
	public function setPaymentStatus($status = '');
	public function isPayable();
}
?>