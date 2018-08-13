<h2>Результаты опроса &laquo;<{$poll->name}>&raquo;</h2>
<{capture name="resultpage"}>
<{$run.me}>/show-results/<{$poll->poll_id}>/!PAGE!/<{$filter.search_id}>/
<{/capture}>


<form method="post" action="<{$run.me}>/show-results/<{$poll->poll_id}>/1/">
<table class="cms_admin_filter">
	<tr>
		<td>Регион:</td>
		<td><input type="text" name="city" value="<{$filter.city}>"></td>
		<td>Возраст: </td>
		<td>от <input type="text" size="3" name="age_from" value="<{$filter.age_from}>"></td>
		<td>до <input type="text" size="3" name="age_to" value="<{$filter.age_to}>"></td>
		<td>Завершенность:</td>
		<td><select name="completed">
				<option value="nomatter">не важно
				<option value="full"<{if $filter.completed == 'full'}> selected<{/if}>>полностью
				<option value="partial"<{if $filter.completed == 'partial'}> selected<{/if}>>частично
			</select>
		</td>
		<td>Пол:</td>
		<td><select name="sex">
				<option value="none">не важно
				<option value="m"<{if $filter.sex == 'm'}> selected<{/if}>>Мужчина
				<option value="w"<{if $filter.sex == 'w'}> selected<{/if}>>Женщина
			</select>
		</td>
		<td><input type="submit" value="Фильтровать"></td>
	</tr>
</table>
</form>

<{assign var=questions_count value=sizeof($poll->active_questions)}>

<div><{pager total=$results_list->totalpages url=$smarty.capture.resultpage pager='fast' current=$results_list->page nohide=1}></div>

<a href="<{$run.me}>/export-results/<{$poll->poll_id}>/<{$filter.search_id}>/">Скачать выгрузку</a>
<a href="<{$run.me}>/export-xml/<{$poll->poll_id}>/<{$filter.search_id}>/">Скачать XML-выгрузку</a>
<a href="<{$run.me}>/export-poll/<{$poll->poll_id}>/">Скачать коды вопросов</a>

<table class="list">
<thead>
	<tr>
		<th>N</th>
		<th>Дата</th>
		<th>Имя</th>
		<th>Пол</th>
		<th>Город</th>
		<th>ДР</th>
		<th>Пройдено</th>
	</tr>
</thead>
<{foreach item=result from=$results_list}>
	<tr>
		<td><{$result->num}>.</td>
		<td><{$result->last_time|convert_time}></td>
		<td><a target="_blank" href="http://vkontakte.ru/id<{$result->username}>"><{$result->about}></a></td>
		<td><{if $result->sex=='M'}>М<{elseif $result->sex=='W'}>Ж<{else}>&mdash;<{/if}></td>
		<td><{$result->user_from}></td>
		<td><{$result->birth}></td>
		<td><{$result->answers}> <b>(<{100*$result->answers/$questions_count|string_format:"%.2f"}>%)</b></td>
	</tr>
<{/foreach}>
</table>

<div><{pager total=$results_list->totalpages url=$smarty.capture.resultpage pager='fast' current=$results_list->page nohide=1}></div>