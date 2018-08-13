<h2>Support ticket: <{$ticket->subject}> [ID: <{$ticket->code}>]</h2>

<style>
.support_message_type_in {
	border: 2px solid #999;
}
.support_message_type_ou {
	border: 2px solid green;
}
.support_author {
	vertical-align: top;
	text-align: center;
	padding-top: 10px;
}
</style>

<table>
	<tr>
		<td>Started:</td>
		<td><{$ticket->add_time|convert_time}></td>
	</tr>

	<tr>
		<td>Account:</td>
		<td><{$ticket->account}></td>
	</tr>

	<tr>
		<td>From:</td>
		<td><{$ticket->author}></td>
	</tr>
</table>

<h2>Messages</h2>
<{foreach item=msg from=$ticket->messages}>
<table class="cms_list support_message_type_<{$msg->mtype}>">
	<thead>
		<tr>
			<th width="16%">Source</th>
			<th>Message</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td rowspan="2" class="support_author">
				<{if $msg->mtype == 'ou'}>
					Support
				<{else}>
					<{$ticket->author}>
				<{/if}>
			</td>
			<td><{$msg->add_time|convert_time}></td>
		</tr>
		<tr>
			<td style="white-space: pre;"><{$msg->msg|escape:"htmlall"}></td>
		</tr>
	</tbody>
</table>
<br>
<{/foreach}>

<h2>Answer</h2>

<form method="post" action="<{$run.me}>/submit-ticket-message/">
<input type="hidden" name="tid" value="<{$ticket->tid}>">
<table class="cms_form">
	<{formline type='header'}>
	<{formline type='textarea' title='Message' name='message'}>
	<{formline type='save'}>
</table>
</form>