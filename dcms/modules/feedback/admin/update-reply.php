<?php
$rid = D::$req->int('rid');
$rpl = D_Core_Factory::Feedback_Feedback($confid);
$rpl->saveReply(D::$req->TextLine('reply'),$rid);
D::$Tpl->redirect("~/");
?>