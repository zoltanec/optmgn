<?php
$cs = D_Core_Factory::Feedback_Feedback($confid);
$cs->saveCause(D::$req->TextLine('cause'));
D::$Tpl->redirect("~/");
?>