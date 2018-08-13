<h2>Редактирование файла</h2>

<form method="post" action="<{$run.me}>/update-file/">
<input type="hidden" name="file" value="<{$file->pwd}>" />
<table class="cms_form">
      <tbody>
	<tr>
		<td>Имя файла</td>
		<td><input type="text" name="filename" value="<{$file->filename}>"/></td>
	</tr>
      </tbody>
      <tbody>
	<tr>
		<td>Права файла</td>
		<td></td>
	</tr>
      </tbody>
      <tbody>
	<tr>
		<td>Владелец:</td>
		<td>
			Чтение <input type="hidden" name="owner[0]" value="0" />
				   <input type="checkbox" name="owner[0]" value="1" checked="checked" />
			Запись <input type="hidden" name="owner[1]" value="0" />
				   <input type="checkbox" name="owner[1]" value="1" checked="checked"/> 
			Выполнение <input type="hidden" name="owner[2]" value="0" />
					   <input type="checkbox" name="owner[2]" value="1" checked="checked"/>
		</td>
	</tr>
      </tbody>
      <tbody>
	<tr>
		<td>Группа:</td>
		<td>
			Чтение <input type="hidden" name="group[0]" value="0" />
				   <input type="checkbox" name="group[0]" value="1" checked="checked"/>
			Запись <input type="hidden" name="group[1]" value="0" /> 
					<input type="checkbox" name="group[1]" value="1" checked="checked"/> 
			Выполнение  <input type="hidden" name="group[2]" value="0" /> 
						<input type="checkbox" name="group[2]" value="1" checked="checked"/>
		</td>
	</tr>
      </tbody>
      <tbody>
	<tr>
		<td>Дригие:</td>
		<td>
			Чтение  <input type="hidden" name="all[0]" value="0" />
					<input type="checkbox" name="all[0]" value="1" checked="checked"/>
			Запись  <input type="hidden" name="all[1]" value="0" />
					<input type="checkbox" name="all[1]" value="1" checked="checked"/> 
			Выполнение  <input type="hidden" name="all[2]" value="0" />
						<input type="checkbox" name="all[2]" value="1" checked="checked"/>
		</td>
		</tr>
	</tbody>
      <tbody>
	<tr>
		<td></td>
		<td><input class="submit_update" type="submit" value="#SAVE#" />
		</td>
	</tr>
</table>
</form>
