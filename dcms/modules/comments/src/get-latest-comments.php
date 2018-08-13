<?php
$object_id = D::$req->textLine('object_id');
$comid = D::$req->intID('comid');
$order_mode = D::$req->select('order_mode', array('normal', 'reverse'));
$comments = new Comments_List($object_id);
//echo $comid;
//var_dump($comments->meta);exit;
//D::$online_stat->setObjectId($object_id);

//if($comments->meta->lastcomid <= $comid) {
//	D::$Tpl->PrintText('');
//}
$T['comments'] = $comments->getLatestFrom($comid, $order_mode);
?>