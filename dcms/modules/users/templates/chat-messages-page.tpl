<div class="users_pm_pager">
	<{pager total=$messages->totalpages call='getChatPage' current=$messages->page mode='reverse'}>
</div>

<div id="chat_messages">
<{foreach item=msg from=$messages}>
	<{if $msg->chatid_A == $chat->chatid}>
		<{include file='my-single-message' msg=$msg}>
	<{else}>
		<{include file='his-single-message' msg=$msg}>
	<{/if}>
<{/foreach}>
</div>

<div class="users_pm_pager">
	<{pager total=$messages->totalpages call='getChatPage' current=$messages->page mode='reverse'}>
</div>
