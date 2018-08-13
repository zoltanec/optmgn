<?php
/**
 * This trait build parents tree for object
 */
trait D_Helpers_Parents {

	public function __get_parents() {
		try {
			$base = $this->parent;
		} catch (Exception $e) {
			return array();
		}

		if($base->object_hash() == $this->object_hash()) {
			return array();
		}

		$added = array($base->object_hash);
		$parents = array($base);

		for($x = 0; $x < 100; $x++) {
			try {
				$parent = $base->parent;
				if(!in_array($parent->object_hash(), $added)) {
					$added[] = $parent->object_hash();
				} else {
					break;
				}
				$parents[] = $parent;
				$base = &$parent;
			} catch (Exception $e) {
				break;
			}
			$x++;
		}
		return $parents;
	}
}

?>