<?php
function smarty_function_formline($params, &$engine) {
	$title = (isset($params['title'])) ? $params['title'] : 'NO_NAME';
	$type  = (isset($params['type']))  ? $params['type']  : 'text';
	$name  = (isset($params['name']))  ? $params['name']  : '';


	$name = $params['name'];
	$value = $params['value'];
	$multi = $params['multi'];

	$object_id = (isset($params['object_id'])) ? $params['object_id'] : md5(rand());

	if($type == 'header') {
		return "<thead><tr><th></th><th></th><th><a href='#' class='configure'>Настроить</a><a href='#' class='save'>Сохранить</a></th></tr></thead>";
	}

	switch($type) {
	//	case "text": $value_block = "<input type='text' name='{$name}' value='{$value}' />"; break;
		case "hidden": return  "<input type='hidden' name='{$name}' value='{$value}' />"; break;

		case "file":
				$value_block = "<input type='file' name='{$name}' />";
				break;

		case "bool":
				$checked = ($value == 1) ? ' checked ' : '';
				$value_block = "<input type='checkbox' name='{$name}' value='1' {$checked} />"; break;
		case "select":
				// есть ли поле по которому будем выполнять поиск, например для иерархий
				$check_field = (isset($params['field'])) ? $params['field'] : $name;
				$showfield  = (isset($params['showfield'])) ? $params['showfield'] : $name;

				if(!is_array($params['list']) || sizeof($params['list']) == 0 ) {
					$value_block = '';
					break;
				}
				$list = $params['list'];


				$value_block = "<select name='".$name."'>";
				if(isset($params['with_null'])) {
					$value_block.= "<option value='0'>".$params['with_null'];
				}

				// we have a list of objects
				if(is_object($list[0])) {
					foreach($list AS $obj) {
						$selected = ($obj->{$check_field} == $value) ? " selected" : "";
						$value_block.= "<option value='".$obj->{$check_field}."'".$selected.">".$obj->{$showfield}."</option>\n";
					}
				} elseif(is_array($list[0])) {
					foreach($list AS $arr) {
						$selected = ($arr[$check_field] == $value) ? " selected" : "";
						$value_block.= "<option value='".$arr[$check_field]."'".$selected.">".$arr[$showfield]."</option>\n";
					}
				} else {
					foreach($list AS $arr) {
						$selected = ($arr == $value) ? " selected" : "";
						$value_block.= "<option value='".$arr."'".$selected.">".$arr."</option>\n";
					}
				}
				$value_block .= "</select>";

				break;
		case "text":
		case "textarea":
				$size = (isset($params['size'])) ? intval($params['size']) : 40;

				if($multi && D::$config->{'multilang'}) {
					//var_dump(D::$config->{'languages'});
					$value_block.='<table class="cms_admin_multilang"><thead><tr>';
					foreach(D::$config->{'languages'} AS $lang) {
						$value_block.= "<th data-lang='{$lang}'>{$lang}</th>";
					}
					$value_block .= "</tr></thead><tr><td class='cms_admin_multilang_input' colspan='".sizeof(D::$config->{'languages'})."'>";

					foreach(D::$config->{'languages'} AS $lang) {
						$hash = strtoupper(md5($object_id.$name));
						$translate = D_Core_i18n::translate($hash, $lang);

						if($hash == $translate) $translate = '';

						if($lang == D::$config->{'default_language'}) {
							$name_elem = ' name = "'.$name.'" ';
							$translate = $value;
						} else {
							$name_elem = '';
						}

						if($type == 'text') {
							$value_block.= "<input size='{$size}' data-lang='{$lang}' data-hash='{$hash}' {$name_elem} value='{$translate}' />";
						} else {
							$value_block.= "<textarea data-lang='{$lang}' data-hash='{$hash}' {$name_elem} cols='40' rows='5'>{$translate}</textarea>";
						}
					}
					$value_block .= "</td></tr><tr><td colspan='".sizeof(D::$config->{'languages'})."'><input data-name='{$name}' type='submit' value='".D::$i18n->getTranslation('SAVE')."'></td></tr></table>";

				} else {
					if($type == 'text') {
						$value_block = "<input name='{$name}' size='{$size}' value='{$value}' />";
					} else {
						$value_block = "<textarea name='{$name}' cols='40' rows='5'>".$value."</textarea>";
					}
				}
				break;

		case "view":
				$value_block = $value;
				break;

		case "save":
				$title = '';
				$value_block = "<input type='submit' value='".D::$i18n->translate('SAVE')."' />";
				break;
	}

	return "<tbody data-line-name='".$name.'-'.$type."'>
	<tr>
		<td class='cms_form_var_changer'><input type='checkbox'></td>
		<td>".$title."</td>
		<td>".$value_block."</td>
	</tr>
</tbody>";
}
?>
