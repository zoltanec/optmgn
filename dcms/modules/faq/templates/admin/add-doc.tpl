<script type="text/javascript" src="<{$config.jscripts_path}>/tiny_mce_v3.4.2/tiny_mce_config.js"></script>
<form method="post" action="<{$run.me}>/submit-doc/">
<table class="cms_form">
	<tr>
		<td colspan="2"><b>Добавление нового документа<b/></td>
	</tr>
	<tr>
		<td>Название документа<input type="hidden" name="pid" size="82" value="<{$pid}>" /></td>
		<td><input type="text" name="qname" /></td>
	</tr>
	<tr>
		<td>Содержимое документа</td>
		<td><textarea id="rich" rows="25" cols="94" name="qcontent"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input class="submit_add" type="submit" value="#ADD#" /></td>
	</tr>
</table>
</form>