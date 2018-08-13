<?php
$rid = D::$req->int('rid');
$rpl = Feedback_Feedback::deleteReply($rid);
D::$Tpl->redirect("~/");
?>