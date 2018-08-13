<H1>Редактирование продукта &laquo;<{$prod->prod_name}>&raquo;</H1>
<h2>Управление товаром</h2>
<form method="post" action="<{$run.me}>/update-product/pid_<{$prod->prod_id}>">
<table class="cms_form" data-object-id="<{$prod->object_id()}>" data-form-id="update-product-properties">
	<{formline type='header'}>
	<{formline title='Название продукта' multi='1' name='prod_name' value=$prod->prod_name}>
	<{formline title='Заголовок страницы' name='title' value=$prod->title}>
    <{if $config['store.bestseller']}>
        <{formline title='Бест-селлер' name='bestseller' type='bool' value=$prod->bestseller}>
    <{/if}>
	<{formline title='Цена' name='price' value=$prod->price}>
    <{if $config['store.weight']}>
        <{formline title='Вес' name='weight' value=$prod->weight}>
    <{/if}>
    <{if $config['store.export']}>
        <{formline title='Код экспорта' name='export_code' value=$prod->export_code}>
    <{/if}>
    <{if $config['store.psc']}>
        <{formline title='Количество в порции' name='psc' value=$prod->psc}>
    <{/if}>
	<tbody data-line-show-mode="1">
		<tr>
			<td></td>
			<td>Категория:</td>
			<td>
				<select name="category_id">
				<{foreach item=category from=Store_Category::getAllCategories()}>
					<option value="<{$category->category_id}>"
						<{if $category->category_id==$prod->category_id}>
							selected="selected"
						<{/if}>>
						<{$category->category_name}></option>
				<{/foreach}>
			</select></td>
		</tr>
	</tbody>
    <{if $config['store.mix']}>
        <{formline title='Состав' name='mix' type='textarea' value=$prod->mix}>
    <{/if}>
	<{formline title='Описание' object_id=$prod->object_id() name='descr' multi='1' type='textarea' value=$prod->descr}>
    <{if $config['store.reciple']}>
        <{formline title='Способ приготовления' type='textarea' name='reciple' value=$prod->reciple}>
    <{/if}>
	<{formline type='save'}>
</table>
</form>


<{if $config['store.auction']}>
<h2>Аукцион</h2>
<form method="post" action="<{$run.me}>/bids.update-bid-settings/">
<input type="hidden" name="prod_id" value="<{$prod->prod_id}>">
<table class="cms_form">
	<{formline type='header'}>
	<{formblock name='str_time' title='Время начала'}>
		<{date_input time='1' minyear='2000' maxyear='2020' name='str_time' date=$prod->bids->str_time format='%s'}></td>
	<{/formblock}>
	<{formblock name='cls_time' title='Время окончания'}>
		<{date_input time='1' minyear='this' maxyear='2020' name='cls_time' date=$prod->bids->cls_time format='%s'}></td>
	<{/formblock}>

	<{formline name='start_price' title='Начальная цена' value=$prod->bids->start_price}>
	<{formline name='step' title='Шаг ставки' value=$prod->bids->step}>
	<{formblock name='stakes' title='Лог ставок'}>
		<a href="<{$run.me}>/bids.view-stakes/pid_<{$prod->prod_id}>">показать</a>
	<{/formblock}>
	<{formline type='save'}>
</table>
</form>
<{/if}>


<h2>Свойства</h2>

<table class="cms_list">
	<thead>
		<tr>
			<th>Код</th>
			<th>Значение</th>
		</tr>
	</thead>


	<{foreach item=field from=$prod->parent->fields}>
		<tbody>
			<tr>
				<td><{D_Core_I18n::translate($field->code)}></td>
				<td>
					<form method="post" action="<{$run.me}>/update-product-field/">
						<input type="hidden" name="prod_id" value="<{$prod->prod_id}>">
						<input type="hidden" name="code" value="<{$field->code}>">
                        <input type="hidden" name="type" value="<{$field->ptype}>">

						<{if $field->ptype == 'text'}>
							<input type="text" name="content" value="<{$prod->fields[$field->code]->content}>" />
						<{elseif $field->ptype == 'check'}>
							<input type="checkbox" name="content" value="1" <{if $prod->fields[$field->code]->content}>checked="checked"<{/if}>/>
                        <{elseif $field->ptype == 'list'}>
                            <{assign var=fieldsValues value=unserialize($prod->fields[$field->code]->content)}>
                            <{foreach from=","|explode:$field->data item=input}>                            
                                <input type="checkbox" name="check[]" value="<{$input}>" <{if $fieldsValues.$input.checked}>checked="checked"<{/if}> /> <{$input}> 
                                Наличие
                                <input type="text" name="content[<{$input}>]" value="<{if $fieldsValues.$input.value}><{$fieldsValues.$input.value}><{else}>0<{/if}>" /> <br />
                            <{/foreach}>
                        <{elseif $field->ptype == 'select'}>
                            <select name="content">
                                <option value="">Не выбрано
                            <{foreach from=","|explode:$field->data item=input}>
                                <option value="<{$input}>" <{if $input==$prod->fields[$field->code]->content}>selected<{/if}>><{$input}>
                            <{/foreach}>
                            </select>
						<{elseif $field->ptype == 'multi'}>
                            <select name="content">
                                <option value="">Не выбрано
                            <{foreach from=unserialize($field->data) item=options key=optgroup}>
                                <optgroup label="<{$optgroup}>">
                                <{foreach from=$options item=input}>
                                    <option value="<{$input}>" <{if $input==$prod->fields[$field->code]->content}>selected<{/if}>><{$input}>
                                <{/foreach}>
                            <{/foreach}>
                            </select>
                        <{else}>
							<textarea rows="4" cols="40" name="content"><{$prod->fields[$field->code]->content}></textarea>
						<{/if}>

						<input type="submit" value="Сохранить">
					</form>
				</td>

			</tr>
		</tbody>
	<{/foreach}>
</table>

<{include object_id="product`$prod->prod_id`" file="media;admin/all-files"}>