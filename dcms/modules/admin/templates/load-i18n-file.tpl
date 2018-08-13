<h1>Список загруженных сообщений:</h1>

<div>
<{foreach item=message from=$messages}>
 <{$message.msg_code}> - <{$message.lang}><br>
<{/foreach}>
</div>