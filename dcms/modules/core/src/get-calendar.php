<?php
$calendarId = D::$req->textID('calendarid');
$monthId = D::$req->textLine('monthid');
$calendar = dObject::CalendarWidget($calendarId.'::'.$monthId);
D::$Tpl->set('calendar', &$calendar);
D::$Tpl->RenderTpl('dwidget:calendar;gameslist');
?>