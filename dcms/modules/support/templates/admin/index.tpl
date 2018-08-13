<h2>Support tickets</h2>

<table class="cms_list" data-list-funcs="delete">
	<thead>
		<tR>
			<th>N</th>
			<th>Author</th>
			<th>Code</th>
			<th>Subject</th>
			<th>Time</th>
			<th></th>
		</tR>
	</thead>
<{foreach item=ticket from=$topics}>
	<tbody data-type="element" data-object-id="<{$ticket->object_id()}>">
		<tr>
			<td class="num"><{$ticket->num}></td>
			<td><{$ticket->author}></td>
			<td><{$ticket->code}></td>
			<td><a href="<{$run.me}>/view-ticket/tid_<{$ticket->tid}>/"><{$ticket->subject}></a></td>
			<td><{$ticket->add_time|convert_time}></td>
			<td class="delete"></td>
		</tr>
	</tbody>
<{/foreach}>
</table>