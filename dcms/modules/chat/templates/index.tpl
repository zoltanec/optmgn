<script type="text/javascript">
var getMsgURL = '<{$me.path}>/get-chat-messages/';
var submitMsgURL = '<{$me.path}>/submit-chat-message/';
$(document).ready(function(){
	setInterval(function() {
		$.getJSON(getMsgURL, function(answer) {
			for(var num in answer) {
				$('#chat_body').append('<div class="chat_message">' + answer[num]['message'] + '</div>');
			}
		});
	}, 2500);
	$('#chat_form').bind('submit', function() {
		message = $(this).find('#chat_input').val();
		$.post(
		return false;
	});
});
</script>
<div id="chat_body">
</div>
<div id="chat_input">
<form method="post" id="chat_form">
<input id="chat_input" size="80"><input  type="submit" value="Отправить">
</form>
</div>