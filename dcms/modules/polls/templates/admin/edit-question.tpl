<h2>Редактирование вопроса</h2>

<form method="post" action="<{$run.me}>/update-question/<{$question->qid}>/">
<table class="cms_form">
	<tr>
		<td>ID вопроса:</td>
		<td><{$question->qid}></td>
	</tr>
	<tr>
		<td>Активен:</td>
		<td><input type="checkbox" name="active" value="1"<{if $question->active}> checked<{/if}>></td>
	</tr>

	<tr>
		<td>Вопрос:</td>
		<td><textarea rows="6" cols="30" name="question"><{$question->question}></textarea></td>
	</tr>

	<tr>
		<td>Помощь ( подсказка ):</td>
		<td><textarea name="help" rows="2" cols="30"><{$question->help}></textarea></td>
	</tr>

	<tr>
		<td>Ответы:</td>
		<td><textarea name="answers" rows="12" cols="30"><{$question->answers}></textarea></td>
	</tr>

	<tr>
		<td>Категория:</td>
		<td><select name="catid">
				<option value="0">не указана
				<{foreach item=cat from=$question->poll->categories}>
					<option value="<{$cat->catid}>"<{if $question->catid == $cat->catid}> selected<{/if}>><{$cat->name}>
				<{/foreach}>
			</select>
		</td>
	</tr>
	<tr>
		<td>Режим:</td>
		<td><select name="mode">
			<{foreach item=mode key=mode_num from=Polls_Question::getQuestionModes()}>
				<option value="<{$mode_num}>"<{if $question->mode == $mode_num}> selected<{/if}>><{_ code=$mode}>
			<{/foreach}>
			</select>
		</td>

	<tr>
		<td></td>
		<td><input type="submit" value="#SAVE#" class="submit submit_update"></td>
	</tr>
</table>
</form>