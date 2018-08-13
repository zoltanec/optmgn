<?php
$section = new News_Section();
$section->section_name = 'New section';
$section->save();
// activity flag
$section->active = false;
// section key
$section->section_key = 'EMPTY_SECTION_KEY';
$section->priority = $section->sid;
$section->save();
D::$Tpl->Redirect('~/edit-section/sid_'.$section->sid);
?>