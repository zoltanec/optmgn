<?php
$prop_id=D::$req->int("propid");
if(D::$req->textLine("delete")){
	$prop=D_Core_Factory::Core_Entity_Property($prop_id);
	$prop->delete();
}else{
	if($prop_id)
		$prop=D_Core_Factory::Core_Entity_Property($prop_id);
	else $prop=new Core_Entity_Property();
	D::$req->map($prop, array('block_id'=>'int', 
							'prop_name'=>'textLine',
							'prop_code'=>'textLine',
							'prop_type'=>'int',
							'prop_length'=>'int',
							'prop_form_type'=>'int',
							'prop_unit'=>'textLine',
							'dependency'=>'textLine'));
	$prop->save();
}
D::$Tpl->Redirect(D::$req->referer());
?>