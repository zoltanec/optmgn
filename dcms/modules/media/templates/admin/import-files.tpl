<script type="text/javascript">
function loadSubdirs(inDir) {
	subdirName = '#subdirs_' + inDir;
	$.post('<{$t.run.me}>/load-subdirs/', { dir: inDir }, function(answer) {
		$(subdirName).html(answer).show();
	});
}
</script>
<h2>Импорт из папки</h2>

<form method="post" action="<{$t.run.me}>/make-import/">
Выберите папку, из которой хотите импортировать файлы ( данные каталоги расположены в /content/media/upload/ ): <br />
<{assign var=subdirs value=Media_Dir::uploadsubdir()}>
<table>
<{foreach item=dir from=$subdirs}>
 <tr>
 <td><input type="checkbox" name="importdir[]" value="<{$dir}>"></td>
 <td><{$dir}></td>
 <td><a onclick='return loadSubdirs("<{$dir}>");' href="#">[показать]</a></td>
 </tr>
 <tr>
 <td></td>
 <td style="display: none;" colspan="2" id="subdirs_<{$dir}>"></td>
 </tr>
<{/foreach}>
</table>
Куда поместить файлы: <br />
<select name="parentid">
 	<{foreach item=dir from=D_Core_Factory::Media_Dir('root')->subdirs}>
 			<option value="<{$dir->dirid}>"<{if $dir->dirid == $req->dirid}> selected<{/if}>><{$dir->dirname}> ( <{$dir->dirid}> )
 	<{/foreach}>
</select>

<input type="submit" class="submit_add" value="Импортировать">
</form>