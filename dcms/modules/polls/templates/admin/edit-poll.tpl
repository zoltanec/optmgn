<h2>Редактирование опроса ( poll_id: <{$poll->poll_id}> )</h2>

<form method="post" action="<{$run.me}>/update-poll/<{$poll->poll_id}>/">
<table class="cms_form">
	<tr>
		<td>Название анкеты:</td>
		<td><input type="text" name="name" size="50" value="<{$poll->name}>"></td>
	</tr>
	<tr>
		<td>Описание:</td>
		<td><textarea name="descr" rows="10" cols="30" class="cms_rich"><{$poll->descr}></textarea></td>
	</tr>

	<tr>
		<td>Финальное сообщение:</td>
		<td><textarea name="final_message" class="cms_rich" rows="10" cols="30"><{$poll->final_message}></textarea></td>
	</tr>

	<tr>
		<td>Активна:</td>
		<td><input type="checkbox" name="active"<{if $poll->active}> checked<{/if}>></td>
	</tr>
	<tr>
		<td>Категории вопросов:</td>
		<td><a target="_blank" href="<{$run.me}>/view-categories/<{$poll->poll_id}>/">[просмотреть все]</a></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" class="submit submit_update" value="#SAVE#"></td>
	</tr>
</table>
</form>

<a href="<{$run.me}>/add-question/<{$poll->poll_id}>/">Добавить вопрос</a>

<h2>Список вопросов</h2>


<table class="list cms_list">
	<thead>
		<tr>
			<th>N</th>
			<th>Вопрос</th>
			<th>Категория</th>
			<th>Приоритет</th>
			<th>Активен</th>
			<th colspan="2">Функции</th>
		</tr>
	</thead>
	<{foreach item=question from=$poll->questions}>
	<tbody data-type="object" data-id="<{$question->qid}>" data-object-id="<{$question->object_id()}>">
		<tr>
			<td class="num"><{$question->num}></td>
			<td><{$question->question}></td>
			<td><{$poll->getCategoryName($question->catid)|left:"30"}></td>

			<td>
				<a href="<{$run.me}>/update-question-priority/<{$question->qid}>/mode_up/">
					<img src="<{$config->cdn_images}>/admin/up.png" width="20" title="Повысить" border="0">
				</a>

   				<b><{$question->priority}></b>

   				<a href="<{$run.me}>/update-question-priority/<{$question->qid}>/mode_down/">
   					<img src="<{$config->cdn_images}>/admin/down.png" width="20" title="Понизить" border="0">
   				</a>
			</td>

			<td><input type="checkbox" name="active"<{if $question->active==1}> checked<{/if}>></td>



			<td><a class="edit_link" href="<{$run.me}>/edit-question/<{$question->qid}>/">#EDIT#</a></td>
			<td><a class="delete_link" onclick="return confirm('Вопрос будет удален, если на данный вопрос были ответы они так же будут удалены, продолжить?');" href="<{$run.me}>/delete-question/<{$question->qid}>/">#DELETE#</a></td>
		</tr>
	</tbody>
	<{/foreach}>
</table>

<script type="text/javascript">
D.modules.core.bind_activity_switcher( $('.cms_list') );
</script>