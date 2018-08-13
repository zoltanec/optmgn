<h2 class="users_wait_for_confirmation_header">#USERS_WAIT_FOR_CONFIRMATION#</h2>

<div class="users_wait_for_confirmation_text">#USERS_WAIT_FOR_CONFIRMATION_BODY#</div>
<div class="users_enter_confirmation_code">
	<form method="post" action="<{$me.path}>/submit-confirmation-code/">
		<input type="hidden" name="uid" value="<{$req->int('uid')}>">
		<div class="users_confirm_code_enter_block">#USERS_ENTER_CONFIRMATION_CODE#: <input type="text" name="code" size="7"></div>
		<div class="users_confirm_code_submit_block"><button class="users_confirm_code_submit"><span>#USERS_SUBMIT_CONFIRM_CODE#</span></button></div>
	</form>
</div>