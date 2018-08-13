<?php
setlocale(LC_ALL, "POSIX");
function smarty_modifier_convert_time($timestamp,$mode = 'default', $format = '') {

	$replace = array( "January"=> "Января","Jan" => "Янв", "February" => "Февраля","Feb" => "Фев","March" => "Марта","Mar" => "Мар","April" => "Апреля","Apr" => "Апр","May" => "Мая", "May" => "Мая",
	  "June" => "Июня", "Jun" => "Июн",  "July" => "Июля",  "Jul" => "Июл",   "August" => "Августа",  "Aug" => "Авг",
      "September" => "Сентября",  "Sep" => "Сен", "October" => "Октября",  "Oct" => "Окт", "November" => "Ноября", "Nov" => "Ноя",
      "December" => "Декабря", "Dec" => "Дек");
		if($mode == 'byformat') {
			return str_replace(array_keys($replace),array_values($replace), strftime($format,$timestamp));
		} else {
        	$tdiff = time()-$timestamp;
                 	//формируем массивы
            	$stamp_arr = localtime($timestamp,true);
            	$stamp_cur =localtime(time(),true);
            	if($stamp_arr['tm_yday'] == $stamp_cur['tm_yday'] AND $stamp_arr['tm_year'] == $stamp_cur['tm_year']) {
                	return 'сегодня, '.strftime('%R',$timestamp);
           		 } elseif ($stamp_arr['tm_yday'] == $stamp_cur['tm_yday'] -1  AND $stamp_arr['tm_year'] == $stamp_cur['tm_year']) {
                	return 'вчера, '.strftime('%R',$timestamp);
            	} else return str_replace(array_keys($replace),array_values($replace),strftime('%e %B %G %R',$timestamp));
		}
}
?>