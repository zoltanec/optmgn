<?php
$nid = D::$req->intID('param1');

$T['day_grouped'] = News_News::DayGrouped();

try {
	$T['news'] = D_Core_Factory::News_News($nid);
} catch (Exception $e) {
    D::$Tpl->redirect("~/");
}
$T['news']->countReads();
?>