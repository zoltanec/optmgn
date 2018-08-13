<{include file='users;user-toolbar'}>
<script type="text/javascript">
$(document).ready(function() {
	D.modules.users.get_user_warnings(<{$user->uid}>,'user');
});
</script>

<form method="post" action="<{$me.path}>/update-avatar/" enctype="multipart/form-data">
 <table class="me_table" border="0">
  <tr>
    <td class="me_left_td">Никнейм:<{$user->username}></td>
    <td title="<{$user->username}>"><{$user->username|left:"30"}></td>
  </tr>
  <tr>
    <td class="me_left_td">Сообщений:</td>
    <td><{$user->messages}></td>
  </tr>
   <tr>
    <td class="me_left_td">Коэффициент полезности:</td>
    <td id><span><{$user->karma}></span></td>
  </tr>
   <tr>
    <td class="me_left_td">Дата регистрации:</td>
    <td><{$user->regtime|convert_time}></td>
  </tr>
  <tr>
    <td class="me_left_td">Аватар:</td>
    <td id="avatar_img">

	<{if empty($user->avatar)}>
    	<img id="current_user_avatar" onclick='return usersJS.showAvatarSelector();' src="<{$theme.mimages}>/default_avatar.png">
    <{else}>
    	<img id="current_user_avatar" onclick='return usersJS.showAvatarSelector();' src="<{$me.my_content}>/avatars/<{$user->avatar}>">
    <{/if}>
    </td>

  </tr>
   <tr>
    <td class="me_left_td"></td>
    <td> <a href="#" class="add_list_avatar" onclick='return usersJS.showAvatarSelector();'>Выбрать другую аватарку</a><br>
    <a class="delete_avatar" onclick='return usersJS.truncateAvatar();' href="#">Удалить картинку</a></td>
  </tr>
  <tr>
    <td class="me_left_td">Загрузить свою картинку (80*80px):</td>
    <td><input type="file" name="avatar"></td>
  </tr>

  <tr>
    <td class="me_left_td"></td>
    <td>
    	<button class="submit_button" type="submit"><span>Загрузить</span></button>
    </td>
  </tr>
 </table>
 </form>

 <form action="<{$me.path}>/update-my-password/" method="post">
 <table class="me_table">
  <tr>
    <td class="me_left_td"><h4>Изменение пароля</h4></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="me_left_td">Старый пароль:</td>
    <td><input type="password" name="old_password"></td>
  </tr>
  <tr>
    <td class="me_left_td">Новый пароль:</td>
    <td><input type="password" name="new_password1"></td>
  </tr>
  <tr>
    <td class="me_left_td">Повторите новый пароль:</td>
    <td><input type="password" name="new_password2"></td>
  </tr>
  <tr>
    <td class="me_left_td"></td>
    <td>

    <button class="submit_button" type="submit"><span>Сохранить</span></button></td>
  </tr>
  </table>
  </form>

<form action="<{$me.path}>/update-my-info/" method="post">
  <table class="me_table">
  <tr>
    <td class="me_left_td"><h4>Информация о себе</h4></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="me_left_td">ICQ:</td>
    <td><input type="text" name="icq" value="<{$user->icq}>"></td>
  </tr>
  <tr>
    <td class="me_left_td">Skype:</td>
    <td><input type="text" name="skype" value="<{$user->skype}>"></td>
  </tr>
  <tr>
    <td class="me_left_td">Пол:</td>
    <td><input type="radio" name="sex" value="M"<{if $user->sex=='M'}> checked<{/if}>>&nbsp;М
        <input type="radio" name="sex" value="W"<{if $user->sex=='W'}> checked<{/if}>>&nbsp;Ж
        </td>
  </tr>
  <tr>
    <td class="me_left_td">День рождения:</td>
    <td><{date_input date=$user->birth name='birth' format='%Y-%m-%d'}> <input type="checkbox" name="birth_privacy" value="1"<{if $user->birth_visibility}> checked<{/if}>>скрыть от других пользователей</td>
  </tr>
  <tr>
    <td class="me_left_td">Мои интересы:</td>
    <td><textarea name="interests" cols="40" rows="4"><{$user->interests}></textarea></td>
  </tr>
  <tr>
    <td class="me_left_td">Откуда:</td>
    <td><input type="text" name="user_from" value="<{$user->user_from}>"></td>
  </tr>
  <tr>
    <td class="me_left_td">О себе:</td>
    <td><textarea cols="50" rows="5" name="about"><{$user->about}></textarea></td>
  </tr>
  <tr>
    <td class="me_left_td">Подпись сообщений:</td>
    <td><textarea rows="5" cols="50" name="sign"><{$user->sign}></textarea></td>
  </tr>
    <tr>
    <td class="me_left_td"></td>
    <td>
    <button class="submit_button" type="submit"><span>Сохранить</span></button></td>
  </tr>
</table>
</form>


<table class="me_table">
 <tr>
  <td class="me_left_td"><h4>Предупреждения модератора</h4></td>
  <td></td>
 </tr>

 <tr>
  <td colspan="2" id="moderator_warnings"></td>
 </tr>
</table>
