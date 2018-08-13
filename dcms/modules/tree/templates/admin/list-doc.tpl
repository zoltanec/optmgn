<script type="text/javascript" src="<{$me.www}>/jscripts/tiny_mce/tiny_mce_config.js"></script>
<b>Редактирование документа &laquo;<{$doc->did}>&raquo;</b>
<form method="post" action="<{$run.me}>/update-doc/">
<input type="hidden" name="did" value="<{$doc->did}>" />
<table class="form">
	<tr>
		<td>Название:</td>
		<td><input type="text" name="dname" size="82" value="<{$doc->dname}>" /></td>
	</tr>
	<tr>
		<td>Приоритет показа:
		</td>
		<td>
			<a href="" onClick="var num=$('#priority').val(); $('#priority').attr('value',++num); $(this).next('b').html(num++); return false;">
				<img src="<{$config->cdn_images}>/admin/up.png">
			</a>
    		<b><{$doc->priority}></b>
   			<a href="" onClick="var num=$('#priority').val(); $('#priority').attr('value',--num); $(this).prev('b').html(num--); return false;">
   				<img src="<{$config->cdn_images}>/admin/down.png">
   			</a>
   			<input id="priority" type="hidden" name="priority" value="<{$doc->priority}>"/>
		</td>
	</tr>
	<tr>
		<td>Содержимое:</td>
		<td><textarea id="rich" rows="25" cols="80" name="dcontent"><{$doc->dcontent}></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" class="submit_update" value="#SAVE#"></td>
	</tr>
</table>
</form>