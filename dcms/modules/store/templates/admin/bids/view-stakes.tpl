<h2>Ставки сделанные на товар <{$product->name}></h2>

<table class="cms_list">
	<thead>
		<tr>
			<th>No</th>
			<th>Дата</th>
			<th>Телефон</th>
		</tr>
	</thead>
<{foreach item=stake from=$product->bids->stakes}>
	<tbody>
		<tr>
			<td><{$stake->num}></td>
			<td><{$stake->add_time|convert_time}></td>
			<td><{$stake->owner}></td>
		</tr>
	</tbody>
	<{/foreach}>
</table>