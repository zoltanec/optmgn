<?php
$csid = D::$req->int('csid');
$cs = Feedback_Feedback::deleteCause($csid);
D::$Tpl->redirect("~/");
?>