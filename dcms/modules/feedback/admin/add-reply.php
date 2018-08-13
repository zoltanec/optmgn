<?php
$rpl = D_Core_Factory::Feedback_Feedback($confid);
$rpl->saveReply(D::$req->TextLine('reply'));
D::$Tpl->redirect("~/");
?>