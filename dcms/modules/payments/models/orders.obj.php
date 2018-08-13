<?php
class Payments_Orders extends D_Core_Object {
	use D_Db_ActiveRecord;

	const S_UNPAID = 0;
	const S_PAID   = 1;
	const S_ERROR  = 2;
	const S_ABUSE  = 3;

	public $add_time = 0;
	public $uri = '';
	public $psys = '';
	public $sum = 0;
	public $descr = '';
	public $userdescr = '';
	public $status = '';

	static function __pk() {
		return ['ordid'];
	}
	static function __fields() {
		return ['add_time', 'uri', 'psys','descr', 'userdescr', 'status', 'sum'];
	}

	static function getStatus() {
		/*
		 * 0 - заказ создан но не оплачен
		 * 1 - заказ оплачен
		 * 2 - ошибка заказа, с ним что то не так
		 * 3 - получен возврат по заказу
		 *
		 */
	}

	public function setStatus($status) {
		$this->object->setPaymentStatus($status, $this);
		$this->status = $status;
	}

	protected function __get_object() {
		return D_Core_Factory::getById($this->uri);
	}
}