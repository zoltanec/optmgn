<?php
$did=D::$req->int('did');
$T['parent'] = dObject::Tree($did);
D::$Tpl->RenderTpl('tree;branch.tpl');
?>