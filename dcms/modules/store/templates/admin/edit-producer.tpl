<h2>Правка производителя</h2>
<form method="post" action="<{$run.me}>/update-producer/">
<input type="hidden" name="pid" value="<{$producer->producer_id}>" />
<table class="cms_form">
	<tr>
		<td>Название производителя</td>
		<td><input type="text" name="producer_name" value="<{$producer->producer_name}>" /></td>
	</tr>
	<tr>
		<td>Страна производителя:</td>
		<td><select name="country_id">
			<{foreach item=country from=Store_Producer::getCountries()}>
			<option value="<{$country.country_id}>" <{if $producer->country_id==$country.country_id}>selected="selected"<{/if}>><{$country.name}></option>
			<{/foreach}>
		</select></td>
	</tr>
	<tr>
		<td>Описание:</td>
		<td><textarea cols="50" rows="4" name="descr"><{$producer->descr}></textarea></td>
	</tr>
	<tr>
		<td></td><td><input class="submit_update" type="submit" value="#SAVE#" /></td>
	</tr>
</table>
</form>