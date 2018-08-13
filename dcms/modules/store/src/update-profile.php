<?php
if(!D::$user) {
	D::$Tpl->redirect("~/enter/");
}
D::$req->map(D::$user->store,array( 'fullname' => 'textLine', 'username' => 'textLine', 'address' => 'textLine','phone' => 'textLine', 'subscribe' => 'bool', 'delivery' => 'int'));
D::$user->store->save();
D::$tpl->RedirectOrJSON(D::$req->referer(), ['status' => 'OK'] );
?>