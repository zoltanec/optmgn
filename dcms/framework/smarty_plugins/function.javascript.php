<?php
function smarty_function_javascript($params, &$engine) {
	if(!empty($params['file'])) {
		D::$tpl->addJavaScript($params['file']);
	}
}
?>