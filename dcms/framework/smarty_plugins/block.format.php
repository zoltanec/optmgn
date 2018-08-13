<?php
function smarty_block_format($params, $content, &$smarty, &$repeat) {
	if( $content != NULL) {
		$r = [];
		foreach($params AS $key => $value) {
			$r['%{'.$key.'}'] = $value;
		}

		echo str_replace(array_keys($r), array_values($r), $content);
	}
}