<?php
$tag = D::$req->textLine('value');
$T['news'] = News::byTag($tag);
if(sizeof($T['news']) == 1) {
	D::$Tpl->redirect("~/read/".$T['news'][1]->nid."/");
} elseif (sizeof($T['news']) == 0 ) {
	D::$Tpl->redirect("~/");
}
?>