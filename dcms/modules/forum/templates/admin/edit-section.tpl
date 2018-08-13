<h2>Настройки раздела</h2>
<table class="form">
	<form method="post" action="<{$t.run.me}>/update-section/sid_<{$t.section->sid}>">
	<tbody id="sid<{$t.section->sid}>">
		<{if $t.section->sid != 1}>
		<tr>
			<td colspan="3">К родительскому разделу: <a href="<{$run.me}>/edit-section/sid_<{$t.section->parent_section->sid}>/">перейти</a></td>
		</tr>
		<{/if}>
		<tr>
			<td>Раздел ( ID <b><{$section->sid}></b> )</td>
			<td colspan="2"><input name="name" value="<{$t.section->name}>"></td>
		</tr>
		<tr>
			<td>Код раздела:</td>
			<td><input type="text" name="code" value="<{$section->code}>"></td>
		</tr>

		<tr>
			<td>Категория:</td>
			<td><select name="cid">
				<option value="0">Основной
				<{foreach item=category from=$t.section->parent_section->categories}>
					<option value="<{$category.cid}>"<{if $category.cid==$t.section->cid}> selected<{/if}>><{$category.name}>
				<{/foreach}>
			</select>
			</td>
		</tr>
		<tr>
			<td>Режимы:</td>
			<td><input type="checkbox"<{if $t.section->active}> checked<{/if}> name="active" value="1">Активен &nbsp;<input type="checkbox"<{if $t.section->readonly}> checked<{/if}> name="readonly" value="1">Только для чтения</td>
		<tr>
			<td>Описание:</td>
			<td><textarea rows="4" cols="50" name="descr"><{$t.section->descr}></textarea></td>
		</tr>
		<tr>
		    <td></td>
			<td colspan="2"><input class="submit submit_update" type="submit" value="#SAVE#"></td>
		</tr>
		<tr>
			<td>Перестройка статистики раздела:</td>
			<td><a href="<{$run.me}>/run-stat-rebuild/sid_<{$section->sid}>">[запустить]</a></td>
		</tr>
	</tbody>
	</form>
</table>

<h2>Модераторы</h2>

<table class="list">
 <tr>
  <td colspan="3"> Имя пользователя:
    <form method="post" action="<{$run.me}>/add-moderator/sid_<{$t.section->sid}>/">
    <input type="text" name="username"> <input type="submit" value="#ADD#" class="submit submit_add">
    </form>
    </td>
 </tr>
 <{foreach item=moderator from=$t.section->moderators}>
 <tr>
  <td><{$moderator.num}></td>
  <td><a class="user_link" href="<{$run.admin}>/users/edit-user/uid_<{$moderator.uid}>/"><{$moderator.username}></a></td>
  <td><a class="delete_link" href="<{$run.me}>/delete-moderator/sid_<{$t.section->sid}>/uid_<{$moderator.uid}>/">Удалить</a></td>
 </tr>
 <{/foreach}>
</table>

<h2>Управление категориями в разделе</h2>
<table class="list">
	<tbody>
	<form method="post" action="<{$run.me}>/add-category/sid_<{$t.section->sid}>/">
	<tr>
		<td colspan="4">Добавить категорию: <input type="text" name="name" value="Новая категория">
			<input type="submit" class="submit submit_add" value="#ADD#">
		</td>
	</tr>
	</form>
	</tbody>
	<{foreach item=category from=$t.section->categories}>
		<tbody>
		<form method="post" action="<{$run.me}>/update-category/sid_<{$t.section->sid}>/cid_<{$category.cid}>/">
		<tr>
			<td><b><{$category.num}></b></td>
			<td><input type="text" name="name" value="<{$category.name}>"></td>
			<td><input type="submit" class="submit submit_update" name="update" value="#SAVE#">
			    <button class="submit_delete">#DELETE#</button></td>
		</tr>
		</form>
		</tbody>
	<{/foreach}>
</table>
<h2>Управление подразделами</h2>
	<form method="post" action="<{$run.me}>/add-section/sid_<{$t.section->sid}>/">
Добавление раздела: <input type="text" size="40" name="name" value="Новый раздел"><input type="submit" class="submit submit_add" value="#ADD#"></form>
<table class="list">
    <thead>
     <tr>
      <th>N</th>
      <th>SID</th>
      <th>Название раздела</th>
      <th>Категория</th>
      <th></th>
      <th>Функции</th>
     </tr>
    </thead>
	<{foreach item=section from=$t.section->subsections_all}>
		<tr>
			<td><b><{$section->num}>.</b></td>
			<td><{$section->sid}></td>
			<td><{$section->name}></td>
			<td><{$t.section->categories[$section->cid]['name']}></td>
			<td><{if !$section->active}><img src="<{$theme.mimages}>/actions/invisible.png"><{/if}></td>
			<td><a class="edit_link" href="<{$run.me}>/edit-section/sid_<{$section->sid}>/">#EDIT#</a>
			    <a class="delete_link" href="<{$run.me}>/delete-section/sid_<{$section->sid}>/">#DELETE#</a>
			</td>
		</tr>
	<{/foreach}>
</table>