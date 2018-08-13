<?php
//определяем какой модуль нам необходим
$widget = D::$req->textID('param1');
$action = D::$req->textID('param2');
$widget_path = '';
foreach(D::$widgets_path AS $w_path) {
	if(is_dir($w_path."/".$widget)) {
		$widget_path = $w_path."/".$widget;
		break;
	}
}
if(!empty($widget_path)) {
    //подключаем инициализацию
    require_once $widget_path."/{$widget}widget.php";
    $T['run'] = array('me'=>D::$web."/admin/widget/".$widget);
    $run = array('my_content'=>D::$content_path."/".$widget);
    D::$Tpl->set('run', $T['run']);
    if(!$action) { $action = "index"; }
    if(file_exists($widget_path."/admin/".$action.".php")) {
        //указываем базу для редиректа
        D::$Tpl->redirect_base = "/admin/widget/".$widget;
        require_once $widget_path."/admin/".$action.".php";
        $requested_action = $action;
        $T['run_template'] = "dwidget:{$widget};templates/admin/{$requested_action}.tpl";
        D::$Tpl->show("widget.tpl");
    } else echo "No action {$action} in {$widget} widget!";
} else echo "No such widget: {$widget}";
?>