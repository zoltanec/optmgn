<h2>Управление файлами</h2>
<table class="cms_form">
<tbody>
<form action="<{$t.run.me}>/add-dir" method="post">
<tr>
  <td>
	<input type="hidden" name="current_dir" value="<{$dir->pwd}>" />
	<input type="text" name="new_dir" value="Новая директория" />
	<input type="submit" class="submit_add" value="#ADD#"/>
  </td>
</tr>
</form>
</tbody>
<tbody>
<form action="<{$t.run.me}>/add-file" enctype="multipart/form-data" method="post">
<tr>
  <td>
	<input type="hidden" name="current_dir" value="<{$dir->pwd}>" />
	<input type="file" name="upload_file" />
	<input type="submit" class="submit_add" value="#ADD#"/>
  </td>
</tr>
</form>
</tbody>
</table>
<div class="fm_currentdir">
	Текущий каталог: <{$dir->pwd}>
</div>
<table class="cms_list">
      <thead>
	<tr>
		<th colspan="2"><b>Название</b></th>
		<th><b>Размер</b></th>
		<th><b>Владелец</b></th>
		<th><b>Права</b></th>
		<th><b>Изменен</b></th>
		<th><b>Тип</b></th>
		<th><b>Функции</b></th>
	</tr>
      </thead>
      
	<{foreach item=file from=$dir->lsdir()}>
<tbody>
	<tr>
		<{if $file->filename == '..'}>
			<td style="cursor: pointer;" colspan="9" onclick='document.location.href="<{$run.me}>/cd-dir/currentdir_<{$dir->getParentPwd64()}>"'>
				<a href="<{$run.me}>/cd-dir/currentdir_<{$dir->getParentPwd64()}>"><img src="<{$config->cdn_images}>/admin/up_folder.png">&nbsp;..</a>
			</td>
		<{else}>

		<{if $file->filetype=='dir'}>
			<td class="fm_icon"><img src="<{$config->cdn_images}>/admin/filemanager/folder.png"></td>
			<td><a class="fm_folder" href="<{$run.me}>/cd-dir/currentdir_<{$file->getPwd64()}>"><b><{$file->filename}></b></a></td>
		<{else}>
			<td class="fm_icon"><img src="<{$config->cdn_images}>/admin/filemanager/file.png"></td>
			<td><{$file->filename}></td>
		<{/if}>
		<td><{$file->filesize}></td>
		<td><{$file->owner.name}> <{$file->group.name}></td>
		<td><{$file->perms}></td>
		<td><{$file->updatetime|convert_time}></td>
		<td><{if $file->filetype=='dir'}>Директория<{elseif $file->filetype=='file'}>файл<{/if}></td>
		<td><a class="edit_link" href="<{$t.run.me}>/edit-file/file_<{$file->getPwd64()}>">Правка</a>
		    <a class="delete_link" href="<{$t.run.me}>/delete-file/file_<{$file->getPwd64()}>">удалить</a></td>
		<{/if}>

	</tr>
</tbody>
	<{/foreach}>
</table>
