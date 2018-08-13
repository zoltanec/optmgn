<h2>Управление категориями</h2>
<form action="<{$run.admin}>/core/sections.submit-section" method="post" enctype="multipart/form-data" >
<table class="cms_form">
	<tr>
		<td colspan="2"><b>Добавить категорию</b></td>
	</tr>
	<tr>
		<td>Название категории</td>
		<td><input type="text" size="35" name="section_name" /></td>
	</tr>
	<{if $module}>
		<input type="hidden" name="module_name" value="<{$module}>">
	<{else}>
	<tr>
		<td>Модуль</td>
		<td>
			<select id="module_name" name="module_name">
				<option value="">Выберите модуль</option>
				<{foreach item=module from=D::getModulesList()}>
					<option value="<{$module.code}>"><{$module.code}></option>
				<{/foreach}>
			</select>
		</td>
	</tr>
	<{/if}>
	<tr>
		<td>Родительская категория</td>
		<td>
			<select id="section_pid" name="pid">
				<option value="0">Корневой раздел</option>
				<{if $module}>
					<{foreach item=section from=$sections}>
						<option value="<{$section->sid}>"><{$section->section_name}></option>
					<{/foreach}>
				<{/if}>
			</select>
		</td>
	</tr>
	<{*<tr>
		<td>Логотип</td>
		<td><input type="file" name="image" /></td>
	</tr>*}>
	<tr>
		<td></td>
		<td><input class="submit_add" type="submit" value="#ADD#" /></td>
	</tr>
</table>
</form>
<h2>Управление подкатегориями</h2>
<table class="cms_list">
	<thead>
	<tr>
		<th><b>#</b></th>
		<th><b>Модуль</b></th>
		<th><b>Название категории</b></th>
		<th><b>Родительская категория</b></th>
		<th><b>Приоритет</b></th>
		<th><b>Функции</b></th>
	</tr>
	</thead>
	<{foreach item=section from=$sections}>
	<tbody>
		<form action="<{$run.admin}>/core/sections.update-section" enctype="multipart/form-data" method="post">
		<input type="hidden" name="module_name" value="<{$run.module}>" />
		<tr>
			<td><{$section->sid}></td>
			<td align="center">	
				<{$section->module_name}>
			</td>
			<{*<td><input type="file" name="image" /></td>*}>
			<td align="center">	
				<input type="hidden" name="sid" value="<{$section->sid}>" />
				<input type="text" size="35" name="section_name" value="<{$section->section_name}>" />
			</td>
			<td class="center">
				<select name="pid">
				<option value="0">Корневой раздел</option>
				<{foreach item=psection from=Core_Sections_Section::getAllSections($section->module_name)}>
					<{if $psection->sid!=$section->sid}>
						<option value="<{$psection->sid}>" <{if $psection->sid==$section->pid}>selected="selected"<{/if}>>
							<{$psection->section_name}>
						</option>
					<{/if}>
				<{/foreach}>
				</select>
				
			</td>
			<td class="priority center">
				<a class="up" href="<{$run.admin}>/core/sections.priority-section/mode_up/sid_<{$section->sid}>">
				</a>
				<b><{$section->priority}></b>
				<a class="down" href="<{$run.admin}>/core/sections.priority-section/mode_down/sid_<{$section->sid}>">
				</a>
			</td>
			<td align="center">
				<input class="submit_update" type="submit" name="save" value="Сохранить" />
				<input class="submit_delete" type="submit" name="delete" value="Удалить" />
			</td>
		</tr>
	</form>	
	</tbody>
	<{/foreach}>
</table>
<script type="text/javascript">
	$("select#module_name").change(function(){
		if($(this).val())
			$.getJSON("<{$run.admin}>/core/sections.get-sections/module_"+$(this).val(),function(answer){
				$("select#section_pid").html("");
				$("select#section_pid").append("<option value=0>Корневой раздел</option>");
				$.each(answer,function(item,section){
					$("select#section_pid").append("<option value="+section.sid+">"+section.section_name+"</option>");
				});
			});
		return false;
	});
</script>