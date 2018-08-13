<?php
$faq = D_Core_Factory::Faq(D::$req->int('qid'));
if(!$faq) {
	throw new dRuntimeException('No_SUCH_FAQ');
}
$faq->Delete();
D::$Tpl->Redirect('~/');
?>