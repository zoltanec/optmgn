<?php
$faq = D_Core_Factory::Faq(D::$req->int('qid'));
if(!$faq) {
	throw new dRuntimeException('NO_SUCH_FAQ');
}
D::$req->map($faq, array('qname' => 'textLine', 'qcontent' => 'raw'));
$faq->save();
D::$Tpl->Redirect(D::$req->Referer());
?>