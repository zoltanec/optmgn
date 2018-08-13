<?php
/**
 * Exception codes
 */
define('EX_MODULE_NOT_FOUND', 1);
define('EX_MODULE_ACTION_NOT_FOUND', 2);
define('EX_CLASS_NOT_FOUND', 3);
define('EX_OTHER_ERROR', 4);
// objects exceptions
define('EX_NO_SUCH_OBJECT',  10000);
define('EX_NO_FETCH_METHOD', 10001);
define('EX_BAD_OBJECT',      10002);
define('EX_NO_SUCH_METHOD',  10003);
define('EX_ACCESS_DENIED' ,  10004);
// database exceptions
define('EX_BAD_DB_QUERY',    20000);


/**
 * Класс обработки ошибок
 */
class D_Core_Exception extends Exception {

	protected $error_code = 'EXCEPTION';

	function getError() {
		return 'ERROR_'.$this->error_code;
	}

	function RenderTrace() {
		$result = '';
		$trace = $this->getTrace();
		foreach($trace as $traceLine) {
			$result.="<tbody><tr class='exception_file'><td>".$traceLine['file'].':'.$traceLine['line']."</td></tr>\n";
			$result.="<tr class='exception_function'><td>";
			if(isset($traceLine['class'])) {
				$result.= $traceLine['class'].$traceLine['type'].$traceLine['function'];
			} else {
				$result.= $traceLine['function'];
			}
			$result.="</td></tr>";
			$result.="<tr><td class='exception_arguments'><pre>".print_r($traceLine['args'],true)."</pre></td></tr></tbody>";
		}
		return '<table>'.$result.'</table>';
	}

	function dump($file) {
		$data = '';
		foreach($this->getTrace() AS $line) {
			if(isset($line['file'])) {
				$data .= $line['file'].":".$line['line']."\n";
			} else {
				$data .= "\n";
			}
			// аргументы
			if(isset($line['args'])) {
				$args = @implode('","',$line['args']);
			} else {
				$args = '';
			}
			if(isset($line['class'])) {
				$data.= $line['class']." -> ".$line['function'].'("'.$args.'");';
			} else {
				$data.= $line['function'].'("'.$args.'");';
			}
			$data.="\n\n\n";
		}
		file_put_contents($file, $data);
		return true;
	}
}
?>