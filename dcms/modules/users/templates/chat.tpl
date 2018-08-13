<{if !$req->isAjax()}>
	<{include file='users;user-toolbar'}>
<script type="text/javascript">
function showHideBBText(elemid) {
	var blockId = '#cm_hidden_text' + elemid;
	if($(blockId).is(':visible')) {
		$(blockId).hide();
	} else {
		$(blockId).show();
	}
	return false;
}
</script>
<{/if}>

<script type="text/javascript">
$(document).ready(function() {
	D.modules.users.bind_messages_sender();
});
</script>

<h2>Личные сообщения</h2>

<table class="users_chat_info_block">
 <tr>
  <td rowspan="3" class="users_chat_info_avatar">
   <{if !empty($recipient->avatar)}>
   <img src="<{$me.content}>/users/avatars/<{$recipient->avatar}>">
   <{else}>
   <img src="<{$me.content}>/users/avatars/default.png">
   <{/if}>
  </td>
  <td class="users_chat_username"><{$recipient->username}></td>
 </tr>
 <tr class="users_chat_total_regtime">
  <td>Зарегистрирован: <span><{$recipient->regtime|convert_time}></span></td>
 </tr>
 <tr class="users_chat_total_messages">
  <td>Всего сообщений: <span><{$chat->messages}></span></td>
 </tr>
</table>


<form method="post" id="pm_submit" action="<{$me.path}>/send-message/">
<input type="hidden" name="uid" id="recipient_uid" value="<{$recipient->uid}>">
<table class="users_pm_send_form">
 <tr>
  <td><{include file='core;text-editor'}></td>
 </tr>
 <tr class="users_pm_send_keycode">
 	<td>Для отправки сообщения используйте Ctrl + Enter</td>
 </tr>
 <tr class="users_pm_send_submit">
  <td><button class="submit_button" type="submit"><span>#SEND#</span></button></td>
 </tr>
</table>
</form>

<script type="text/javascript">
function getChatPage(page) {
	usersJS.getChatMessagesPage(page,<{$recipient->uid}>);
	return false;
}
</script>

<h2 class="fullhead users_pm_messages_header">Сообщения</h2>

<div id="chat_messages_container">
	<{include file='users;chat-messages-page'}>
</div>
