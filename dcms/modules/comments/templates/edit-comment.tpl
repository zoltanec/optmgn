<h2 class="fullhead">Редактирование комментария</h2>
 <form method="post" action="<{$me.path}>/update-comment/comid_<{$t.comment->comid}>/">
 <input type="hidden" name="referer" value="<{$req->referer()}>">
<table>
 <tr>
  <td>Сообщение:</td>
  <td>
<{include file='core;text-editor' content=$comment->content}>
 </td>
 </tr>

 <{if $user->uid != $comment->uid or $user->reqRights('edit/comments/')}>
 <tr>
  <td>Примечание:</td>
  <td><textarea name="moderator_note" rows="3" cols="50"><{$t.comment->moderator_note}></textarea></td>
 </tr>
 <tr>
  <td></td>
  <td><a class="submit submit_delete" href="<{$me.path}>/delete-comment/comid_<{$t.comment->comid}>/">Удалить</a>
  </td>
 </tr>
 <{/if}>

 <tr>
  <td></td>
  <td><input type="submit" class="submit submit_ok" value="Сохранить"></td>
 </tr>
</table>
</form>
