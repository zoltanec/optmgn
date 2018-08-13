<{foreach item=property from=Store_BlockProperties::getProperties($category_id)}>
	<tr>
		<td><{$property->prop_name}></td>
		<td><{if $property->prop_type==3}><textarea rows="4" cols="50" name="<{$property->prop_code}>"><{$prod-><{$property->prop_code}>}></textarea><{else}><input type="text" name="<{$property->prop_code}>" value="<{$prod-><{$property->prop_code}>}>" /><{/if}> <{$property->prop_unit}></td>
	</tr>
<{/foreach}>