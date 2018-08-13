<?php
$user=D::getUser();
if(!D::getUser()) {
	D::$Tpl->redirect("~/enter/");
}
?>