<h2>Существующие разделы</h2>

<a href="<{$run.me}>/add-section/">Добавить раздел</a>

<table class="list">
	<thead>
		<tr>
			<th>N</th>
			<th>SID</th>
			<th>KEY</th>
			<th>Название</th>
			<th>Приоритет</th>
			<th colspan="2">Функции</th>
		</tr>
	</thead>
<{foreach item=section from=News_Sections::getAllSections()}>
	<tr>
		<td class="num"><{$section->num}></td>
		<td><{$section->sid}></td>
		<td><{$section->section_key}></td>
		<td><{$section->section_name}></td>
		<td class="priority"><a href="<{$run.me}>/update-section-priority/sid_<{$section->sid}>/mode_up/"><img src="<{$config->cdn_images}>/admin/up.png" width="20" border="0"></a>
		     <{$section->priority}>
		     <a href="<{$run.me}>/update-section-priority/sid_<{$section->sid}>/mode_down/"><img src="<{$config->cdn_images}>/admin/down.png" width="20" border="0"></a>
		</td>
		<td><a class="edit_link" href="<{$run.me}>/edit-section/sid_<{$section->sid}>/">#EDIT#</a></td>
		<td><a class="delete_link" href="<{$run.me}>/delete-section/sid_<{$section->sid}>/">#DELETE#</a></td>
	</tr>
<{/foreach}>
</table>