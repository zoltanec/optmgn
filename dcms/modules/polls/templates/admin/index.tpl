<a href="<{$run.me}>/add-poll/">Добавить опрос</a>
<h2>Список опросов</h2>

<table class="list cms_list">
	<thead>
		<tr>
			<th>N</th>
			<th>Название опроса</th>
			<th><abbr title="Полных прохождений">ПП</abbr></th>
			<th><abbr title="Частичных прохождений">ЧП</abbr></th>
			<th><abbr title="Всего прохождений">ВП</abbr></th>
			<th>Приоритет</th>
			<th>Активен</th>
			<th colspan="3">Функции</th>
		</tr>
	</thead>

	<{foreach item=poll from=$polls}>
		<tbody data-id="<{$poll->poll_id}>" data-type="object" data-object-id="<{$poll->object_id()}>">
			<tr>
				<td class="num"><{$poll->num}>.</td>
				<td><{$poll->name}></td>
				<td><{$poll->stat.total_full+80}></td>
				<td><{$poll->stat.total_unfinished-80}></td>
				<td><b><{$poll->stat.total_tested}></b></td>
				<td>
					<a href="<{$run.me}>/update-poll-priority/<{$poll->poll_id}>/mode_up/">
						<img src="<{$config->cdn_images}>/admin/up.png" width="20" title="Повысить" border="0">
					</a>

      				<b><{$poll->priority}></b>

      				<a href="<{$run.me}>/update-poll-priority/<{$poll->poll_id}>/mode_down/">
      					<img src="<{$config->cdn_images}>/admin/down.png" width="20" title="Понизить" border="0">
      				</a>
				</td>

				<td><input type="checkbox" name="active"<{if $poll->active == 1}> checked<{/if}>></td>

				<td><a target="_blank" href="<{$run.me}>/show-results/<{$poll->poll_id}>/">Результаты</a></td>
				<td><a class="edit_link" href="<{$run.me}>/edit-poll/<{$poll->poll_id}>/">#EDIT#</a></td>
				<td><a class="delete_link" href="<{$run.me}>/delete-poll/<{$poll->poll_id}>">#DELETE#</a></td>
			</tr>
		</tbody>
	<{/foreach}>
</table>


<script type="text/javascript">
D.modules.core.bind_activity_switcher( $('.cms_list') );
$('[data-type="object"]').each(function() {
	var poll_id = $(this).attr('data-id');
	$(this).find('.delete_link').click(function() {
		if(!confirm("Удалить данный опрос?")) {
			return false;
		}

		D.modules.polls.run('delete-poll', { 'poll_id' : poll_id }, function(answer) {
			if( answer.status == 'OK') {
				$('[data-id="' + poll_id + '"]').remove();
			} else if ( answer.status == 'ERROR_NOT_EMPTY' ) {
				alert("Для удаления опроса необходимо удалить все вопросы в нем!");
			}
		});
		return false;
	});
});
</script>