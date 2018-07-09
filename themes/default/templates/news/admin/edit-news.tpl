<div class="form-bl">
    <{include title="Иконка новости 323x251" object_id="icons" module="news" object="icon" file_id="`$news->alias`" mode="icon" file="media;admin/add-image.tpl"}>
    <img id="icon" style="vertical-align: middle; max-width: 120px;" src="<{$news->__thumbs_url()}>" />
</div>
<div class="form-bl">
    <{include title="Изображение для слайдера 680x454" object_id="slider/news`$news->nid`" module="news" object="icon" file_id="`$news->alias`" mode="iteration" file="media;admin/add-image.tpl"}>
    <div class="list-images" data-src="<{$news->__thumbs_slider_url()}>">
        <{foreach item=slide from=$news->__thumbs_sliders()}>
            <img style="vertical-align: middle; max-width: 120px;" src="<{$slide}>" />
        <{/foreach}>
    </div>
</div>
<form method="post" action="<{$run.me}>/update-news/nid_<{$news->nid}>/">
<table class="cms_form">
	<{formline type='header'}>
	<{formblock title='Ссылка на новость'}>
		<a href="<{$run.path}>/read/<{$news->nid}>/" target="_blank"><{$run.path}>/read/<{$news->nid}>/</a></td>
	<{/formblock}>

	<{formline title='Заголовок новости' size='40' name='title' value=$news->title}>
    <{formline title='Ссылка на youtube видео' size='40' name='source' value=$news->source}>
	<{formblock title='Раздел'}>
		<select name="sid">
        	<{foreach item=section from=News_Sections::getAllSections()}>
            	<option <{if $section->sid == $news->sid}>selected <{/if}>value="<{$section->sid}>"><{$section->section_name}></option>
        	<{/foreach}>
        </select>
	<{/formblock}>
	<{formline type='bool' title='Опубликовать новость' name='active' value=$news->active}>
	<{formline title='Короткое описание' type='textarea' name='content_preview' value=$news->content_preview}>

	<{formblock title='Содержание'}>
		<textarea id="rich" name="content" rows="25" cols="100"><{$news->content}></textarea>
	<{/formblock}>
 	<{formline type='save'}>
</table>
</form>