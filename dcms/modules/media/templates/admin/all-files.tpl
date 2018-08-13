<{if !is_object($current_dir) && $object_id}>
	<{assign var=current_dir value=Media_Dir::includeDir($object_id)}>
	<h2>Изображения</h2>
		<form method="post" action="<{$me.path}>/run/media/add-file" enctype="multipart/form-data">
			<input type="hidden" name="dir" value="<{$current_dir->dirid}>" />
			<input type="hidden" name="mode" value="extend" />
			<input type="file" name="mediafile" />
			<input type="submit" class="submit_add" value="Отправить">
		</form>
	<p>
	Если вы загрузите несколько фото, порядок отображения будет определяться приоритетом и датой добавления
	</p>
<{/if}>
<h2>Список файлов</h2>
<table class="cms_list" data-list-funcs="delete edit fields">
	<thead>
		<tr>
			<th><input type="checkbox" name="select_unselect_all"></th>
			<th>N</th>
			<th colspan="2">Название</th>
			<th>Описание</th>
			<th>Приоритет</th>
			<th colspan="2">Функции</th>
		</tr>
	</thead>
	<{if $run.module=='media'}>
	<tbody>
		<tr>
			<td colspan="3">
				Сортировка по каталогу:
			</td>
			<td colspan="4">
				<form id="dirsort" method="post" action="<{$run.me}>/index">
					<select id="parent_select" name="dir">
            <option value="root">Все</option>
						<{foreach item=dir from=Media_Dir::getDirsTree()}>
							<option 
								value="<{$dir->dirid}>"
								<{if $current_dir->dirid == $dir->dirid}>selected<{/if}>>
								<{textformat indent=$dir->offset indent_char="&nbsp;&nbsp;&nbsp;&nbsp;"}>|-<{/textformat}><{textformat indent=$dir->offset indent_char="-"}> <{/textformat}>
								<{$dir->dirname}>
							</option>
						<{/foreach}>
					</select>
				</form>
			</td> 
		</tr>
	</tbody>
	<{/if}>
	<{if true}>
	<{foreach item=file from=$current_dir->files_all}>
		<tbody data-type="element" data-id="<{$file->fileid}>" data-object-id="<{$file->object_id()}>">
			
			<tr class="media_dir_file" title="<{$file->fileid}>">
				<form method="post" action="<{$me.www}>/admin/run/media/update-file-info/dirid_<{$current_dir->dirid}>/fileid_<{$file->fileid}>/" enctype="multipart/form-data">
				<td><input type="checkbox" class="media_file_checkbox" name="check"></td>
				<td class="num"><{$file->num}></td>
				<td class="preview"><img width="100" src="<{$me.content}>/media/thumbs/<{$file->parentid}>/<{$file->fileid}>"></td>
				<td>
					<input type="text" name="filename" size="25" value="<{$file->filename}>"><br />
				</td>
				<td class="center"><textarea name="descr" cols="35" rows="3"><{$file->descr}></textarea></td>
				<td data-field="priority" class="priority center">
					<a class="up" title="Повысить" data-field-func="inc"></a>
					<b data-field-func="value"><{$file->priority}></b>
					<a class="down" title="Понизить" data-field-func="dec">
					</a>
				</td>
				<td><input type="submit" value="#SAVE#" /></td>
				<td class="delete" width="22px"></td></form>
			</tr>
			
		</tbody>
		<{/foreach}>
		<{else}>
			В текущем каталоге нет файлов
		<{/if}>
</table>