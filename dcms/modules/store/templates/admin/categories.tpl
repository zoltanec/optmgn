<h2>Управление категориями</h2>
<form action="<{$t.run.me}>/submit-category" method="post" enctype="multipart/form-data" >
<table class="cms_form">
	<tr>
		<td colspan="2"><b>Добавить категорию</b></td>
	</tr>
	<tr>
		<td>Название категории</td>
		<td><input type="text" size="35" name="category_name" /></td>
	</tr>
	<tr>
		<td>Родительская категория</td>
		<td>
			<select name="category_pid">
				<option value="0">Корневой раздел</option>
				<{foreach item=category from=Store_Category::getAllCategories()}>
					<option value="<{$category->category_id}>"><{$category->category_name}></option>
				<{/foreach}>
			</select>
		</td>
	</tr>

	<{*<tr>
		<td>Логотип</td>
		<td><input type="file" name="category_logo" /></td>
	</tr>*}>
	<tr>
		<td></td>
		<td><input class="submit_add" type="submit" value="#ADD#" /></td>
	</tr>
</table>
</form>

<h2>Управление категориями товаров</h2>
<table class="cms_list" data-list-funcs="delete active edit">
	<thead>
	<tr>
		<th><b>№</b></th>
		<th><b>Название категории</b></th>
		<th><b>Родительская категория</b></th>
		<th>A</th>
		<th><b>Приоритет</b></th>

		<th colspan="3"><b>Функции</b></th>
	</tr>
	</thead>
	<{foreach item=category from=Store_Category::getAllCategories()}>
	<tbody data-type="element" data-id="<{$category->nid}>" data-active="<{$category->active}>" data-object-id="<{$category->object_id()}>">
		<form action="<{$t.run.me}>/update-category" enctype="multipart/form-data" method="post">
		<tr>
			<td><{$category->category_id}></td>
			<{*<td><input type="file" name="category_logo" /></td>*}>
			<td align="center">
				<input type="hidden" name="category_id" value="<{$category->category_id}>" />
				<input type="text" size="35" name="category_name" value="<{$category->category_name}>" />
			</td>
			<td>
				<select name="category_pid">
				<option value="0">Корневой раздел</option>
				<{foreach item=pcategory from=Store_Category::getAllCategories()}>
					<{if $pcategory->category_id!=$category->category_id}><option value="<{$pcategory->category_id}>" <{if $pcategory->category_id==$category->category_pid}>selected="selected"<{/if}>><{$pcategory->category_name}></option><{/if}>
				<{/foreach}>
				</select>

			</td>
			<td class="active"></td>
			<td>
			<a href="<{$run.me}>/priority-category/mode_up/category_<{$category->category_id}>">
				<img src="<{$config->cdn_images}>/admin/up.png" title="Повысить" border="0" />
			</a>
			<b><{$category->priority}></b>
			<a href="<{$run.me}>/priority-category/mode_down/category_<{$category->category_id}>">
				<img src="<{$config->cdn_images}>/admin/down.png" width="20" title="Понизить" border="0" />
			</a>
	   </td>
		<td class="edit" data-url="<{$run.me}>/edit-category/catid_<{$category->category_id}>/"></td>
		<td class="delete"></td>
		</tr>
		</form>
	</tbody>
	<{/foreach}>
</table>