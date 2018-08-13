<?php
$T["module"]=D::$req->textLine("module");
if($T["module"])
	$T["sections"]=Core_Sections_Section::getAllSections($T["module"]);
else $T["sections"]=Core_Sections_Section::getAllSections();
?>