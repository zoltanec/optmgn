<{foreach item=msg from=$chat->messages_list}>
	<{if $msg->chatid_A == $chat->chatid}>
		<{include file='my-single-message' msg=$msg}>
	<{else}>
		<{include file='his-single-message' msg=$msg}>
	<{/if}>
<{/foreach}>