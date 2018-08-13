<?php
$pages = new Pages_StaticPagesList();
$pages->page = D::$req->page('param3');
$T['pages_list'] = $pages;