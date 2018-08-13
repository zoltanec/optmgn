<?php
$delivery = D_Core_Factory::Notify_Delivery(D::$req->int('did'));
D::$req->map($delivery, ['name' => 'textLine','msg' => 'textLine']);
$delivery->lid = D::$req->int('lid');
$delivery->mode = D::$req->select('mode', Notify_Delivery::getModes());
$delivery->save();
D::$tpl->Redirect('~/delivery.edit-delivery/'.$delivery->did);
?>