<?php
if($argv[1] == 'init') {
	$main_dir = getcwd();
	$dcmspath = dirname(dirname(__FILE__));
	// теперь последовательно создаем необходимые каталоги
	$dirs = array('modules','configs','content','jscripts','core');
	foreach($dirs AS $dir) {
		echo "Creating dir {$dir}\n";
		mkdir($main_dir."/".$dir,0755);
	}
	mkdir($main_dir."/themes/default/css",0755,true);
	mkdir($main_dir."/themes/default/images",0755,true);
	mkdir($main_dir."/work/smarty",0777,true);
	mkdir($main_dir."/work/exceptions",0777,true);
	foreach(array('cache','configs','templates_c') AS $smarty_dir) {
		mkdir($main_dir."/work/smarty/".$smarty_dir,0777);
	}
	// делаем пустой шаблон
	file_put_contents($main_dir."/themes/default/theme.tpl",'<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Project title</title>
</head>
<body>
<{include file=$moduletemplate}>
</body>
</html>');
	file_put_contents($main_dir."/themes/default/css/core.css", "");
	file_put_contents($main_dir."/configs/core.php","<?php
// change this line before production launch
\$cfg['path'] = dirname(dirname(__FILE__));
\$cfg['dcmspath'] = '{$dcmspath}';\n?>");
	file_put_contents($main_dir."/.htaccess","<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php?uri=$1
</IfModule>");
	file_put_contents($main_dir."/index.php", "<?php\nrequire_once \"configs/core.php\";
require_once \$cfg['dcmspath'].\"/init.php\";
class D extends D_Core_Runner {
}
D::init(\$cfg);
D::run();\n?>");
}
?>