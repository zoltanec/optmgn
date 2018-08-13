<{if $current_dir->dirid != 'root'}>
	<a href="<{$run.me}>/categories/dir_<{$current_dir->parent->dirid}>/">Вернутся в родительский каталог ( <{$current_dir->parent->dirname}> )</a>
<{/if}>
<h2>Редактирование параметров каталога</h2>
<form method="post" enctype ="multipart/form-data" action="<{$run.me}>/update-dir/dir_<{$current_dir->dirid}>/">
<input type="hidden" size="60" name="naming" value="<{$current_dir->naming}>">
	<input type="hidden" size="60" name="file_naming" value="<{$current_dir->file_naming}>">
	<table class="cms_form">
		<tbody>
			<tr>
				<td>
					Логотип каталога<br />
					Текущий логотип:<br />
					<img src="<{$run.my_content}>/dir_preview/<{$current_dir->dirid}>.png">
				</td>
				<td>
					<input type="file" name="dir_preview">
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Псевдоним:</td>
				<td><{$current_dir->dirid}></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Заголовок:</td>
				<td><input type="text" name="dirname" value="<{$current_dir->dirname}>"></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Активен:</td>
				<td><input type="checkbox" name="active" value="1"<{if $current_dir->active}> checked<{/if}>>
		</tbody>
	<{if $current_dir->dirid != 'root'}>
		<tbody>
			<tr>
				<td>Родительский каталог:</td>
				<td>
					<select name="parentid">
						<{foreach item=dir from=Media_Dir::getDirsTree()}>
							<option
									value="<{$dir->dirid}>"
									<{if $current_dir->dirid == $dir->dirid}>selected<{/if}>>
									<{textformat indent=$dir->offset indent_char="&nbsp;&nbsp;&nbsp;"}>&nbsp;|<{/textformat}>
									<{textformat indent=$dir->offset indent_char="-"}>-&nbsp;<{/textformat}>
									<{$dir->dirname}>
							</option>
						<{/foreach}>
					</select>
				</td>
			</tr>
		</tbody>
	<{/if}>
		<tbody>
			<tr>
				<td>Заголовок окна:</td>
				<td><textarea name="title" rows="5" cols="60"><{$current_dir->title}></textarea></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Описание:</td>
				<td><textarea name="descr" rows="5" cols="60"><{$current_dir->descr}></textarea></td>
			</tr>
		</tbody>
		<{*tbody>
			<tr>
				<td>Шаблон для fileid:</td>
				<td></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Шаблон имен:</td>
				<td></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Функции: </td>
				<td>
					<a href="#" onclick="return D.modules.media.update_media_dir_stat('<{$current_dir->dirid}>');">Обновить статистику</a>
					<a href="#" onclick="return D.modules.media.import_files_to_dir('<{$current_dir->dirid}>');">Импортировать файлы</a>
				</td>
			</tr>
		</tbody*}>
		<tbody>
			<tr>
				<td></td>
				<td><input type="submit" class="submit submit_update" value="#SAVE#"></td>
			</tr>
		</tbody>
	</table>
</form>
