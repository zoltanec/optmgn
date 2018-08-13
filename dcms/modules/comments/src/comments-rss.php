<?php
//загружаем комментарии к объекту
$T['comments'] = new dCommentsList(D::$req->object);
D::$Tpl->xml('dit:core;comments-rss.tpl');
?>