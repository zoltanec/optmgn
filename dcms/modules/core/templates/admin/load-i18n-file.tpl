<h1>Список загруженных сообщений:</h1>

<div>
<{foreach item=messages key=name from=$files}>
	<h2><{$name}></h2>
	<table class="cms_list">
		<{foreach item=msg from=$messages}>
		<tr>
			<td><{$msg}></td>
		</tr>
		<{/foreach}>
	</table>
<{/foreach}>
</div>