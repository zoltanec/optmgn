<?php
//TEST TODO
//Поправить list_url & img_list плагины ТиниМСЕ для многоуровневого отображения
//Сообщение об ошибке ajax, если исключение БД
// 
//Но если вам нужен сайт или веб-сервис с индивидуально разработанным для вас дизайном продуманным до мелочей и/или запрограммированный под высокую нагрузку(подсказа от 1000 посетителей в сутки) мы готовы поработать и за большие деньги
//		if($SERVER['SERVER_NAME']=='vbunker'){
//			foreach(array('') as $cat) {
//				self::$cfg['url_rewrites'][$cat] = 'pages/contacts';
//			}
//		}
//Интерфейс. Прокрутка дерева в место открытого узла. Остальные узлы закрыты
//Нужно написать универсальный парсер. Методы: 1 получить документ 2 получить поля по массиву 3 получить урл ссылки 4 получить картинку и сохранить
//TODO Перед переносом сайта, чистить счетчики БД
///TODO сделать более компактным textformat, 

// TODO: сделать проверку установки модуля должны быть все таблицы и поля либо версия в базе install.sql
// 8 - Простой интерфейс админки в зависимости от конфигурации  KKK 
//11 Сделать возможность наследовать модулем категории со всеми скриптами отображения и шаблонами
// (как это сделать??? через класс, конфиг или вручную в tools.tpl и сделать реврайт)))) Если в настройках указано, то цепляем секции из ядра KKK 
//12 Сделать возможность наследования с изменениями под свои задачи KKK
//5 Аттрибуты ссылок посмотреть в модх и метатеги
//6 Сделать модуль поиска похожих страниц после статьи 
//9 Выбор модуля для отображения, действия модуля и категорию ****
//10 Сделать настройку доп полей. Сделать Источник. Сделать Наследование настроек.
// 13 Локализация сайта, перевод с помощью гугл для создания англ. версии сайта
//14 Отслеживание измененных названий переменных в других файлах
//!!!Одна иконка для всех статей
//D::getContext(); admin/user
//D::setContext('admin/user');
//D::getLang();
//D::sysExit();
//D::send404Error();
//D::$Tpl->setClearRendering();
//D::$Tpl->rendering_started
//D::$Tpl->redirect_base
//Конфиг: debug, dump_exceptions, work_dir, allow_actions_override, widgets_path, users_needed, allow_modules(array),deny_modules, smarty_dir
//theme, online_stat_active, cache:/xcache/none, cache_prefix, multilang, content_path, web, smarty_dir, content_dir, dcms_path, path, need_user, smiles_list
//comments_active, comments_readonly, db_driver, mailer, jquery_source, administrators, admin_auth_mode, auth_redirect, languages/array, language, site_name
//D::$req->isAjax()
//D::$req->action
//D::$req->module
//
if(empty(D::$req->action)) {
	D::$tpl->show('index-page');
}
if(D::$req->forcelang != NULL) {
	$lang = D::$req->select('forcelang', D::$config->languages);
} else {
	$lang = D::$req->lang;
}
try {
	//Избавление от дублей страниц, УРЛ которых содержит переменные
	if(D::$req->raw('param1')) D::send404Error();
	$page = D_Core_Factory::Pages_StaticPage(D::$req->action, $lang, 'name');
} catch (Exception $e) {
	if(D::$config->debug) throw new D_Core_Exception('NO_SUCH_STATIC_PAGE');
	else D::$tpl->show404();
}
if(!$page->active) {
	D::$tpl->show('page-inactive');
}

//if($page->content_type == 'module')
	//D::$tpl->show($page->content); 

//Статистика посещаемости
$page->updateStat();

//Если ссылка, делаем 301 редирект
if($page->content_type == 'link')
	D::$tpl->RedirectPermanently($page->content);
	
$T['page'] = $page;
//Заголовок окна и описание будут доступны в основном шаблоне
D::$tpl->title = $page->title;
D::$tpl->description = $page->description;
//Bread crumbs
if(D::$config->setting->breadcrumbs == true)
	$page->setBreadCrumbs();
//Nonstandart template
if($page->template) D::$tpl->show($page->template);
?>