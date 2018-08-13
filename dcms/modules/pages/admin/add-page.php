<?php
$page = new Pages_StaticPage();
$page->pagetitle = 'New page';
$page->parent_id = D::$req->int("parent_id");
$page->save();
$T['page'] = $page;
D::$tpl->renderTpl('admin/edit-page');
D::sysExit();
?>