<table class="list">
	<tr>
		<th colspan="2"><b>Название</b></th>
		<th><b>Размер</b></th>
		<th colspan="2"><b>Владелец</b></th>
		<th><b>Права</b></th>
		<th><b>Изменен</b></th>
		<th><b>Тип</b></th>
		<th><b>Функции</b></th>
	</tr>
	<{foreach item=file from=$dir->lsdir()}>
	<tr>
		<{if $file->filename == '..'}>
			<td style="cursor: pointer;" colspan="9" onclick='document.location.href="<{$run.me}>/cd-dir/currentdir_<{$dir->getParentPwd64()}>"'>
				<a href="<{$run.me}>/cd-dir/currentdir_<{$dir->getParentPwd64()}>"><img src="<{$config->cdn_images}>/admin/up_folder.png">&nbsp;..</a>
			</td>
		<{else}>

		<{if $file->filetype=='dir'}>
			<td class="fm_icon"><img src="<{$theme.images}>/filemanager/folder.png"></td>
			<td><a class="fm_folder" href="<{$run.me}>/cd-dir/currentdir_<{$file->getPwd64()}>"><b><{$file->filename}></b></a></td>
		<{else}>
			<td class="fm_icon"><img src="<{$theme.images}>/filemanager/file.png"></td>
			<td><{$file->filename}></td>
		<{/if}>
		<td><{$file->filesize}></td>
		<td><{$file->owner.name}></td>
		<td><{$file->group.name}></td>
		<td><{$file->perms}></td>
		<td><{$file->updatetime|convert_time}></td>
		<td><{if $file->filetype=='dir'}>Директория<{elseif $file->filetype=='file'}>файл<{/if}></td>
		<td><a class="edit_link" href="<{$t.run.me}>/edit-file/file_<{$file->getPwd64()}>">Правка</a>
		    <a class="delete_link" href="<{$t.run.me}>/delete-file/file_<{$file->getPwd64()}>">удалить</a></td>
		<{/if}>

	</tr>
	<{/foreach}>
</table>