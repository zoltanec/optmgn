<?php
$class=D::$req->textLine("class");
if(property_exists($class,"sid"))
echo json_encode(Core_Sections_Section::getAllSections(D::$req->textLine("module")));
exit;
?>