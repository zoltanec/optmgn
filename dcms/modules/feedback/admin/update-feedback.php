<?php
$feedback = D_Core_Factory::Feedback_Feedback($confid);
if(!$feedback) {
	D::$Tpl->Redirect('~/');
}
D::$req->map($feedback, array('phone' => 'bool', 'company' => 'bool', 'region' => 'int', 'country' => 'bool', 'depart' => 'bool', 'cause' => 'bool', 'subscribe' => 'bool', 'know' => 'bool'));
$feedback->save();
D::$Tpl->Redirect('~/');
?>