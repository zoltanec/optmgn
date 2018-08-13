<table border="0" class="polls_list_all">
	<thead>
		<tr>
			<th>№</th>
			<th>Название</th>
			<th>Вы заполнили</th>
            <th></th>
			<th class="polls_th_action">Действия&nbsp;</th>
		</tr>
	</thead>
<{foreach item=poll from=$polls}>
	<tbody class="polls_single_poll" data-poll-id="<{$poll->poll_id}>">
		<tr class="polls_first_line">
			<td class="polls_num"><{$poll->num}></td>
			<td class="polls_poll_name">
			<{if $poll->progress == 100}>
			<a onclick="return confirm('Вы уже ответили на все вопросы этой анкеты, желаете пройти ее заново?');" href="<{$me.path}>/show-poll/<{$poll->poll_id}>/restart/"><{$poll->name}></a>
			<{else}>
			<a href="<{$me.path}>/show-poll/<{$poll->poll_id}>/"><{$poll->name}></a>
			<{/if}>
            <br /><span><{$poll->descr}></span>
			</td>
			<td class="polls_progress">
				<div class="polls_progress_bar" style="background-position: -<{100-$poll->progress}>px;">
					<{$poll->progress}>%
				</div>
			</td>
			<td>
				<{if $poll->progress == 100}>
					<img src="<{$theme.images}>/completed.icon.png">
				<{/if}>
			</td>
			<td class="polls_control">
				<{if $poll->progress == 100}>
					<a onclick="return confirm('Вы уже ответили на все вопросы этой анкеты, желаете пройти ее заново?');" href="<{$me.path}>/show-poll/<{$poll->poll_id}>/restart/" class="polls_run_again">Пройти заново</a>
				<{else}>
					<a href="<{$me.path}>/show-poll/<{$poll->poll_id}>/" class="polls_run_again">Пройти</a>
				<{/if}>
<br />
				<{if $poll->progress > 0}>
					<a href="<{$me.path}>/reject-poll/<{$poll->poll_id}>/" onclick="return confirm('Ваши ответы будут отменены, продолжить?');" class="polls_reject_results">Отменить</a>
				<{/if}>

				</td>
		</tr>

		<tr>
			<td class="polls_sep" colspan="5"></td>
		</tr>
	</tbody>
<{/foreach}>
</table>


<script type="text/javascript">
</script>