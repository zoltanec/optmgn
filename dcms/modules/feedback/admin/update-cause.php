<?php
//варианты ответа разбиваем на
$csid = D::$req->int('csid');
$cs = D_Core_Factory::Feedback_Feedback($confid);
$cs->saveCause(D::$req->TextLine('cause'),$csid);
D::$Tpl->redirect("~/");
?>