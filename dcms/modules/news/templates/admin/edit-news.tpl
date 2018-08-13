<{*script type="text/javascript">
$(document).ready(function() {
	$('#select_news_icon').bind('change keyup', function() {
		$('#news_icon').attr('src','<{$run.my_content}>/icons/' + $(this).val());
	});
});
</script*}>
<{include title="Иконка новости 680x442" object_id="icons" module="news" object="icon" file_id="`$news->alias`" mode="icon" file="media;admin/add-image.tpl"}>
<img id="icon" style="vertical-align: middle; max-width: 120px;" src="<{$news->__thumbs_url()}>" />
<form method="post" action="<{$run.me}>/update-news/nid_<{$news->nid}>/">
<table class="cms_form">
	<{formline type='header'}>
	<{formblock title='Ссылка на новость'}>
		<a href="<{$run.path}>/read/<{$news->nid}>/" target="_blank"><{$run.path}>/read/<{$news->nid}>/</a></td>
	<{/formblock}>

	<{formline title='Заголовок новости' size='40' name='title' value=$news->title}>
	<{formblock title='Раздел'}>
		<select name="sid">
        	<{foreach item=section from=News_Sections::getAllSections()}>
            	<option <{if $section->sid == $news->sid}>selected <{/if}>value="<{$section->sid}>"><{$section->section_name}></option>
        	<{/foreach}>
        </select>
	<{/formblock}>
	<{formline title='Автор' name='author' value=$news->author}>
	<{*formblock title='Иконка'}>
		<img id="news_icon" style="vertical-align: middle; max-width: 100px; max-height: 100px;" src="<{$run.my_content}>/icons/<{$news->icon}>">
 		<select name="icon" id="select_news_icon">
 		<{foreach item=icon from=News_News::getIconsList()}>
 			<option value="<{$icon}>"<{if $icon == $news->icon}> selected<{/if}>><{$icon}>
 		<{/foreach}>
 		</select>
	<{/formblock*}>
	<{formblock title='Режим сохранения'}>
		<select name="mode">
			<option value="html">HTML
			<option value="bbcode">BBCode
		</select>
	<{/formblock}>
	<{formline type='bool' title='Опубликовать новость' name='active' value=$news->active}>
	<{formline type='bool' title='Задержка публикации' name='publish_delay' value=$news->publish_delay}>
	<{formblock title='Время публикации'}>
		<input type="text" name="publish_time" value="<{$news->publish_time}>" placeholder="2020-01-01 01:23:45">
	<{/formblock}>
	<{formline type='bool' title='Комментарии к новости' name='comments_status' value=$news->comments_status}>
	<{formline type='bool' title='Поддерживать в топе' name='ontop' value=$news->ontop}>
	<{formline title='Источник' name='source' value=$news->source}>
	<{formline title='Теги' name='tags' value=$news->tags}>
	<{formblock title='Использовать WYSIWYG'}>
 		<input type="checkbox" checked onclick='return toggleEditor("rich");'></td>
	<{/formblock}>
	<{formline title='Короткое описание' type='textarea' name='content_preview' value=$news->content_preview}>
	<{formblock title='Комментарии'}>
		<{include file='comments;admin/comments-object' object_id=$news->object_id()}></td>
	<{/formblock}>

	<{formblock title='Содержание'}>
		<textarea id="rich" name="content" rows="25" cols="100"><{$news->content}></textarea>
	<{/formblock}>
 	<{formline type='save'}>
</table>
</form>