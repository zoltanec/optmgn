<?php
function smarty_block_elem($params, $content, &$smarty,&$repeat) {
	if( $content == NULL) {
		$header = $params['header'];
		$title=$params['title'];
		$id = ( isset($params['id']) ) ? $params['id'] : md5(rand());
		echo "<tbody class='data_elem' data-elem-id='{$id}'>\n\t<tr>\n\t<td class=\"table_checkbox\"><input type=\"checkbox\" /></td>";
	} else {
		echo $content."\t</tr>\n</tbody>";
	}
}
?>