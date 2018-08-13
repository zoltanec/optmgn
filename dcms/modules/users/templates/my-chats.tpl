<{include file='users;user-toolbar'}>
<h2>Мои чаты</h2>

 <table id="users_private_chats" class="users_private_chats">
 	<{if sizeof($chat_list) > 0}>
 	<{foreach item=chat from=$chat_list}>
      <tr uid="<{$chat->recipient}>" class="users_single_private_chat priv_tr">
        <td class="private_messages_checkbox"><input name="private_messages" type="checkbox" value="" /></td>

        <td class="private_messages_avatar">
         <a href="<{$me.path}>/chat/uid_<{$chat->recipient}>/">
        	   <{if !empty($chat->avatar)}>
        		    <img src="<{$me.content}>/users/avatars/<{$chat->avatar}>">
        		<{else}>
            		<img src="<{$me.content}>/users/avatars/default.png">
        		<{/if}>
        </a></td>
        <td class="users_private_chat_title private_messages_name_title"><div class="priv_name"><{$chat->username}>&nbsp;<span><{$chat->upd_time|convert_time}></span></div>
                                                <div class="priv_title"><{$chat->last_message}></div></td>
        <td class="private_messages_count"><{$chat->messages}></td>
        <td class="users_pm_unreaded">
        	<{if $chat->unread > 0}>
        		+<{$chat->unread}>
        	<{/if}>
        </td>
      </tr>
	<{/foreach}>
	<{else}>
	<tr class="users_pm_no_chats">
	 <td>У вас нет ни одного активного чата</td>
	</tr>
	<{/if}>
</table>

<script type="text/javascript">
$(document).ready(function() {
	D.modules.users.rebind_chats();
});
</script>