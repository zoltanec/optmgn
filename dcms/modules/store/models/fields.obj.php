<?php
class Store_Fields extends D_Core_Object {
	public $catid = 0;
	public $code  = '';


	protected function __object_id() {
		return array($this->catid, $this->code);
	}

	protected function __fetch($catid, $code) {
		return D::$db->fetchobject("SELECT * FROM #PX#_store_categories_fields WHERE catid = '{$catid}' AND code = '{$code}' LIMIT 1",__CLASS__);
	}

    static function getCategoryFieldsAssoc($catid = 0) {
        $result = [];
        foreach(self::getCategoryFields($catid) as $fieldObj) {
            $result[$fieldObj->code] = $fieldObj;
        }
        return $result;
    }

	/**
	 * Get list of supported fields for category
	 *
	 * @param int $catid - category identificator
	 */

	static function getCategoryFields($catid = 0 ) {
		//!!!Все родительские категории если передается массив родительских категорий
		if(is_array($catid))
			$cond='catid = '.implode(' OR catid = ',$catid);
		else $cond='catid = '.$catid;
		return D::$db->fetchobjects("SELECT * FROM #PX#_store_categories_fields WHERE {$cond}",__CLASS__);
	}
}