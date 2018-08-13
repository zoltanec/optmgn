<?php
function smarty_block_strings($params, $content, &$smarty,&$repeat) {
	if( $content == NULL) {
	} else {
		switch($params['function']) {
			case 'ucfirst':
					echo ucfirst($content);
					break;
			case 'lower':
					echo strtolower($content);
					break;
			case 'ucwords':
					echo ucwords(strtolower($content));
					break;
		}
	}
}