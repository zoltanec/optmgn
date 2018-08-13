<?php
class Core_I18n_Project extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $add_time = 0;
	public $code = 'NO_CODE';
	public $export = '';
	public $lang_from = 'na';
	public $lang_to   = 'na';
	public $source = '';
	public $result = '';
	public $price = 0.0;

	static protected function __fields() {
		return ['export', 'code', 'add_time', 'price', 'lang_from', 'lang_to', 'source', 'result'];
	}
	static protected function __pk() {
		return ['pid'];
	}
}
