<?php
D::$tpl->addBC('~/view-lists/','Списки');
$T['list'] = Store_Lists::find(['name' => D::$req->textID('name')],['order' => 'priority']);
$T['name'] = D::$req->textID('name');
?>