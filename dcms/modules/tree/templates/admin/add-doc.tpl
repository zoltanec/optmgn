<script type="text/javascript" src="<{$me.www}>/jscripts/tiny_mce/tiny_mce_config.js"></script>
<form method="post" action="<{$run.me}>/submit-doc/">
<table class="form">
	<tr>
		<td colspan="2"><b>Добавление нового документа<b/></td>
	</tr>
	<tr>
		<td>Название документа<input type="hidden" name="pid" value="<{$pid}>" /></td>
		<td><input type="text" name="dname" size="82" /></td>
	</tr>
	<tr>
		<td>Приоритет показа:
		</td>
		<td>
			<a href="" onClick="var num=$('#priority').val(); $('#priority').attr('value',++num); $(this).next('b').html(num++); return false;">
				<img src="<{$config->cdn_images}>/admin/up.png">
			</a>
    		<b>0</b>
   			<a href="" onClick="var num=$('#priority').val(); $('#priority').attr('value',--num); $(this).prev('b').html(num--); return false;">
   				<img src="<{$config->cdn_images}>/admin/down.png">
   			</a>
   			<input id="priority" type="hidden" name="priority" value="0"/>
   		</td>
	</tr>
	<tr>
		<td>Содержимое документа</td>
		<td><textarea id="rich" rows="25" cols="80" name="dcontent"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input class="submit_add" type="submit" value="#ADD#" /></td>
	</tr>
</table>
</form>