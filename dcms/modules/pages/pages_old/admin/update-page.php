<?php
$page = D_Core_Factory::Pages_StaticPage(D::$req->int('content_id'));
D::$req->map($page, array( 'title' => 'textLine', 'content_name' => 'textLine', 'description' => 'textLine',
                     'description' => 'textLine',      'content' => 'html',
                          'active' => 'bool',         'comments' => 'bool'));
$page->lang = D::$req->select('lang', D::$config->languages);
$page->stat_mode = D::$req->select('stat_mode', Pages_StaticPage::$stat_modes);
$page->save();
D::$Tpl->Redirect('~/edit-page/contentid_'.$page->content_id);
?>