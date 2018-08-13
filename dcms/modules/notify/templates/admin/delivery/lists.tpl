<h2>Списки подписчиков</h2>

<table class="cms_list" data-list-funcs="delete">
	<theaD>
		<tr>
			<th>N</th>
			<th>#ADD_TIME#</th>
			<th>#NAME#</th>
			<th>Кол-во</th>
			<th></th>
		</tr>
	</theaD>
<{foreach item=list from=Notify_Delivery_Lists::find()}>
	<tbody data-type="elem" data-object="<{$list->object_id()}>">
		<tr>
			<td><{$list->num}></td>
			<td><{$list->add_time|convert_time}></td>
			<td><{$list->name}></td>
			<td><{$list->count}></td>
			<td class="delete"></td>
		</tr>
	</tbody>
<{/foreach}>
</table>