<?php
$qid=D::$req->int('qid');
$T['parent'] = D_Core_Factory::Faq($qid);
D::$Tpl->RenderTpl('faq;faq.tpl');
?>