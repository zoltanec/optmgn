<?php
try {
	$section = D_Core_Factory::News_Sections(D::$req->int('sid'));
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/list-sections/', array('status' => 'ERROR_NO_SUCH_SECTION'));
}
D::$req->map($section, array('section_name' => 'textLine', 'descr' => 'html','section_key' => 'textID'));
$section->save();
D::$Tpl->RedirectOrJSON('~/edit-section/sid_'.$section->sid, array('status' => 'OK'));
?>