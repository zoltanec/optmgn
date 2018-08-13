<h2>Просмотр сообщений</h2>
<table class="list">
	<tr>
		<td><b>Сообщение от</b></td>
		<td><b>E-mail</b></td>
		<{if $conf->cause==1}><td><b>Причина обращения</b></td><{/if}>
		<td><b>Дата отправки</b></td>
		<td><b>Просмотр</b></td>
		<td><b>Функции</b></td>
	</tr>
	<{foreach item=msg from=FeedbackMsg::listAll()}>
	<tr>
		<td><{$msg->name}></td>
		<td><{$msg->email}></td>
		<{if $conf->cause==1}><td><{$msg->csname}></td><{/if}>
		<td><{$msg->addtime|date_format:"%d.%m.%Y"}></td>
		<td><{if $msg->view==1}><img alt="views" src="<{$theme.images}>/admin/actions/visible.png" /><{else}><img alt="views" src="<{$theme.images}>/admin/actions/invisible.png" /><{/if}></td>
		<td><a class="delete_link" href="<{$run.me}>/delete-msg/msgid_<{$msg->msgid}>/">#DELETE#</a>
		<a class="edit_link" href="<{$run.me}>/view-msg/msgid_<{$msg->msgid}>/">Просмотр</a></td>
	</tr>
	<{/foreach}>
</table>