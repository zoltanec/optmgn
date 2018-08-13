<h2 class="fullhead">Информация о пользователе <{$siteuser->siteusername}></h2>




<table class="home_user_viev">
 <tr>
  <td class="home_user_table_left">
  </td>
  <td class="home_user_table_right"><img src="<{$me.my_content}>/avatars/<{$siteuser->avatar}>"></td>
 </tr>
 <{if $user}>
  <tr>
 	<td></td>
 	<td class="home_user_send_pm_block">
 		<button class="submit_send_pm_button" onclick='return D.modules.users.open_pm_chat("<{$siteuser->uid}>");'>
 			<span>Отправить сообщение</span>
 		</button>
 	</td>
</tr>
<{/if}>

 <tr>
  <td class="home_user_table_left">Ник:</td>
  <td class="home_user_table_right home_user_table_nick"><{$siteuser->username}></td>
 </tr>
 <tr>
  <td class="home_user_table_left ">Пол:</td>
  <td class="home_user_table_right home_user_table_male">
  	<{if $siteuser->sex=='M'}>Мужской<{else}>Женский<{/if}>
   </td>
 </tr>
 <tr>
  <td class="home_user_table_left">Сообщений:</td>
  <td class="home_user_table_right home_user_table_messages"><{$siteuser->messages}></td>
 </tr>
 <tr>
  <td class="home_user_table_left">Коэффициент полезности:</td>
  <td class="home_user_table_right home_user_table_usefull"><{$siteuser->karma}></td>
 </tr>
 <tr>
  <td class="home_user_table_left">Дата регистрации:</td>
  <td class="home_user_table_right home_user_table_date"><{$siteuser->regtime|convert_time}></td>
 </tr>
 <{if not $siteuser->birth_privacy}>
 <tr>
 	<td class="home_user_table_left">Дата рождения:</td>
 	<td class="home_user_table_right"><{$siteuser->birth}></td>
 </tr>
 <{/if}>
 <tr>
  <td class="home_user_table_left">ICQ:</td>
  <td class="home_user_table_right "><{$siteuser->icq}></td>
 </tr>
 <tr>
  <td class="home_user_table_left">Skype:</td>
  <td class="home_user_table_right"><{$siteuser->skype}></td>
 </tr>

  <tr>
  <td class="home_user_table_left">Интересы:</td>
  <td class="home_user_table_right"><{$siteuser->interests}></td>
 </tr>

  <tr>
  <td class="home_user_table_left">Откуда:</td>
  <td class="home_user_table_right"><{$siteuser->user_from}></td>
 </tr>

  <tr>
  <td class="home_user_table_left">О себе:</td>
  <td class="home_user_table_right"><{$siteuser->about}></td>
 </tr>


<{if $user and $user->reqRights('user:users/*/warnings-control')}>
 <tr>
  <td class="home_user_table_left">Статус:</td>
  <td class="home_user_table_right"><{if $siteuser->isActive()}>активен<{else}>блокирован<{if $siteuser->active_from!=0}><br>до <{$siteuser->active_from|convert_time}><{/if}><{/if}></td>
 </tr>
 <tr>
  <td class="home_user_table_left">Предупреждения:</td>
  <td class="home_user_table_right"><div id="user<{$siteuser->uid}>_warnings" class="user_warnings_control"></div></td>
 </tr>
<{/if}>
</table>

<{if $user and $user->reqRights('user:users/*/warnings-control')}>
<script type="text/javascript">
D.modules.users.init_warnings_control(<{$siteuser->uid}>);
</script>
<{/if}>