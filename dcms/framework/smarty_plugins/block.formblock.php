<?php
function smarty_block_formblock($params, $content, &$smarty,&$repeat) {
	if( $content == NULL) {
		$title = (isset($params['title'])) ? $params['title'] : 'No title';
		$name  = (isset($params['name'])) ? $params['name'] : 'noname';

		echo "<tbody data-line-name='{$name}'><tr><td class='cms_form_var_changer'><input type='checkbox'></td><td>{$title}</td><td>";
	} else {
		echo $content.'</td></tr></tbody>';
	}
}