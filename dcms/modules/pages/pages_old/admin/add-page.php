<?php
$page = new Pages_StaticPage();
$page->title = 'New page';
$page->save();
D::$Tpl->Redirect('~/edit-page/contentid_'.$page->content_id);
?>