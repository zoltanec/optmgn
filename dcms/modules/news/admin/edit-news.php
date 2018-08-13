<?php
$t=News_News::getIconsList();
$T['news'] = D_Core_Factory::News_News(D::$req->int('nid'));
D::$tpl->addBC('/admin/run/news/edit-news/nid_'.$T['news']->nid, $T['news']->title);
?>