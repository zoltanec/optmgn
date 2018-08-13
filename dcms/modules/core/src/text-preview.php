<?php
$text = D::$req->raw('text');
D::$Tpl->PrintText(dText::bbParse($text));
?>