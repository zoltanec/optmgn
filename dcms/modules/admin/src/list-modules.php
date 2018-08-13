<?php
$modules_list = array();
$supported_fields = array('name','version','descr');
foreach(D::$modules_search_path AS $search_path) {
	$dir_files = scandir($search_path);
	unset($dir_files[0]);
	unset($dir_files[1]);
	$dir_modules = array();
	foreach($dir_files AS &$module) {
		$module_data = array('code' => $module, 'info' => array());
		if(file_exists($search_path."/".$module."/info.txt")) {
			$info = file_get_contents($search_path."/".$module."/info.txt");
			$modinfo = array();
			foreach(explode("\n", $info) AS $line) {
				$data = explode(':', $line);
				if(sizeof($data) == 2 and in_array($data[0], $supported_fields)) {
					$modinfo[$data[0]] = $data[1];
				}
				//var_dump($data);
			}
			$module_data['info'] = $modinfo;
		}
		$dir_modules[] = $module_data;
	}
	$modules_list = array_merge($modules_list, $dir_modules);
}
$T['modules_list'] = $modules_list;
?>