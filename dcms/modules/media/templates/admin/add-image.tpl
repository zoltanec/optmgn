<div class="label"><{if $title}><{$title}><{else}>Загрузить картинку<{/if}></div>
	<form class="upload" method="post" action="<{$me.path}>/run/media/add-image" enctype="multipart/form-data">
		<div class="add-image" data-object-id="<{$object_id}>" data-mode="<{$mode}>" data-module="<{$module}>">
		<input type="hidden" name="object_id" value="<{$object_id}>" />
		<input type="hidden" name="file_id" value="<{$file_id}>" />
		<input type="hidden" name="mode" value="<{$mode}>" />
		<input type="hidden" name="module" value="<{$module}>" />
    <input type="hidden" name="object" value="<{$object}>" />
		<input type="file" name="file[]" class="<{if $mode!='icon'}>multi<{/if}> with-preview" />
    <input type="submit" class="submit_add" value="Отправить" />
		</div>
	</form>
	<div id="output"></div>
<{*include title="иконка" object_id="`$page->alias`" mode="icon" file="media;admin/add-image.tpl"*}>
<{*include title="иконка в меню" object_id="`$page->alias`_menu" mode="icon" file="media;admin/add-image.tpl"*}>
<{*include title="Картинку в раздел" object_id="`$page->alias`" file_id="testoff" file="media;admin/add-image.tpl"*}>
<{*include title="Картинку в раздел с итерацией" object_id="`$page->alias`" mode="iteration" file="media;admin/add-image.tpl"или mode отсутствует*}>
<{*include title="Картинку в раздел c сохранением имени" object_id="`$page->alias`" file="media;admin/add-image.tpl"*}>
