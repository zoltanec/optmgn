<?php
class D_Db_PDO extends D_Db_Driver {
	// connect data
	private $username = '';
	private $password = '';
	private $dbname = '';
	private $host = '';
	private $port = '';
	// PDO private object
	private $descriptor_read = false;
	private $descriptor_write = false;
	private $write = false;


	function __construct($host, $username, $password,$dbname, &$dbCacher = NULL, $prefix = 'd') {
		//try {
		//	$this->descriptor = new PDO('mysql:host=localhost;dbname='.$dbname, $username, $password);
		//} catch (Exception $e) {
		//	die("Unable: ".$e->getMessage());
		//}
		$this->host = $host;
		$this->dbname = $dbname;
		$this->username = $username;
		$this->password = $password;
		$this->prefix = $prefix;
        //выполняем смену кодировки
        return TRUE;
	}

	public function getWriter() {
		$writer = clone $this;
		$writer->descriptor_read = &$this->descriptor_write;
		return $writer;
	}

	protected function __fetchvar($query, $arguments = []) {

		$st = $this->descriptor_read->prepare($query);

		$st->execute($arguments) or $this->getSQLerror($st);

		$arr = $st->fetch(PDO::FETCH_NUM);
		return $arr[0];
	}

	protected function __fetchline($query) {
		$result = $this->descriptor_read->query($query) or $this->getSQLerror();
		$line = $result->fetch(PDO::FETCH_ASSOC);
		$result->closeCursor();
		return $line;
	}


	protected function __fetchobjects($query,$class_name = 'stdClass', $arguments = []) {
		if(!class_exists($class_name)) throw new D_Core_Exception("No such class {$class_name}", EX_CLASS_NOT_FOUND);

		$statement = $this->descriptor_read->prepare($query);

		$statement->execute($arguments) or $this->getSQLerror($statement);

		$results = $statement->fetchAll(PDO::FETCH_CLASS, $class_name);

		$i = 1;
		foreach($results AS &$object) {
			$object->num = $i;
			$i++;
		}
		return $results;
	}

	protected function __fetchobjects_clear($query,$class_name = 'stdClass') {
		if(!class_exists($class_name)) throw new D_Core_Exception(EX_CLASS_NOT_FOUND);

		$db_results = $this->descriptor_read->query($query,PDO::FETCH_CLASS,$class_name) or $this->getSQLerror();
		$results = array();
		$meta = $db_results->getColumnMeta(0);
		$name = $meta['name'];
		$i = 1;
		foreach($db_results AS $object) {
			$object->num = $i;
			$i++;
			$results[$object->{$name}] = $object;
		}
		$db_results->closeCursor();
		return $results;
	}

	public function quote($string) {
		return $this->descriptor_read->quote($string);
	}

	protected function __fetchlines($query, $arguments = array()) {
		$statement = $this->descriptor_read->prepare($query);
		$statement->execute($arguments) or $this->getSQLerror($statement);

		$db_results = $statement->fetchAll(PDO::FETCH_ASSOC);
		$results = array();
		$i = 1;



		foreach($db_results AS $result) {
			$result['num'] = $i;
			$results[] = $result;
			$i++;
		}
		return $results;
	}
	protected function __fetchlines_clear($query) {
		$db_results = $this->descriptor_read->query($query,PDO::FETCH_ASSOC) or $this->getSQLerror();
		$results = array();
		$meta = $db_results->getColumnMeta(0);
		$name = $meta['name'];
		$i = 1;
		foreach($db_results AS $result) {
			$result['num'] = $i;
			$results[$result[$name]] = $result;
		}
		$db_results->closeCursor();
		return $results;
	}

	protected function __fetchobject($query, $class_name = 'stdClass', $arguments = array()) {
		if(!class_exists($class_name)) throw new D_Core_Exception(EX_CLASS_NOT_FOUND);

		$query = $this->descriptor_read->prepare($query);

		$query->execute($arguments) or $this->getSQLerror($query);

		$obj = $query->fetchObject($class_name);
		unset($query);
		//$result->closeCursor();
		return $obj;
	}

	function __exec($query, $arguments = array()) {
		$this->connect_write();

		$query = $this->descriptor_write->prepare($query);
		$count = $query->execute($arguments);

		if($count === false) $this->getSQLerror($query);
		$id = $this->descriptor_write->lastInsertId();
		return ($id != 0 ) ? $id : $count;
	}

	function __destruct() {
		$this->descriptor_read = null;
		$this->descriptor_write = null;
	}

	function connect() {
		if($this->descriptor_read) return true;

		try {
			// if we have READ and WRITE databases splitted
			if(is_array($this->host)) {
				$this->descriptor_read = new PDO('mysql:host='.$this->host['read'].';dbname='.$this->dbname, $this->username, $this->password);
			} else {
				$this->descriptor_read = new PDO('mysql:host=localhost;dbname='.$this->dbname, $this->username, $this->password);
				$this->descriptor_write = &$this->descriptor_read;
			}

		} catch (Exception $e) {
			echo "Unable".$e->getMessage();
		}
	}

	/**
		Connect to WRITE database
	 */
	function connect_write() {
		if(!is_array($this->host)) return true;

		try {
			$this->descriptor_write = new PDO('mysql:host='.$this->host['write'].';dbname='.$this->dbname, $this->username, $this->password, array(PDO::ATTR_PERSISTENT => true));
		} catch (Exception $e) {
			echo "Unable".$e->getMessage();
		}

	}

	function disconnect() {
		unset($this->descriptor_read);
		unset($this->descriptor_write);
		$this->descriptor_read = $this->descriptor_write = false;
	}

	function getSQLerror($st = '') {
		$query = $this->query_history[sizeof($this->query_history) - 1];
		//echo $query;
		$error = $this->descriptor_read->errorInfo();
		//echo $query;exit;
		throw new D_Core_Exception("Reason: {$error[2]}\nQuery:\n ".str_replace("\t","", $query), EX_BAD_DB_QUERY);
	}
}
?>
