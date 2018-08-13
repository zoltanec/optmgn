<?php
function smarty_function_css($params, &$engine) {
	if(!empty($params['file'])) {
		D::$tpl->addCss($params['file']);
	}
}
?>