<h1>Просмотр сообщений</h1>
<table class="cms_list">
	<tr>
		<td><b>Вопрос от</b></td>
		<td><b>E-mail</b></td>
		<td><b>Просмотр</b></td>
		<td><b>Функции</b></td>
	</tr>
	<{foreach item=msg from=FeedbackMsg::getQuestions()}>
	<tr>
		<td><{$msg->name}></td>
		<td><{$msg->email}></td>
		<td><{if $msg->view==1}><img alt="views" src="<{$theme.images}>/admin/actions/visible.png" /><{else}><img alt="views" src="<{$theme.images}>/admin/actions/invisible.png" /><{/if}></td>
		<td><a class="delete_link" href="<{$run.me}>/delete-msg/msgid_<{$msg->msgid}>/">#DELETE#</a>
		<a class="edit_link" href="<{$run.me}>/view-msg/msgid_<{$msg->msgid}>/">Просмотр</a></td>
	</tr>
	<{/foreach}>
</table>