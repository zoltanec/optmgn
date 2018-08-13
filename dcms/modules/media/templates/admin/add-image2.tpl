	<h2><{if $title}><{$title}><{else}>Загрузить картинку<{/if}></h2>
		<form method="post" action="<{$me.path}>/run/media/add-image/object_<{$object_id}>/" enctype="multipart/form-data">
			<input type="hidden" name="filetype" value="picture" />
			<input type="file" name="image">
			<input type="mode" name="<{$mode}>">
			<input type="submit" class="submit_add" value="Отправить">
		</form>
images/$dir/$object_id.jpg
images/$dir/$object_id_menu.jpg
<{include title="иконка" object_id="`$page->content_name`" mode="icon" file="media;admin/add-image.tpl"}>
<{include title="иконка в меню" object_id="`$page->content_name`_menu" mode="icon" file="media;admin/add-image.tpl"}>
<{include title="Картинку в раздел" object_id="`$page->content_name`" file_id="testoff" file="media;admin/add-image.tpl"}>
<{include title="Картинку в раздел с итерацией" object_id="`$page->content_name`" mode="iteration" file="media;admin/add-image.tpl"}>
<{include title="Картинку в раздел c сохранением имени" object_id="`$page->content_name`" file="media;admin/add-image.tpl"}>
