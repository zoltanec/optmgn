<?php
// отображаем опрос пользователя
try {
	$survey = dFactory::Survey(D::$req->int('sid'));
} catch (Exception $e) {
	D::$Tpl->Redirect('~/');
}
$T['survey'] = $survey;
?>