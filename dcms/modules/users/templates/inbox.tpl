<{include file='dit:users;pm.toolbar'}>

<h2 class="fullhead">Входящие сообщения</h2>
<table class="listing mailbox">
 <tr class="header">
  <td>No</td>
  <td>Заголовок</td>
  <td>Отправитель</td>
  <td>Время отправки</td>
  <td></td>
  <td></td>
 </tr>
 <{foreach item=message from=$t.box->getIncomming()}>
  <tr<{if !$message->readed}> class="pm_unreaded"<{/if}>>
   <td><b><{$message->num}>.</b></td>
   <td><a href="<{$me.path}>/read-message/msgid_<{$message->msgid}>/"><{$message->title}></a></td>
   <td><a href="<{$me.path}>/show/uid_<{$message->uid_from}>/"><b><{$message->username_from}></b></a></td>
   <td><i><{$message->created->format('%d/%m/%Y %r')}></i></td>
   <td>
    <form method="post" action="<{$me.path}>/write-outbox/uid_<{$message->uid_from}>/">
    <input type="submit" class="submit" value="Ответить">
   </form>
   </td>
   <td><form method="post" onsubmit="return confirm('Удалить сообщение?');" action="<{$me.path}>/delete-message/msgid_<{$message->msgid}>/">
    <input type="submit" class="submit delete" value="Удалить">
   </form></td>
  </tr>
 <{/foreach}>
</table>