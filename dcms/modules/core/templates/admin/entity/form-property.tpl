<{if $property->prop_form_type==2 || $property->prop_form_type==3}>
	<textarea rows="4" cols="50" name="<{$property->prop_code}>"><{$prod-><{$property->prop_code}>}></textarea>
<{else if $property->prop_form_type==5 || $property->prop_form_type==6}>
	<select name="<{$property->prop_code}>">
		<option>qweq</option>
	</select>
<{else if $property->prop_form_type==7}>
	<input type="radio" name="<{$property->prop_code}>" />
<{else if $property->prop_form_type==8}>
	<{assign var=child_object value=$block->getChildObject($object)}>
	<{if D::getContext()=="admin"}>
		<table>
			<{foreach item=list from=unserialize($child_object-><{$property->prop_code}>)}>
				<tr id="<{$property->prop_code}>_list">
					<td>Название: <input type="text" name="<{$property->prop_code}>_list[]" value="<{$list.list}>"> <{$property->prop_unit}></td><td>Значение: <input type="text" name="<{$property->prop_code}>_value[]" value="<{$list.value}>"></td>
				</tr>
			<{/foreach}>
			<tr>
				<td colspan="2"><input id="<{$property->prop_code}>_add_list" type="button" value="Еще" /></td>
			</tr>
		</table>
		<script type="text/javascript">
			$("input#<{$property->prop_code}>_add_list").click(function(){
				$("#<{$property->prop_code}>_list").after($("#<{$property->prop_code}>_list").clone());
			});
		</script>
	<{else}>
		<{foreach item=list from=unserialize($child_object-><{$property->prop_code}>)}>
			<input <{if $property->dependency}>class="change_<{$property->dependency}>"<{/if}> type="radio" name="<{$property->prop_code}><{$object->prod_id}>" value="<{$list.value}>" /><label><{$list.list}><{$property->prop_unit}> - <{$list.value}>руб</label></br>
		<{/foreach}>
		<{if $property->dependency}>
			<script type="text/javascript">
				$("input[name=<{$property->prop_code}><{$object->prod_id}>]").click(function(){
					var price=0;
					$(this).parents("form").find("input.change_<{$property->dependency}>:checked").each(function(){
						curr_price=parseInt($(this).val());
						if(curr_price)
							price+=curr_price;
					});
					$(this).parents("form").find("#<{$property->dependency}>").html(price);
				});
			</script>
		<{/if}>
	<{/if}>
<{else}>
	<input type="text" name="<{$property->prop_code}>" value="<{$prod-><{$property->prop_code}>}>" />
<{/if}>