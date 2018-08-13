<h2>Отправленные сообщения</h2>

<{foreach item=msg from=$messages}>
	<{$msg->address}> => <{$msg->msg}><br>
<{/foreach}>

<script type="text/javascript">
setTimeout(function() {
	document.location.reload();
}, 4000);
</script>