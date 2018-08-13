<?php
$section=D_Core_Factory::Core_Sections_Section(D::$req->int('sid'));
if(!$section) {
	throw new D_Core_Exception('NO SUCH CATEGORY');
}
if (D::$req->textLine('save')){
	D::$req->map($section,array('pid'=>'int','section_name'=>'textLine','module_name'=>'textLine'));
	$logo=D::$req->image('image');
	if($logo){
		$filename=substr(md5($section->sid.'/'.rand(0,100000)),0,6);
		$logo->resize(200,200);
		$logo->save(D::$content_path.'/sections'.$section->sid.'/'.$filename.'.png','png');
		$section->image=$filename.'.png';
	}
	$section->save();
} else $section->delete();
D::$Tpl->redirect(D::$req->referer());
?>