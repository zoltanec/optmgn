<?php
$SEPARATOR = '_SEPARATOR_';
$dir = D::$req->textLine('dir');
$dirParsed = str_replace($SEPARATOR,'/',$dir);
if(is_dir($run['my_content'].'/upload/'.$dirParsed)) {
	echo "<table>";
	$dirId = opendir($run['my_content'].'/upload/'.$dirParsed);
	while( false !== ($subdir = readdir($dirId))) {
		if(!in_array($subdir, array('.','..')) and is_dir($run['my_content'].'/upload/'.$dirParsed.'/'.$subdir)) {
			echo "<tr><td><input type='checkbox' name='importdir[]' value='{$dir}{$SEPARATOR}{$subdir}'></td><td>{$subdir}</td><td><a onclick='return loadSubdirs(\"{$dir}{$SEPARATOR}{$subdir}\");' href='#'>[показать]</a></td></tr>
                  <tr><td></td><td style='display: none;' colspan='2' id='subdirs_{$dir}{$SEPARATOR}{$subdir}'></td></tr>";
		}
	}
	echo "</table>";
	closedir($dirId);
}
exit;
?>