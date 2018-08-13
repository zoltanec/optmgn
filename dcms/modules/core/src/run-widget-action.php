<?php
$widgetName = D::$req->textID('param1');
$widgetAction = D::$req->textID('param2');
$widgetPath = D::getWidgetPath($widgetName);
if(!$widgetPath) {
	D::$Tpl->PrintText("NO_SUCH_WIDGET");
}
if(file_exists($widgetPath."/src/".$widgetAction.".php")) {
	//что у нас будет считаться корнем виджета
	D::$Tpl->redirect_base = "/core/run-widget-action/".$widgetName;
	require_once $widgetPath."/src/".$widgetAction.".php";
	D::$Tpl->Show('dwidget:'.$widgetName.";templates/".$widgetAction);
} else {
	D::$Tpl->PrintText('NO_SUCH_WIDGET_ACTION');
}
D::sysExit();
?>