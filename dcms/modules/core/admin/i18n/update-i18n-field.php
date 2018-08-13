<?php
$hash = strtoupper(md5(D::$req->textLine('object_id').D::$req->textID('name')));
$msg = new Core_I18n_Message();
$msg->msg_code = $hash;
$msg->lang = D::$req->textID('lang');
$msg->msg_text = D::$req->textLine('text');
$msg->save();
D::$tpl->PrintJSON(['status' => 'OK']);