<?php
$delivery = new Notify_Delivery();
$delivery->save();
D::$tpl->Redirect('~/delivery.edit-delivery/'.$delivery->did);
?>