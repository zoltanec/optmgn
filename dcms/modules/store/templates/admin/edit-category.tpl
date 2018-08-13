<form method="post" action="<{$run.me}>/update-category/">
<input type="hidden" name="catid" value="<{$category->catid}>">
<table class="cms_form">
	<{formline type='header'}>
	<{formline title='Название' name='category_name' value=$category->category_name}>
    <{formline title='Заголовок страницы' name='title' value=$category->title}>
    <{formline title='Описание' name='descr' value=$category->descr}>
	<{formline title='Код раздела' name='category_code' value=$category->category_code}>
	<{formline title='Код импорта' name='import_code' value=$category->import_code}>
	<{formline title='Категория' type='select' name='category_pid' list=Store_Category::getAllCategories() with_null='Корень' value=$category->category_pid showfield='category_name' field='category_id'}>
	<{formline title='Активна' name='active' type='bool' value=$category->active}>
	<{formline title='Спец.шаблон' name='custom_tpl' type='bool' value=$category->custom_tpl}>
	<{formline type='save'}>
</table>
</form>



<h2>Управление категориями товаров</h2>
<form method="post" action="<{$run.me}>/add-category/">
<{formline type='hidden' name='cid' value=$category->category_id}>
<table class="cms_form">
	<{formline title='Название' name='category_name'}>
	<{formline type='save'}>
</table>
<table class="cms_list" data-list-funcs="delete active edit fields">
	<thead>
	<tr>
		<th><b>№</b></th>
		<th><b>Название категории</b></th>
		<th>A</th>
		<th><b>Приоритет</b></th>

		<th colspan="3"><b>Функции</b></th>
	</tr>
	</thead>
	<{foreach item=subcategory from=$category->categories}>
	<tbody data-type="element" data-id="<{$subcategory->nid}>" data-active="<{$subcategory->active}>" data-object-id="<{$subcategory->object_id()}>">
		<tr>
			<td><{$subcategory->category_id}></td>
			<td align="center">
				<a href="<{$run.me}>/edit-category/catid_<{$subcategory->category_id}>/"><{$subcategory->category_name}></a>
			</td>

			<td class="active"></td>

			<td data-field="priority" class="priority">
	    		<a class="up" title="Повысить" data-field-func="inc"></a>
				<b data-field-func="value"><{$subcategory->priority}></b>
				<a class="down" title="Понизить" data-field-func="dec"></a>
   			</td>

			<td class="edit" data-url="<{$run.me}>/edit-category/catid_<{$subcategory->subcategory_id}>/"></td>
			<td class="delete"></td>
			</tr>
	</tbody>
	<{/foreach}>
</table>

<h2>Поля</h2>
<table class="cms_list">
	<{foreach item=field from=$category->fields}>
		<{formline title='Код' name='code' value=$field->code}>
		<{formline title='Тип' name='ptype' value=$field->ptype}>
	<{/foreach}>
</table>


<h2>Товары</h2>

<table class="cms_list" data-list-funcs="delete active edit fields">
	<thead>
		<tr>
			<th><b>N/b></th>
			<th>Фото</th>
			<th>Название</th>
			<th>Цена</th>
			<th>А</th>
			<th>Приоритет</th>
			<th colspan="2">Функции</th>
		</tr>
	</thead>
<{foreach item=prod from=$category->products}>
	<tbody data-type="element" data-id="<{$prod->prod_id}>" data-active="<{$prod->active}>" data-object-id="<{$prod->object_id()}>">
		<tr>
			<td class="center"><{$prod->prod_id}></td>
			<td class="center"><img width="90" src="<{$me.content}>/media/thumbs/product<{$prod->prod_id}>/<{$prod->picture->fileid}>" /></td>
			<td><a href="<{$run.me}>/edit-product/pid_<{$prod->prod_id}>/"><{$prod->prod_name}></a></td>
			<td class="center"><{$prod->price}> руб.</td>
			<td class="active"></td>
			<td data-field="priority" class="priority">
	    		<a class="up" title="Повысить" data-field-func="inc"></a>
				<b data-field-func="value"><{$prod->priority}></b>
				<a class="down" title="Понизить" data-field-func="dec"></a>
   			</td>
   			<td class="edit" data-url="<{$run.me}>/edit-product/pid_<{$prod->prod_id}>/"></td>
			<td class="delete"></td>
		</tr>
	</tbody>
<{/foreach}>
</table>
