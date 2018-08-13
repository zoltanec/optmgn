<form method="post" action="<{$run.me}>/add-to-list/">
	<input type="hidden" name="name" value="<{$name}>">
	<table class="cms_form">
		<{formline title='Идентификатор товара' name='prod_id'}>
		<{formline type='save'}>
	</table>
</form>

<table class="cms_list" data-list-funcs="delete fields">
	<{foreach item=item from=$list}>
		<tbody data-type="element" data-object-id="<{$item->object_id()}>">
			<tr>
				<tD><{$item->num}></tD>
				<td><{$item->product->name}></td>
				<td data-field="priority" class="priority">
    				<a class="up" title="Повысить" data-field-func="inc"></a>
					<b data-field-func="value"><{$item->priority}></b>
					<a class="down" title="Понизить" data-field-func="dec"></a>
   				</td>
				<td class="delete"></td>
			</tr>
		</tbody>
	<{/foreach}>
</table>