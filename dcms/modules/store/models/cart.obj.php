<?php
class Store_Cart extends D_Core_Object implements Payments_Payable {
	use D_Db_ActiveRecord;

	const CODE_SIZE = 4;

	public $order_id = 0;
	//Идентификатор продукта
	public $prod_id = 0;
	//Наименование
	public $order_name = '';
	//Количество
	public $quantity;
	//Цена
	public $order_phone;
	//Пользователь
	public $order_address;
	public $description = '';
	static $cacheself = 60;
	public $uid = 0;
	public $delivery = 0;
	public $payment = 0;
	public $add_time = 0;
	public $upd_time = 0;


	static protected function __pk() {
		return ['order_id'];
	}

	static protected function __table() {
		return '#PX#_store_orders';
	}

	static protected function __fields() {
		return ['order_phone', 'order_name', 'order_address', 'add_time', 'upd_time', 'uid', 'description', 'status', 'code', 'payment', 'delivery', 'delivery_payment', 'discount'];
	}

	protected function __new() {
		$this->add_time = time();
		$this->code = self::getNewCode();
	}

	public function getPaymentDescr() {
		return "Заказ {$this->code}, на адрес {$this->order_address}.";
	}

	public function setPaymentStatus($status = 0) {
		if($status == 1) {
			Notify_Sms::send($this->order_phone, vsprintf(D::$i18n->translate('STORE_ORDER_PAYED'),[$this->code]));
			$this->status = 3;
			$this->save();
		}
	}


	public function setOrderStatus($new_status) {
		if($new_status == 1) {
			$sms = D::$i18n->translate('STORE_YOUR_ORDER_APPROVED');
			if($this->payment == 3 ) {
				$sms.= D::$i18n->translate('STORE_YOU_CAN_PAY_FOR_ORDER')." ".$this->code;
			}
			Notify_Sms::send($this->order_phone, $sms);
		}
	}

	public function isPayable() {
		return (1 == $this->status);
	}

	static public function getStatuses() {
		return D::$config->{'store.statuses'};
	}

	static function getPaymentModes() {
		return [1 => 'Наличные при получении', 2 => 'Банковской картой при получении', 3 => 'Банковской картой / электронными деньгами'];
	}

	static function getDeliveryModes() {
		$delivery = D_Core_Factory::Store_Category('dostavka');
		return $delivery->products;
	}

	protected function __get_payment_name() {
		return self::getPaymentModes()[$this->payment];
	}

	protected function __get_status_name() {
		return self::getStatuses()[$this->status];
	}

	static function getNewCode() {
		$x = 0;
		$str = '';
		while($x < 40) {
			$str = strtoupper(D_Misc_Random::getString(self::CODE_SIZE, ['A','B','E','F','H','K','M','N','P','R','T','U','X','Y','Z','2','3','4','5','6','7','8','9']));
			$obj = self::find(['code' => $str ], ['limit' => 1]);
			$x++;
			if(is_object($obj)) {
				continue;
			}
		}
		return $str;
	}

	function saveItems() {
		if(!isset($_SESSION)) {
    		session_start();
   		}

   		$cart = D::$session['cart'];

		foreach($cart as $pack_id=>$pack){
			foreach($pack as $hash => $data) {
				if($data['quantity'] == 0 ) continue;
					$prod_id = $data['prod_id'];
				if(!isset($data['meta'])) {
					$meta = '';
				} else {
					$meta = base64_encode(serialize($data['meta']));
				}
					$item = new Store_CartItem();
					$item->pack_id($pack_id)->order_id($this->order_id)->hash($hash)->quantity($data['quantity'])->prod_id($prod_id)->price($data['price']);
					$item->descr = $data['descr'];
				$item->save();
			}
		}
		D::$session['cart'] = array();
	}

	//!Сохранить
	function __save() {
		if($this->order_id == 0 ) {
			$this->__new();
		}
		$this->__save_record();
	}

	protected function __get_sum() {
		$sum = 0;
		foreach($this->getOrderPacks() AS $pack) {
			foreach($pack AS $product) {
				$sum += $product->price * $product->quantity;
			}
		}
		return $sum;
	}

	protected function __get_delivery_info() {
		if($this->delivery == 0 ) return false;
		return D_Core_Factory::Store_Product($this->delivery);
	}

	//!Формирование списка заказов для админки
	function getOrderPacks() {
		$cart = array();
		$products = Store_CartItem::find(['order_id' => $this->order_id]);

		foreach ($products as $product) {
			if(!isset($cart[$product->pack_id])) {
				$cart[$product->pack_id] = array();
			}

			$product->meta = unserialize(base64_decode($product->meta));
			$cart[$product->pack_id][$product->hash] = $product;
			try {
				$cart[$product->pack_id][$product->hash]->obj = D_Core_Factory::Store_Product($product->prod_id);
			} catch (Exception $e) {
				$cart[$product->pack_id][$product->hash]->obj = new stdClass();
			}
		}
		return $cart;
	}

	//!Получение последнего заказа из корзины
	static function getNewOrdersCol($check_time){
		return D::$db->fetchvar("SELECT COUNT(1) FROM #PX#_store_orders WHERE add_time >= {$check_time}");
	}

