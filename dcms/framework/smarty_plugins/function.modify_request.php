<?php
//функция модифицирует запрос и заменять переменные в запросе на другие
function smarty_function_modify_request($params,&$smarty) {
	//обрабатываем все входящие параметры
	$matches = array();
	preg_match_all('/\/([a-zA-Z0-9]+)_([A-Za-z0-9\-\_\.]+)/',D::$req->uri,$matches);
	$data = D::$req->uri;
	//находим переменные которые уже указаны
	if(sizeof($matches[1]) > 0 ) {
		$from = array();
		$to = array();
		foreach($matches[1] AS $id=>$var_name) {
			if(isset($params[$var_name])) {
				$from[] = $matches[0][$id];
				$to[] = "/".$var_name."_".$params[$var_name];
				unset($params[$var_name]);
			}
		}
		$data = str_replace($from,$to,$data);
	}
	if($data[strlen($data)-1] != '/') $data.= "/";
	//а теперь добавляем новые параметры
	foreach($params AS $key=>$value) {
		$data.="{$key}_{$value}/";
	}
	return D::$web."/".$data;
}
?>