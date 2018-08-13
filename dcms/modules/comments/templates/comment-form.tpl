<h2 class="fullhead comment_add_form">#ADD_NEW_COMMENT#</h2>

<div class="auth_required">
<form method="post" id="comment_submit" action="<{$me.www}>/comments/post-comment/">
<input type="hidden" name="return" value="<{$req->current_url}>">
<input type="hidden" id="object_id" name="object_id" value="<{$object_id}>">
<table class="post_form" id="comment_wrapper">
 <tr>

  <td><{include file='core;text-editor.tpl'}></td>
 </tr>

 <tr>

  <td class="cm_fast_send">Для быстрой отправки сообщения нажмите Ctrl + Enter</td>
 </tr>

 <tr>
   <td class="cm_send_buttons">
   <button type="submit" class="comments_submit_comment"><span>#SEND_MESSAGE#</span></button>
   <button type="reset" onclick='$("#com_input").empty();' class="submit_button submit_reset_button"><span>#CLEAR#</span></button>
</td>
</tr>
<tr>
	<td colspan="2" class="comments_rules">
		<{include file='comments;comments-rules'}>
	</td>
</tr>
</table>
</form>
</div>

<div id="auth_needed" class="noauth_required">
	<div class="auth_first_please"><span>#TO_POST_COMMENT_YOU_NEED_TO_AUTHORIZE_FIRST#</span>
	<form class="authorization_form cms_login_form" action="<{$me.www}>/users/authorize-me/" method="post">
	<input type="hidden" id="return" name="return" value="<{$req->current_url}>">
                <table class="cms_login_form">
                    <tr>
                        <td rowspan="4" class="img"></td>
                        <td>#USERNAME#:</td>
                        <td><input type="text" name="username"></td>
                    </tr>
                    <tr>
                        <td>#PASSWORD#:</td>
                        <td><input type="password" name="password"></td>
                    </tr>
                    <tr>
                    	<td>#REMEMBER_ME#:</td>
                    	<td><input type="checkbox" name="rememberme" value="1"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button class="submit_auth_button cms_login_form_submit" type="submit"><span>#LOG_IN#</span></button></td>
                    </tr>
                </table>
            </form>


	</div>
</div>