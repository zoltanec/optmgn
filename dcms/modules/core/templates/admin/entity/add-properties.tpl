<h2>Дополнительные поля</h2>
<table class="cms_list">
	<thead>
		<tr>
			<th><b>ID</b></th>
			<th><b>Код</b></th>
			<th><b>Тип</b></th>
			<th><b>Длинна</b></th>
			<th><b>Тип формы</b></th>
			<th><b>Название</b></th>
			<th><b>Единица измерения</b></th>
			<th><b>Зависимое поле</b></th>
			<th><b>Функции</b></th>
		</tr>
	</thead>
	<{foreach item=property from=Core_Entity_Property::getProperties($block_id)}>
	<tbody>
		<form action="<{$run.admin}>/core/entity.update-property/propid_<{$property->prop_id}>" method="post">
		<input type="hidden" name="block_id" value="<{$block_id}>" />
		<tr>
			<td><{$property->prop_id}></td>
			<td class="center"><input type="text" name="prop_code" size="15" value="<{$property->prop_code}>" /></td>
			<td class="center"><select name="prop_type">
					<{foreach item=type key=id from=Core_Entity_Property::$types}>
						<option value="<{$id}>" <{if $property->prop_type==$id}>selected<{/if}>><{$type}></option>
					<{/foreach}>
				</select>
			</td>
			<td class="center"><input type="text" name="prop_length" size="3" value="<{$property->prop_length}>" /></td>
			<td class="center">
				<select name="prop_form_type">
					<{foreach item=type key=id from=Core_Entity_Property::$form_types}>
						<option value="<{$id}>" <{if $property->prop_form_type==$id}>selected<{/if}>><{$type}></option>
					<{/foreach}>
				</select>
			</td>
			<td class="center"><input type="text" name="prop_name" value="<{$property->prop_name}>" /></td>
			<td class="center"><input type="text" name="prop_unit" size="4" value="<{$property->prop_unit}>" /></td>
			<td class="center"><input type="text" name="dependency" size="10" value="<{$property->dependency}>" /></td>
			<td>
				<input class="submit_update" type="submit" name="save" value="Сохранить" />
				<input class="submit_delete" type="submit" name="delete" value="Удалить" />
			</td>
		</tr>
		</form>
	</tbody>
	<{/foreach}>
	<tbody>
		<form action="<{$run.admin}>/core/entity.update-property" method="post">
		<input type="hidden" name="block_id" value="<{$block_id}>" />
		<tr>
			<td></td>
			<td class="center"><input type="text" name="prop_code" size="15" /></td>
			<td class="center">
				<select name="prop_type">
					<{foreach item=type key=id from=Core_Entity_Property::$types}>
						<option value="<{$id}>"><{$type}></option>
					<{/foreach}>
				</select>
			</td>
			<td class="center"><input type="text" name="prop_length" size="4" value="" /></td>
			<td class="center">
				<select name="prop_form_type">
					<{foreach item=type key=id from=Core_Entity_Property::$form_types}>
						<option value="<{$id}>"><{$type}></option>
					<{/foreach}>
				</select>
			</td>
			<td class="center"><input type="text" name="prop_name" /></td>
			<td class="center"><input type="text" name="prop_unit" size="4" /></td>
			<td class="center"><input type="text" name="dependency" size="10" /></td>
			<td>
				<input class="submit_update" type="submit" name="save" value="Сохранить" />
			</td>
		</tr>
		</form>
	</tbody>
</table>