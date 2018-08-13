<h2>Формирование задания на перевод</h2>

<style>
TBODY[data-status="0"] .status_1 {
	display: none;
}
</style>


<form action="<{$run.me}>/i18n.confirm-task/" method="post">
	<input type="hidden" name="from" value="<{$req->textID('from')}>">
	<input type="hidden" name="to"   value="<{$req->textID('to')}>">

<table class="cms_list">
	<thead>
		<tr>
			<th></th>
			<th>Код сообщения</th>
			<th>Исходное сообщение</th>
			<th colspan="2"></th>
		</tr>
	</thead>
<{foreach item=msg from=$msgs}>
<tbody data-elem="msg" data-code="<{$msg.code}>" data-status="0">
	<tr>
		<td><input type="checkbox" name="codes[]" value="<{$msg.code}>" checked></td>
		<td><{$msg.code|left:"30"}></td>
		<td><abbr title="<{$msg.text|escape:"htmlall"}>"><{$msg.text|left:80}></abbr></td>
		<td class="status">
			<span class="status_1">отправлено</span>
		</td>
		<td><input data-mode="human" type="submit"></td>
		<td><input data-mode="machine" type="submit"></td>

	</tr>
</tbody>
<{/foreach}>
<tbody>
	<tr>
		<td colspan="2">Всего сообщений сформировано:</td>
		<td><{sizeof($msgs)}></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="preview" value="Предварительный просмотр">
			<input type="submit" name="submit" value="Отправить">

		</td>
	</tr>
</tbody>
</table>
</form>

<script type="text/javascript">
$(function() {
	$('TBODY[data-elem="msg"]').each(function() {
		var block = $(this);
		var code = $(this).attr('data-code');

		$(this).find('INPUT[type="submit"]').click(function() {
			$.post('<{$run.me}>/i18n.execute-task/', {'code' : code, 'from': '<{$req->textID('from')}>', 'to' : '<{$req->textID('to')}>' }, function(answer) {
				if(answer == 'OK') {
					block.attr('data-status', 1);
				}
			});
			return false;
		});
	});
});
</script>