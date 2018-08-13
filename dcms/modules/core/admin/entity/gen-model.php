<?php
$block_id=D::$req->int("blockid");
$block=D_Core_Factory::Core_Entity_iBlock($block_id);
if($block){
	$modulepath=D::getModulePath($block->module_name)."/models/";
	$block->installDbTable();
	if(is_writable($modulepath)) {
		$newclass=fopen($modulepath.str_replace($block->module_name."_","",$block->class_name).".obj.php","w");
		fwrite($newclass, $block->getCreateModel());
		fclose($newclass);
	}
}
D::$Tpl->Redirect(D::$req->referer());
?>