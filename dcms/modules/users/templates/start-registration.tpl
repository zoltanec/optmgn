<div class="users_registration_header"></div>
<h2 class="fullhead registration_start">Регистрация нового пользователя</h2>
<{if $req->sms == 'show'}>
<div class="sms_block">Чтобы подписаться на sms-рассылку, необходимо зарегистрироваться или войти на сайт и в личном кабинете указать имя и номер мобильного телефона.</div>
<{/if}>
<div class="errors">
	<{if $status=='ERROR_PASSWORDS_MISMATCH'}>
		Введеные пароли не совпадают!
	<{elseif $status=='ERROR_USER_EXISTS'}>
		Пользователь с таким именем уже существует
	<{elseif $status=='ERROR_NO_EMAIL'}>
		Введите ваш e-mail
	<{elseif $status=='WAIT_FOR_CONFIRMATION'}>
		На вашу почту должно прийти письмо для подтверждения регистрации
	<{/if}>
</div>
<form method="post" action="<{$me.path}>/submit-registration/">

<table class="users_registration_form" id="users_registration_form">
<!-- Username enter -->
 <tbody data-block="username">
  <tr>
   <td class="users_registration_field_name">#USERNAME#:</td>
   <td data-validator="username"></td>
  </tr>
  <tr><td colspan="2"><input type="text" name="username"></td></tr>
 </tbody>
 <!-- Username enter end -->
 <!-- Passwords enter -->
 <tbody data-block="password">
  <tr>
   <td class="users_registration_field_name">#USERS_ENTER_PASSWORD_1#:</td>
   <td data-validator="password"></td>
  </tr>

  <tr><td colspan="2"><input type="password" name="password1"></td></tr>

  <tr><td class="users_registration_field_name" colspan="2">#USERS_ENTER_PASSWORD_2#:</td></tr>
  <tr><td colspan="2"><input type="password" name="password2"></td></tr>
 </tbody>
 <!-- Passwords enter end -->


 <{if $config->users_registration_confirm}>
 <tbody data-block="email">
  <tr>
   <td class="users_registration_field_name">E-Mail:</td>
   <td data-validator="email"></td>
  </tr>
  <tr>
   <td colspan="2"><input type="text" name="email" placeholder="#USERS_ENTER_YOUR_EMAIL_HERE#"></td>
  </tr>
 </tbody>
 <{/if}>

 <tbody data-block="captcha">
  <tr>
   <td class="users_registration_field_name">#USERS_REGISTRATION_CAPTCHA#:</td>
   <td data-validator="captcha"></td>
  </tr>
  <tr>
   <td><img src="<{$me.path}>/captcha/"> <input type="text" name="captcha"></td>
  </tr>
 </tbody>

 <tbody data-block="rules">
  <tr>
   <td colspan="2" class="users_registration_rules_header users_registration_field_name">#RULES#</td>
  </tr>

  <tr>
   <td colspan="2">
  	<div class="users_registration_rules">
  		<{include file='users;rules'}>
  	</div>
  </td>
 </tr>
 <tr>
  <td colspan="2">#USERS_REGISTRATION_CONFIRM_RULES# <input type="checkbox" name="rules_confirm" value="1"></td>
 </tr>
 </tbody>


 <tr>
  <td colspan="2">
  	<button type="submit" class="submit_reg_button"><span>#USERS_REGISTRATION_SUBMIT#</span></button>
  </td>
 </tr>
</table>
</form>
<script type="text/javascript">
D.modules.users.bind_registration_form();
</script>