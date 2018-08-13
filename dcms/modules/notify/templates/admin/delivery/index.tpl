<h2>Сообщения рассылки</h2>

<table class="cms_form">

</table>

<table class="cms_list">
	<thead>
		<tr>
			<th>N</th>
			<th>#ADD_TIME#</th>
			<th>#NAME#</th>
			<th colspan="2"></th>
			<th colspan="2">#FUNCTIONS#</th>
		</tr>
	</thead>
<{foreach item=delivery from=Notify_Delivery::find()}>
	<tbody>
		<tr>
			<td><{$delivery->num}></td>
			<td><{$delivery->add_time|convert_time}></td>
			<td><a href="<{$run.me}>/delivery.edit-delivery/<{$delivery->did}>/"><{$delivery->name}></a></td>
			<td><a href="<{$run.me}>/delivery.start/<{$delivery->did}>/">Запустить</a>
			<td><{$delivery->sended}></td>
			<td><{$delivery->total}></td>
			<td class="delete"></td>
		</tr>
	</tbody>
<{/foreach}>
</table>