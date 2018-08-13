<?php
class D_Core_Time extends D_Core_Object {
	/**
	 * Количество секунд в одном часе
	 */
	const SECONDS_IN_HOUR = 3600;
	const SECONDS_IN_DAY = 86400;

	private $tm_struct = array('tm_hour'=> 0, 'tm_min'=>0, 'tm_year'=>0, 'tm_mon'=>0, 'tm_mday'=>1);
	//spisok vseh mesyacev
	static public $monthes = array(1=>'Январь',2=>'Февраль',3=>'Март',4=>'Апрель',5=>'Май',6=>'Июнь',7=>'Июль',8=>'Август',9=>'Сентябрь',10=>'Октябрь',11=>'Ноябрь',12=>'Декабрь');
	static public $monthesOf = array(1=>'Января',2=>'Февраля',3=>'Марта',4=>'Апреля',5=>'Мая',6=>'Июня',7=>'Июля',8=>'Августа',9=>'Сентября',10=>'Октября',11=>'Ноября',12=>'Декабря');

	function __construct($time = '', $format = '' ) {
		if(empty($format) and preg_match('/\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}:\d{2}/',$time)) {
			$this->tm_struct = strptime($time,'%Y-%m-%d %X');
		} elseif(!empty($format)) {
			$this->tm_struct = strptime($time, $format);
		} elseif(!empty($time)) {
			$this->tm_struct = localtime($time, true);
		} else {
			$this->tm_struct = localtime(time(), true);
		}
	}

	//generaciya novogo obyekta iz formata vremeni MySQL
	static function fromSqlTime($time) {
		$tm_sruct = strptime($time,'%Y-%m-%d %X');
	}
	function timestamp() {
		return mktime($this->tm_struct['tm_hour'],$this->tm_struct['tm_min'],$this->tm_struct['tm_sec'],$this->tm_struct['tm_mon']+1,$this->tm_struct['tm_mday'],1900 + $this->tm_struct['tm_year']);
	}

	function __get_datetime() {
		return strftime('%Y-%m-%d %T', $this->timestamp());
	}

	function __get_date() {
		return strftime('%Y-%m-%d', $this->timestamp());
	}

	function format($strftime_format = '%Y/%m/%d %R') {
		return strftime($strftime_format, $this->timestamp());
	}


	/**
	 * работаем с временем как с INT
	 **/

	function __get_timestamp() {
		return $this->timestamp();
	}

	/**
	 * Работаем с временем как с timestamp
	 * @param int $timestamp
	 */
	function __set_timestamp($timestamp) {
		$this->tm_struct = localtime($timestamp,true);
	}

	function __get_year() {
		return $this->tm_struct['tm_year'] + 1900;
	}
	// year setters and getters
	function __set_year($year = 2000) {
		$this->tm_struct['tm_year'] = $year - 1900;
	}


	// zagrugaem nomer mesyaca
	function __get_month() {
		return $this->tm_struct['tm_mon'] + 1;
	}
	function __set_month($month = 1) {
		$this->tm_struct['tm_mon'] = $month - 1;
	}

	function __get_hour() {
		return $this->tm_struct['tm_hour'];
	}
	function __set_hour($hour = 0) {
		$this->tm_struct['tm_hour'] = $hour;
	}

	//den nedeli
	function __get_mday() {
		return $this->tm_struct['tm_mday'];
	}
	function __set_mday($mday = 1) {
		$this->tm_struct['tm_mday'] = ($mday > 0 and $mday <=31) ? $mday : 1;
	}

	function __get_wday() {
		return $this->tm_struct['tm_wday'];
	}


	function __get_sec() {
		return $this->tm_struct['tm_sec'];
	}

	//minuti
	function __get_min() {
		return $this->tm_struct['tm_min'];
	}
	function __set_min($min = 0) {
		$this->tm_struct['tm_min'] = ($min >= 0 and $min < 60 ) ? $min : 0;
	}

	//полное название месяца
	function __get_month_full() {
		return self::$monthes[$this->month]." ".$this->year;
	}
	function __get_month_of() {
		return self::$monthesOf[$this->month];
	}

	//идентификатор дня
	function __get_day_full() {
		$month = ($this->month > 9) ? $this->month : '0'.$this->month;
		$day = ($this->mday > 9) ? $this->mday : '0'.$this->mday;
		return $this->year.'.'.$month.'.'.$day;
	}

	function __save() { }
	static function __fetch($id = '') { }
	function object_id() { }

