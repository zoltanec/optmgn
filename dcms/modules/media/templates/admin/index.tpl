<h2>Добавление файла</h2>
<form method="post" enctype="multipart/form-data" action="<{$run.me}>/add-file/">
	<table class="cms_form">
		<tbody>
			<tr>
				<td>Файл</td>
				<td><input type="file" name="mediafile"></td>
			</tr>
			<tr>
		  		<td>Название:</td>
		   		<td><input type="text" name="filename"></td>
			</tr>
			<tr>
		  		<td>Описание:</td>
		   		<td><textarea cols="42" rows="2" name="descr"></textarea>
			</tr>
			<tr>
				<td>Родительский Каталог:</td>
				<td><{$dir->dirid}>
						<select id="parent_select" name="dir">
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
			<tr>
		 		<td></td>
		 		<td><input type="submit" class="submit submit_update" name="addfile" value="#ADD#"></td>
		 	</tr>
		</tbody>
	</table>
</form>
<{include file='admin/all-files.tpl'}>