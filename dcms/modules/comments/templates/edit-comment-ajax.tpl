<table class="comments_edit_comment_ajax">
 <tr>
  <td>
	<{include file='core;text-editor' content=$comment->content}>
  </td>
 </tr>
 <{if $user->uid != $comment->uid or $user->reqRights('edit/comments/')}>
 <tr class="moderator_note_block">
   <td>
   <span>Примечание:</span><br>
   <textarea name="moderator_note" class="cm_textarea cm_moderator_note" rows="3" cols="50"><{$comment->moderator_note}></textarea></td>
 </tr>
 <{/if}>
 <tr>
  <td><button class="submit_button submit_comment comments_save_comment"><span>Сохранить</span></button>
      <button class="submit_button submit_reset_button"><span>Отмена</span></button>
  </td>
 </tr>
</table>