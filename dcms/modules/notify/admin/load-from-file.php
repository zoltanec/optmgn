<?php
$data = file_get_contents(D::$config->work_dir."/num.txt");
foreach(explode("\n", $data) AS $number) {
	// ищем дубли
	$old = Notify_Delivery_Messages::find(['address' => $number ],['limit' => 1]);

	if(is_object($old)) {
	//	var_dump($old);
		echo "Found in database {$number}<br>";
		continue;
	}

	$msg = new Notify_Delivery_Messages();
	$msg->address = $number;
	$msg->msg = "Дорогие гости! Мы открыли для вас доставку от сети заведений Рестогрупп: CITYBAR, CityFood, Печеная картошка. Приём заказов: www.tarelka.com т.400-000";
	$msg->save();
}
//var_dump($data);
exit;
?>