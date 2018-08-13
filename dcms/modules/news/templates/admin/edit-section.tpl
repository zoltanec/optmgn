<h2>Редактирование раздела <{$section->section_name}></h2>

<form method="post" action="<{$run.me}>/update-section/">
<input type="hidden" name="sid" value="<{$section->sid}>">
<table class="form">
	<tr>
		<td>Название раздела</td>
		<td><input type="text" name="section_name" value="<{$section->section_name}>"></td>
	</tr>
	<tr>
		<td>Ключ раздела:</td>
		<td><input type="text" name="section_key" value="<{$section->section_key}>"></td>
	</tr>
	<tr>
		<td>Описание раздела:</td>
		<td><textarea name="descr"><{$section->descr}></textarea>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" class="submit_update" value="#SAVE#"></td>
	</tr>
</table>
</form>