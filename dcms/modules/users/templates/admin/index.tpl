<h2>Список пользователей</h2>
<a href="<{$t.run.me}>/sms-delivery/">СМС рассылка</a>

<table class="cms_list" data-list-funcs="delete active edit">
 <tr>
  <td colspan="8">Поиск пользователя:
    <form method="post" action="<{$run.me}>/search-user/">
    <input type="text" name="username">
    <input type="submit" class="submit submit_search" value="Поиск">
    </form>
  </td>
 </tr>
 <tr>
 	<td colspan="8">
 		Показать:
 			<a href="<{$run.me}>/index/mode_all/">всех</a> |
 			<a href="<{$run.me}>/index/mode_banned/">блокированных</a>
 	</td>
 </tr>
 <thead>
  <tr>
   <th>N</th>
   <th>UID</th>
   <th>Имя пользователя</th>
   <th>Дата регистрации</th>
   <th colspan="3">Функции</th>
  </tr>
 </thead>
<{foreach item=user from=$userslist->fetchPage()}>
 <tbody data-type="element" data-id="<{$user->uid}>" data-active="<{$user->active}>" data-object-id="<{$user->object_id()}>"
  <tr>
   <td class="num"><{$user->num}></td>
   <td><b><{$user->uid}></b></td>
   <td><a href="<{$run.me}>/edit-user/uid_<{$user->uid}>/"><{$user->username}></a></td>
   <td><{$user->reg_time|convert_time}></td>
   <td class="active"></td>
   <td class="edit" data-url="<{$run.me}>/edit-user/uid_<{$user->nid}>/"></td>
   <td class="delete"></td>
  </tr>
  </tbody>
<{/foreach}>
</table>