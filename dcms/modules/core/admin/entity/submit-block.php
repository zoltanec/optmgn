<?php
$block=new Core_Entity_iBlock();
D::$req->map($block, array('module_name'=>'textLine',
							'class_name'=>'textLine',
							'parent_class_name'=>'textLine',
							'sid'=>'int',
							'descr'=>'textLine'));
$block->save();
D::$Tpl->Redirect(D::$req->referer());
?>