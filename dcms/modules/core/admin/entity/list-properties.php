<?php
$T['category_id']=D::$req->int('category');
D::$Tpl->RenderTpl("admin/list-prop.tpl");
exit;
?>