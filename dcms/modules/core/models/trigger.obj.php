<?php
/**
 * This class allows you to store some flags in database, and ensure that this mark is uniq.
 * For example you can check that this transaction wasn't used before, or user
 * didn't made request 10 times per last second
 *  ...
 * @author work
 *
 */
class Core_Trigger {
	// in percents
	const TRIGGERS_CLEANUP_POS = 99;
	/**
	 * Check trigger if it exists. Return false if event occures and true when trigger is inactive
	 *
	 * @param string $trigger_name - trigger name
	 * @param int $limit - maximum number of activates of this trigger
	 * @param int $period - check this trigger only on specific period
	 *
	 * @return bool $existed -
	 *
	 */
	static function check($name, $limit = 1, $period = 0) {
		if($limit > 1 || $period > 0 ) {
			$marker = D_Misc_Random::getString(6);
		} else {
			$marker = 'UNIQUE';
		}
		$namehash = md5($name);

		$where = "namehash = '".$namehash."'";

		if($period > 0 ) {
			$where .= ' AND add_time > UNIX_TIMESTAMP() - '.intval($period);
		}
		$count = intval(D::$db->fetchvar("SELECT COUNT(1) FROM #PX#_core_triggers WHERE {$where}"));

		if($count >= $limit ) {
			return false;
		} else {
			try {
				$add_time = time();
				$exp_time = $add_time + $period;
				D::$db->exec("INSERT INTO #PX#_core_triggers (namehash, add_time, marker,exp_time ) VALUES (:namehash, :addtime, :marker, :exp_time)", [':namehash' => $namehash, ':addtime' => $add_time, ':marker' => $marker, ':exp_time' => $exp_time ]);

				if( intval(rand() * 100) <= self::TRIGGERS_CLEANUP_POS) {
					D::$db->exec("DELETE FROM #PX#_core_triggers WHERE exp_time != add_time AND exp_time < UNIX_TIMESTAMP()");
				}
			} catch (Exception $e) {
				return false;
			}
			return true;
		}

	}
}
?>