<script type="text/javascript" src="<{$me.www}>/jscripts/tiny_mce_v3.4.2/tiny_mce_config.js"></script>
<{if $page->content_id != 0}>
	<H1><{if $page->pagetitle}><{$page->pagetitle}><{else}>Редактирование страницы  N<{$page->content_id}><{/if}></H1>
<{else}>
	<H1>Добавление новой страницы </H1>
<{/if}>
<!-- <ul class="tabs">
<li><a class="tab" href="#main">Общие настройки</a></li><li><a class="tab active" href="#mtags">Ключевые слова и метатеги</a></li><li><a class="tab" href="#prview">Предпросмотр страницы</a></li>
</ul> -->
	<div class="form_row">
		<{include title="Иконка" file_id="`$page->alias`" object_id="diricon" mode="icon" file="media;admin/add-image.tpl"}>
	</div>
	<form id="edit_page" method="post" action="<{$run.me}>/update-page">
		<input type="hidden" name="content_id" value="<{$page->content_id}>">
			<div class="form_block">
				<div class="left">
					
					<div class="form_row def">
						<div class="label">Псевдоним</div>
						<div class="help">Псевдоним используется для более удобного доступа к странице, например страница
						 с псевдонимом <b>verycoolpage</b> будет доступна как <i><{$run.path}>/verycoolpage/</i> . Псевдоним должен быть уникален.</div>
						<input type="text" name="alias" size="60" value="<{$page->alias}>" /><br>
						<i>Адрес: <a href="<{$page->HURL}>" target="_blank"><{$page->HURL}></a></i>
					</div>
					<div class="form_row link">
						<div class="label">Ссылка</div>
						<input type="text" name="link" size="60" value="<{$page->link}>" />
					</div>
					<div class="form_row link">
						<input type="checkbox" name="redirect" <{if $page->redirect}>checked<{/if}> />
						<label class="check_label">301 редирект</label>
					</div>
					<div class="form_row def">
						<div class="label">Заголовок страницы и подсказка в меню</div>
						<input type="text" name="pagetitle" size="60" value="<{$page->pagetitle}>" />
					</div>
					<div class="form_row def">
						<div class="label">Название в меню</div>
						<input type="text" name="menutitle" size="60" value="<{$page->menutitle}>" />
					</div>
					<div class="form_row def">
						<div class="label">Атрибуты ссылки в меню</div><div class="help">Для определеного поведения при клике на ссылку.</div>
						<input type="text" name="link_attributes" size="60" value="<{$page->link_attributes}>">
					</div>
					<div class="form_row">
						<div class="label">Заголовок окна</div>
						<input type="text" name="title" size="60" value="<{$page->title}>" />
					</div>
					<div class="form_row">
						<div class="label">Описание</div><div class="help">Описание используется поисковыми системами для отображения в результатах поиска.</div>
						<input type="text" name="description" size="60" value="<{$page->description}>">
					</div>
					<div class="form_row">
						<div class="label">Ключевые слова</div><div class="help">Ключевые слова используется поисковыми системами для определения тематики материала.</div>
						<input type="text" name="keywords" size="60" value="<{$page->keywords}>">
					</div>
					<div class="form_row">
						<div class="label">Метатеги</div><div class="help">Метатеги используется поисковыми системами для определения поведения поискового робота на сайте.</div>
						<input type="text" name="metatags" size="60" value="<{$page->metatags}>">
					</div>
				</div>
				<div class="">
					<div class="form_row def">
						<div class="label">Тип ресурса</div>
						<select id="select_type" name="content_type">
						<{foreach item=content_type key=type_name from=Pages_StaticPage::$content_types}>
							<option value="<{$content_type}>"<{if $content_type == $page->content_type}> selected<{/if}>><{$type_name}>
						<{/foreach}>
						</select>
					</div>
					<div class="form_row module">
						<div class="label">Модуль</div>
						<select name="module">
						<{foreach item=module from=D::getModulesList()}>
							<option value="<{$module.code}>" <{if $module.code == $page->module}> selected<{/if}>><{$module.code}>
						<{/foreach}>
						</select>
					</div>
					<div class="form_row module">
						<div class="label">Действие модуля</div>
						<input type="text" name="action" size="60" value="<{$page->action}>">
					</div>
					<div class="form_row">
						<div class="label">Язык</div>
						<select name="lang">
						<{foreach item=language from=$config->languages}>
							<option value="<{$language}>"<{if $language == $page->lang}> selected<{/if}>><{$language}>
						<{/foreach}>
						</select>
					</div>
					<div class="form_row">
						<div class="label">Шаблон</div>
						<input type="text" name="template" size="60" value="<{$page->template}>">
					</div>
					<div class="form_row def">
						<div class="label">Приоритет</div>
						<input type="text" name="priority" size="60" value="<{$page->priority}>">
					</div>
					<div class="form_row def">
						<input type="checkbox" name="active"<{if $page->active}> checked<{/if}> />
						<label class="check_label">Активен</label>
					</div>
					<div class="form_row def">
						<input type="checkbox" name="menu" <{if $page->menu}> checked<{/if}> />
						<label class="check_label">Показывать в меню</label>
					</div>
					<div class="form_row">
						<input type="checkbox" name="clear" />
						<label class="check_label">Очистить контент под стиль сайта</label>
					</div>
					<div class="form_row">
						<input type="checkbox" name="comments"<{if $page->comments}> checked<{/if}> />
						<label class="check_label">Комментарии</label>
					</div>
					<div class="form_row def">
						<div class="label">Родительский документ</div>
						   <select id="parent_select" name="parent_id">
								<option value="0">Сайт</option>
								<{foreach item=parent from=Pages_StaticPage::getTree()}>
									<option value="<{$parent->content_id}>"
									<{if $parent->content_id == $page->parent_id}>selected<{/if}>>
										<{textformat indent=$parent->offset indent_char="&nbsp;&nbsp;&nbsp;"}>|<{/textformat}>
										<{textformat indent=$dir->offset indent_char="-"}>-<{/textformat}>
										<{$parent->pagetitle}>
									</option>
								<{/foreach}>
						   </select>
					</div>
					<div class="form_row">
						<div class="label">Режим статистики</div>
						  <select name="stat_mode">
							<option title="не собирать статистику" value="1"<{if $page->stat_mode==1}> selected<{/if}>>не собирать статистику</option>
							<option title="считать количество просмотров и время последнего доступа" value="2"<{if $page->stat_mode==2}> selected<{/if}>>общая статистика</option>
							<option title="статистика по каждому просмотру, IP и время" value="3"<{if $page->stat_mode==3}> selected<{/if}>>детальная статистика</option>
							<option title="включая общую и детальную статистику" value="4"<{if $page->stat_mode==4}> selected<{/if}>>полная статистика</option>
						  </select>
					</div>
					<div class="form_row">
						<div class="label">Режим редактирования содержимого</div>
						   <select id="mode" name="mode">
								<option value="edit">Редактор</option>
								<option value="html">Исходный код</option>
						   </select>
					</div>
			</div>
			<div class="form_row def">
				<input type="submit" class="submit" value="#SAVE#">
			</div>
			<div id="submit_status">
			</div>
		</div>
		<div class="form_row">
			<div class="textarea_header">Содержимое раздела</div>
			<div class="textarea_wrap"><textarea id="rich" name="content"><{$page->content}></textarea></div>
		</div>
	</form>