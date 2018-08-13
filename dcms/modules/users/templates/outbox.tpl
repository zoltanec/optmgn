<{include file='dit:users;pm.toolbar'}>
<h2 class="fullhead">Исходящие сообщения</h2>

<{if $req->okmsg != ''}>
 <div class="usermsg okmsg">
 <{if $req->okmsg == 'message-sended'}>
   Сообщение успешно послано.
 <{/if}>
 </div>
<{/if}>

<table class="listing mailbox">
 <tr class="header">
  <td>No</td>
  <td>Заголовок</td>
  <td>Кому</td>
  <td>Время отправки</td>
 </tr>
 <{foreach item=message from=$t.box->getOutgoing()}>
  <tr>
   <tD><b><{$message->num}>.</b></td>
   <td>
    <a href="<{$me.path}>/read-message/msgid_<{$message->msgid}>/"><{$message->title}></a></td>
    <td><a href="<{$me.path}>/write-outbox/uid_<{$message->uid_to}>/"><b><{$message->username_to}></b></a></td>
   <td><{$message->created->format('%d/%m/%Y %R')}></td>
  </tr>
 <{/foreach}>
</table>