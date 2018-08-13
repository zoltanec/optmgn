<?php
$block_id=D::$req->int("blockid");
if(D::$req->textLine("delete")){
	$block=D_Core_Factory::Core_Entity_iBlock($block_id);
	$block->delete();
}else{
	if($block_id)
		$block=D_Core_Factory::Core_Entity_iBlock($block_id);
	else $block=new Core_Entity_iBlock();
	D::$req->map($block, array('sid'=>'int', 
							'desc'=>'textLine'));
	$block->save();
}
D::$Tpl->Redirect(D::$req->referer());
?>