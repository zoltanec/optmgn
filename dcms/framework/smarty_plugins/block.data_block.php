<?php
function smarty_block_data_block($params, $content, &$smarty,&$repeat) {
	if( $content == NULL) {
		$header = $params['header'];
		$title = $params['title'];
		$id = (isset($params['id'])) ? $params['id'] : md5(rand());
		echo "
<div class='block check_table_view_mode' data-block-id='{$id}'>
    <div class='block_title'><span>{$title}</span>
    	<div class='block_properties'>
    		<a class='block_ico_expand' href='#'></a>
    		<a class='block_ico_turn' href='#'></a>
    		<a class='block_ico_settings' href='#'></a>
    	</div>
    </div>

	<div class='block_content'>
		<table>
			<tr>
				<td colspan='3' class='table_proper_prop'><b>Выберите нужную информацию</b><a class='block_save' href=''>Сохранить</a></td>
			</tr>
			<tr>
				<td colspan='3' class='table_proper_prop'><input type='checkbox' /><span>Выбрать все</span></td>
			</tr>";
	} else {
		echo $content." </table></div><img class='block_shadow' src='{$smarty->theme['images']}/block_shadow.png' /></div>";
	}
}
?>