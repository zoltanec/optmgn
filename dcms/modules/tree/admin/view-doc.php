<?php
$did=D::$req->int('did');
$T['doc'] = D::$db->fetchline("SELECT * FROM #PX#_tree WHERE did={$did}");
D::$Tpl->RenderTpl('tree;admin/view-doc.tpl');
?>