<?php
echo json_encode(Core_Sections_Section::getAllSections(D::$req->textLine("module")));
exit;
?>