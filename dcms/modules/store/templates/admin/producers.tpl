<h2>Управление списком производителей</h2>
<form method="post" action="<{$run.me}>/submit-producer/">
<table class="cms_form">
	<tr>
		<td colspan="2"><b>Добавление нового производителя<b /></td>
	</tr>
	<tr>
		<td>Название производителя</td>
		<td><input type="text" name="producer_name" /></td>
	</tr>
	<tr>
		<td>Страна производителя:</td>
		<td><select name="country_id">
			<{foreach item=country from=Store_Producer::getCountries()}>
			<option value="<{$country.country_id}>"><{$country.name}></option>
			<{/foreach}>
		</select></td>
	</tr>
	<tr>
		<td>Описание:</td>
		<td><textarea cols="50" rows="4" name="descr"></textarea></td>
	</tr>
	<tr>
		<td></td><td><input class="submit_add" type="submit" value="#ADD#" /></td>
	</tr>
</table>
</form>
<table class="cms_list">
	<thead>
	<tr>
		<th><b>ID производителя</b></th>
		<th><b>Название производителя</b></th>
		<th><b>Страна производителя</b></th>
		<th><b>Функции</b></th>
	</tr>
	</thead>
	<{foreach item=producer from=Store_Producer::getAllProducers()}>
	<tbody>
	<tr>
		<td><{$producer->producer_id}></td>
		<td><{$producer->producer_name}></td>
		<td><{$producer->country_name}></td>
		<td>
			<a class="edit_link" href="<{$run.me}>/edit-producer/pid_<{$producer->producer_id}>/">#EDIT#</a>
			<a class="delete_link" href="<{$run.me}>/delete-producer/pid_<{$producer->producer_id}>/">#DELETE#</a>
		</td>
	</tr>
	</tbody>
	<{/foreach}>
</table>