	/**
	 * Делаем SQL время из timestamp'а
	 */
	static function from_unixtime($timestamp) {
		$time = new self($timestamp);
		return $time->datetime;
	}
	static function unix_timestamp($sqltime) {
		$time = new self($sqltime);
		return $time->timestamp;
	}

	/**
	 * С какой секунды начинается этот день
	 *  ...
	 */
	function __get_day_start() {
		return $this->timestamp - $this->hour * 3600 - $this->min * 60 - $this->sec;
	}
	/**
	 * Какой секундой день заканчивается
	 */
	function __get_day_end() {
		return $this->day_start + self::SECONDS_IN_DAY;
	}
	/**
	 * Возвращаем как строку
	 */
	function __toString() {
		return $this->datetime;
	}

	function __get_day_ru() {
        $month = ($this->month > 9) ? $this->month : '0'.$this->month;
        $day = ($this->mday > 9) ? $this->mday : '0'.$this->mday;
        return $day.'.'.$month.'.'.$this->year;
    }


	/**
	 * Следующий месяц, год
	 */
	function __get_next_month() {
		//определяем следующий месяц так, это начало этого месяца + 45 дней, то есть середина следующего месяца
		$nextMonth = new D_Core_Time($this->timestamp + self::SECONDS_IN_DAY * ( 45 - $this->mday ));
		return array('year' => $nextMonth->format('%Y'), 'month' => $nextMonth->format('%m'));
	}

	function __get_next_month_start_sec() {
		return $this->timestamp + self::SECONDS_IN_DAY * ( 45 - $this->mday );
	}

	function __get_prev_month_end() {
		$prev_month = new self($this->month_start_sec - 1);
		return $prev_month;
	}
	function __get_next_month_start() {
		return new D_Core_Time($this->next_month_start_sec);
	}

	function __get_month_start_sec() {
		return $this->timestamp
		        - ( $this->mday - 1 ) * D_Core_Time::SECONDS_IN_DAY
			- $this->hour * 3600
			- $this->min * 60
			- $this->sec;
	}

	function __get_week_start_sec() {
		$wday = ($this->wday == 0 ) ? 7 : $this->wday;
		return $this->timestamp
			- ( $wday - 1 ) * D_Core_Time::SECONDS_IN_DAY
			- $this->hour * 3600
			- $this->min * 60
			- $this->sec;
	}

	function __get_next_day() {
		return new D_Core_Time($this->timestamp + 86400);
	}

	function __get_prev_day() {
		return new D_Core_Time($this->timestamp - 86400);
	}

	/**
	 * Возвращает массив дней календаря для указанного месяца и года
	 *
	 * @param string $monthnum - номер месяца в формате MM;
	 * @param string $yearnum - год в формате YYYY;
	 */
	static function getCalendar($monthnum = '01', $yearnum = '2000', $weekmode = false) {
		$time = new self($yearnum.'-'.$monthnum.'-01 00:00:01');
		$days = array();
		for($day_start = $time->week_start_sec, $cols = 0, $row = 0; $day_start < $time->week_start_sec + self::SECONDS_IN_DAY * 42; $day_start += self::SECONDS_IN_DAY, $cols++ ) {
			if($cols == 7 ) {
				$row++;
				$cols = 0;
			}
			$day = new D_Core_Time($day_start + 4000);
			if($day->month != $time->month) {
				$day->other_month = true;
			}
			$days[$row][] = array('day' => $day);
		}
		return $days;
	}

	protected function __object_id() {
		return array($this->timestamp);
	}

	/**
	 * проверяем что время находится в текущем дне
	 */
	function today($timestamp) {

	}

	function __get_day_talk() {
		return $this->format('%R');
		if($this->timestamp > $this->now->day_start and $this->timestamp < $this->now->day_end) {
			return 'Сегодня';
		} elseif ($this->timestamp > $this->now->day_start - SECONDS_IN_DAY and $this->timestamp < $this->now->day_end - SECONDS_IN_DAY) {
			return 'Вчера';
		} elseif ($this->timestamp > $this->now->day_start + SECONDS_IN_DAY and $this->timestamp < $this->now->day_end + SECONDS_IN_DAY) {
			return 'Завтра';
		} else {
			return self::$monthes[$this->month].', '.$this->mday;
		}
	}

	/**
	 * Возвращаем объект времени характеризующий сегодняшний день
	 */
	function __get_now() {
		return new dTime(time());
	}

	static function Now() {
		return new self(time());
	}

	function isLeapYear() {
		return false;
	}
}
?>