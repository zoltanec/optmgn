<h1>Редактированние параметров пользователя <{$siteuser->username}></h1>
<form method="post" action="<{$run.me}>/update-user/uid_<{$siteuser->uid}>/">
<table class="cms_form">
	<{formline name='username' title='Имя пользователя' value=$siteuser->username}>
	<{formline name='active' title='Активен' type='bool' value=$siteuser->active}>

   <tr>
    <td>Комментарии на сайте:</td>
    <td><b><{$siteuser->messages}></b>&nbsp; / &nbsp; <a href="<{$me.path}>/run/comments/list-comments/uid_<{$siteuser->uid}>/">[найти комментарии пользователя]</a></td>
   </tr>

   <tr>
    <td>Активен:
    	<div class="help">Снимите эту галочку чтобы заблокировать пользователя.</div>
    </td>
    <td><input type="checkbox" name="active" value="1"<{if $siteuser->active}> checked<{/if}>></td>
   </tr>

   <tr>
   	<td>Активен с:<div class="help">Пользователь станет активен после указанного времени. Формат времени ГГГГ-ММ-ДД ЧЧ:ММ:CC</div></td>
   	<td><input type="text" name="active_from" value="<{$siteuser->active_from|convert_time:"byformat":"%Y-%m-%d %R"}>"></td>
   </tr>


   <tr>
    <td>Дата регистрации:</td>
    <td><i><{$siteuser->regtime|convert_time}></i></td>
   </tr>

   <tr>
    <td>Группа:</td>
    <td><select name="gid">
         <{foreach item=group from=Users_Group::getUsersGroups()}>
          <option value="<{$group->gid}>"<{if $siteuser->gid == $group->gid}> selected<{/if}>><{$group->group_name}>
         <{/foreach}>
    </select>
    </td>
   </tr>

   <tr>
    <td>Пароль:</td>
    <td><input type="password" name="password"></td>
   </tr>

   <tr>
    <td>Описание:</td>
    <td><textarea name="about" rows="3" cols="40"><{$siteuser->about}></textarea></td>
   </tr>

   <tr>
    <td>Подпись:</td>
    <td><textarea rows="3" cols="40" name="sign"><{$siteuser->sign}></textarea></td>
   </tr>

   <tr>
    <td>Предупреждения:</td>
    <td><div id="user<{$siteuser->uid}>_warnings" class="user_warnings_control"></div></td>
   </tr>

   <tr>
    <td></td>
    <td><input type="submit" class="submit submit_update" value="#SAVE#">
        <button class="submit_delete">#DELETE#</button>
     </td>
    </tr>
 </tbody>
</table>
</form>
<script type="text/javascript">
$(document).ready(function() {
	usersJS.initWarningsControl(<{$siteuser->uid}>);
});
</script>