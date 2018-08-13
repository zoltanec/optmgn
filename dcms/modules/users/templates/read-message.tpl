<{include file='dit:users;pm.toolbar.tpl'}>
<h2 class="fullhead">Личное сообщение</h2>

<table class="pm_message">
 <{include message=$t.message file='dit:users;single-message'}>

 <{if $t.message->type == 'inbox'}>
 <tr>
  <td colspan="3">
   <form method="post" onsubmit="return confirm('Удалить сообщение?');" action="<{$me.path}>/delete-message/msgid_<{$t.message->msgid}>/">
    <input type="submit" class="submit delete" value="Удалить">
   </form>
   <form method="post" action="<{$me.path}>/write-outbox/uid_<{$t.message->uid_from}>/parentmsgid_<{$t.message->msgid}>/">
    <input type="submit" class="submit" value="Ответить">
   </form>
  </td>
 </tr>
 <{/if}>
</table>