<?php
if(count(D::getClassesList(D::$req->textLine("module"))))
	echo json_encode(D::getClassesList(D::$req->textLine("module")));
exit;
?>