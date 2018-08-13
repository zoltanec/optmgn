<?php
if ( D::$req->isset('confid') ) {
	$conf = D_Core_Factory::Feedback_Feedback(D::$req->int('confid'));
	$conf->delete();
}
D::$Tpl->redirect(D::$req->getReferer());
?>