	//!Проверка есть ли товар в корзине
	static function checkProd($check_prod_id){
		$cart=self::getCart();
		if($cart){
			foreach($cart as $pack){
				foreach($pack as $hash => $data){
					if($check_prod_id == $data['prod_id']){
						return true;
						break;
					}
				}
			}
		}
		return false;
	}
	static function setDelivery($nodelivery = true){
		if($nodelivery)
			D::$session['delivery'] = false;
		else  D::$session['delivery'] = true;
	}
	
	static function setDiscount($discount){
		D::$session['discount']=$discount;
	}
	
	//!Проверка установлен ли самовывоз
	static function checkDelivery(){
		if(!isset($_SESSION)){
			session_start();
		}
		if(!isset($_SESSION['delivery'])){
		      $_SESSION['delivery']=true;
		}
		return $_SESSION['delivery'];
	}
    
    static function getDelivery(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(!isset($_SESSION['delivery'])){
		      $_SESSION['delivery'] = [];
		}
		return $_SESSION['delivery'];
    }
	
	static function checkDiscount(){
		if(!isset($_SESSION)){
			session_start();
		}
		if(!isset($_SESSION['discount'])){
		      $_SESSION['discount']=false;
		}
		return $_SESSION['discount'];
	}
	
	static function getDiscount(){
		$discount=self::checkDiscount();
		$delivery=self::checkDelivery();
		if ($delivery==false && $discount)
			return 0.9;
		elseif ($discount)
			return 0.95;
		elseif ($delivery==false)
			return 0.95;
		else return false;
	}

	//!Сортировка корзины при удалении пакетов
	static function sortCart(){
		$cart=self::getCart();
    	if($cart) {
    		$index=1;
    		unset($_SESSION['cart']);
    		foreach($cart as $pack_id=>$pack){
    			if(isset($_SESSION['cur_pack'])){
    				if($_SESSION['cur_pack']==$pack_id)
    					$_SESSION['cur_pack']=$index;
    			}
    			$_SESSION['cart'][$index]=$pack;
    			$index++;
    		}
    	}return $_SESSION['cart'];
	}

	//!Получить текущий активный пакет, куда кидается продукция
	static function getPack(){
		if(!isset($_SESSION)){
    		session_start();
    	}
    	if(!isset($_SESSION['cur_pack'])){
    		return false;
    	}
    	return $_SESSION['cur_pack'];
	}
	//!Получить корзину полностью
    static function getCart(){
    	if(!isset($_SESSION)){
    		session_start();
    	}
    	if(!isset($_SESSION['cart'])){
    		return false;
    	}
    	return $_SESSION['cart'];
    }

    //!Получить сумму стоимости продуктов в пакете
    static function getPackSum($pack_id){
    	$total_cost = $total_quantity=0;
    	$cart = self::getCart();

    	if(!$cart) {
    		return false;
    	}

    	if(!isset($cart[$pack_id])) return 0;

    	foreach($cart[$pack_id] as $hash => $data){
		   	$prod=D_Core_Factory::Store_Product($data['prod_id']);

		   	$total_cost += $prod->current_price * $data['quantity'];

		    $total_quantity+=$data['quantity'];
    	}

    	return array('total_cost'=> $total_cost, 'total_quantity'=>$total_quantity);
    }

    //!Получить сумму стоимости продуктов в корзине
    static function getCartSum() {
    		$cart = self::getCart();
    		$total_cost=0;
    		$total_quantity=0;
    		if($cart) {
	    		foreach($cart as $pack) {
		    			foreach($pack as $hash => $data) {
		    				$prod = D_Core_Factory::Store_Product($data['prod_id']);
                            if($prod->getBoxQt()){
                                //В данном случае $data['quantity'] - это количество коробок
                                //.getBoxQt - количество пар в коробке
                                $total_cost += $prod->current_price * $data['quantity'] * $prod->getBoxQt();
                            } else {
                                $total_cost += $prod->current_price * $data['quantity'];
                            }
		    				$total_quantity +=$data['quantity'];
		    			}
	    		}
	    		return array('total_cost' => $total_cost, 'total_quantity' => $total_quantity);
    		} else return false;
    }

    // получаем товары которые скрыты от обычного пользователя
    static function getProductFromCart($prod_id) {
    	$cart = self::getCart();
    	foreach($cart AS $pack_id => $pack) {
    		foreach($pack AS $hash => $product) {
    			if($product['prod_id'] == $prod_id) {
    				$product['pack'] = $pack_id;
    				$product['hash'] = $hash;
    				return $product;
    			}
    		}
    	}
    	return false;
    }

    //!Получить все заказы
	static function getOrders($active){
		$status = ( $active ) ? " status != 5" : " status = 5 ";
		return D::$db->fetchobjects("SELECT * FROM #PX#_store_orders WHERE {$status} ORDER BY status ASC,add_time DESC",__CLASS__);
	}

	static function getLastOrders($status = 0) {
		return self::find(['status' => $status, 'upd_time' => ['>=', time() - 86400 ]],['order' => 'upd_time DESC']);
	}


}
?>
