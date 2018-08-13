<script type="text/javascript" src="<{$config.jscripts_path}>/tiny_mce_v3.4.2/tiny_mce_config.js"></script>
<b>Редактирование документа &laquo;<{$faq->qid}>&raquo;</b>
<form method="post" action="<{$run.me}>/update-doc/">
<input type="hidden" name="qid" value="<{$faq->qid}>" />
<table class="cms_form">
	<tr>
		<td>Название:</td>
		<td><input type="text" name="qname" size="82" value="<{$faq->qname}>" /></td>
	</tr>
	<tr>
		<td>Содержимое:</td>
		<td><textarea id="rich" rows="25" cols="94" name="qcontent"><{$faq->qcontent}></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" class="submit_update" value="#SAVE#"></td>
	</tr>
</table>
</form>