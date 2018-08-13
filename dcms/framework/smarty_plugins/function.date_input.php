<?php
function smarty_function_date_input($params, &$engine) {
	$date = $params['date'];
	if(isset($params['name'])) {
		$name = $params['name'];
	} else {
		return 'WRONG_NAME';
	}
	//формат даты
	if(isset($params['format'])) {
		$format = $params['format'];
	} else {
		$format = '%Y-%m-%d';
	}
	//с какого года и по какой
	if(isset($params['maxyear'])) {
		$maxyear = $params['maxyear'];
	} else {
		$maxyear = strftime('%Y', time());
	}

	if(isset($params['minyear'])) {
		$minyear = ($params['minyear'] == 'this' ) ? strftime('%Y', time()) : $params['minyear'];
	} else {
		$minyear = strftime('%Y', time()) - 100;
	}

	$timeObject = new D_Core_Time($date, $format);
	$days = range(1,31);

	//обрабатываем дни
	$daysSelect = '';
	foreach($days AS $day) {
		if($timeObject->mday == $day) {
			$daysSelect.="<option value='{$day}' selected>{$day}\n";
		} else {
			$daysSelect.="<option value='{$day}'>{$day}\n";
		}
	}

	//обрабатываем месяцы
	$monthSelect = '';
	foreach(D_Core_Time::$monthes AS $monthId => $month) {
		if($timeObject->month == $monthId) {
			$monthSelect.= "<option value='{$monthId}' selected>{$month}\n";
		} else {
			$monthSelect.= "<option value='{$monthId}'>{$month}\n";
		}
	}

	//обрабатываем годы
	$yearSelect = '';
	$years = range($maxyear, $minyear);
	foreach($years  AS $year) {
		if($timeObject->year == $year) {
			$yearSelect.="<option value='{$year}' selected>{$year}\n";
		} else {
			$yearSelect.="<option value='{$year}'>{$year}\n";
		}
	}

	if(isset($params['time'])) {
		$append = "<input type='text' size='2' name='{$name}_hour' value='{$timeObject->hour}'>:<input type='text' size='2' name='{$name}_min' value='{$timeObject->min}'>";
	} else {
		$append = "";
	}

	return "<select name='{$name}_day'>".$daysSelect."</select>
	        <select name='{$name}_month'>".$monthSelect."</select>
	        <select name='{$name}_year'>".$yearSelect."</select>".$append;
}
?>