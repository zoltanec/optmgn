<{if $current_dir->dirid != 'root'}>
	<a href="<{$run.me}>/categories/dir_<{$current_dir->parent->dirid}>/">Вернутся в родительский каталог ( <{$current_dir->parent->dirname}> )</a>
<{/if}>
<h2>Добавить новый каталог файлов</h2>
<form method="post" action="<{$run.me}>/add-dir/parentid_<{$current_dir->dirid}>/">
<table class="cms_form">
	<tbody>
		<tr>
			<td>Уникальный ID каталога</td>
			<td><input type="text" name="dirid" placeholder="Уникальный ID каталога"></td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td>Имя каталога</td>
			<td><input type="text" name="dirname" placeholder="Имя каталога"></td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td>Заголовок окна каталога</td>
			<td><input type="text" name="title" placeholder="Заголовок окна каталога"></td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td>Описание каталога</td>
			<td><textarea type="text" name="descr" placeholder="Описание каталога"></textarea></td>
		</tr>
	</tbody>
	<tbody>
		<tr>
				<td></td>
				<td><input type="submit" class="submit submit_update" value="#ADD#"></td>
		</tr>
	</tbody>
</table>
</form>
<{if count($current_dir->subdirs_all)!=0}>
<h2>Подкаталоги раздела <<<{$current_dir->dirname}>>></h2>
<table class="cms_list" data-list-funcs="delete active edit fields">
	<thead>
		<tr>
			<th>N</th>
			<th>ID каталога</th>
			<th>S</th>
			<th>Имя каталога</th>
			<th>Приоритет</th>
			<th colspan="2">#FUNCTIONS#</th>
		</tr>
	</thead>
<{foreach item=dir from=$current_dir->subdirs_all}>
	<tbody data-type="element" data-id="<{$dir->dirid}>" data-active="<{$dir->active}>" data-object-id="<{$dir->object_id()}>">
		<tr  class="cms_list_item">
			<td class="num"><{$dir->num}></td>
			<td><{$dir->dirid}></td>
			<td class="active"></td>
			<td><a href="<{$run.me}>/categories/dir_<{$dir->dirid}>" data-name="title"><{$dir->dirname}></a></td>
			<td data-field="priority" class="priority center">
					<a class="up" title="Повысить" data-field-func="inc"></a>
					<b data-field-func="value"><{$dir->priority}></b>
					<a class="down" title="Понизить" data-field-func="dec">
					</a>
				</td>
			<td class="edit" data-url="<{$run.me}>/edit-dir/dir_<{$dir->dirid}>"></td>
			<td class="delete"></td>
		</tr>
	</tbody>
<{/foreach}>
</table>
<{else}>
Нет ни одного подраздела
<{/if}>