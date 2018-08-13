<h2>Виды списков</h2>

<table class="cms_list">
<{foreach item=list key=num from=Store_Lists::distinct('name')}>
	<tbody>
		<tr>
			<td><{$num}></td>
			<td><a href="<{$run.me}>/edit-list/name_<{$list}>/"><{$list}></a></td>
			<td></td>
	</tbody>
<{/foreach}>
</table>