<?php
$item = new Admin_MenuItem();
D::$req->map($item, array('menu_name' => 'textLine'));;
$item->uri = D::$req->url('menu_uri');
$item->save();
D::$tpl->Redirect('~/menu-items/');