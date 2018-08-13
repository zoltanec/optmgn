<?php

class Analytics_Vars extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $var = '';
	public $tdate = '1970-01-01';
	public $version = 0;

	static protected function __pk() {
		return ['var','tdate','version'];
	}
	static protected function __fields() {
		return ['val'];
	}

	static function getDayValue($var, $tdate) {
		$find = self::find(['var' => $var, 'tdate' => $tdate],['limit' => 1]);
		if(!is_object($find)) {
			throw new D_Core_Exception("No static variable for {$var}:{$tdate}");
		}
		return $find->val;
	}

	/**
	  Get array of variables
	  @param array $variables - list of variables to be fetched
	  @return array $values - answer values
	 */
	static function getArray($variables = []) {
		$vars = self::find(['var' => ['in', $variables]]);
		$res = [];
		foreach($vars AS $var) {
			$res[$var->var] = $var->val;
		}
		return $res;
	}

	/**
     Get list of variables for specific period
	 */
	static function getForPeriod($var, $start = 0, $stop = 0 ) {
		$filter = [];
		$vars = self::find(['var' => $var]);
		$result = [];
		foreach($vars AS &$var) {
			$result[$var->tdate] = $var->val;
		}
		return $result;
	}

	static function set($var, $value = '', $tdate = '1970-01-01') {
		//die("sdf");
		$new = new self();
		$new->var = $var;
		$new->val = $value;
		$new->tdate = $tdate;
		$new->save();
	}

}