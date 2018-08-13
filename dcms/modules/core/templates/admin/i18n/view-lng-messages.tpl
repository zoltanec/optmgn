<style>
TEXTAREA[name="msg_text"] {
	width: 98%;
}
</style>

<div class="cms_admin_pager">
<{pager pager='fast' total=$messages->total_pages url="`$run.me`/i18n.view-lng-messages/`$page_url`"  current=$messages->page}>
</div>

<table class="cms_list" data-list-funcs="delete">
<{foreach item=message from=$messages}>
	<tbody data-type="element" data-lang="<{$message->lang}>" data-msg-code="<{$message->msg_code}>" data-object-id="<{$message->object_id()}>">
		<tr>
			<td class="num"><{$message->num}></td>
			<td>
				<{$message->msg_code}>
			</td>
			<td class="delete"></td>
		</tr>
		<tr>
			<td colspan="3"><textarea rows="5" name="msg_text"><{$message->msg_text}></textarea></td>
		</tr>

		<tr>
			<td colspan="3"><{$message->base_msg_text}></td>
		</tr>

		<tr>
			<td colspan="3">
				<input type="hidden" name="module" value="<{$message->base_module}>">
				<input type="checkbox" name="javascript" <{if $message->javascript}> checked<{/if}> value="1"> JavaScript
				<input type="submit" class="submit_update" value="#SAVE#">
			</td>
		</tr>
	</tbody>
<{/foreach}>
</table>

<div class="cms_admin_pager">
<{pager pager='fast' total=$messages->total_pages url="`$run.me`/i18n.view-lng-messages/`$page_url`"  current=$messages->page}>
</div>

<script type="text/javascript">
D.modules.core.bind_i18n_controls();
</script>