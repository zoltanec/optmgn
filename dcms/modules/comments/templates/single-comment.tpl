 <tbody title="<{$comment->comid}>">
    <tr id="commentN<{$comment->comid}>" class="cm_head">
        <td colspan="3">
         <div class="cm_user_meta">
        &nbsp;<a href="<{$me.www}>/users/show/uid_<{$comment->uid}>/" class="cm_user_link"><{$comment->username}></a>

        [сообщений: <b><{$comment->messages}></b>]
        <!-- <abbr title="Положительных оценок: <{$comment->karma_plus}>; Отрицательных оценок: <{$comment->karma_minus}>.">[Коэф. полезности: <b><{$comment->karma}></b>]</abbr>-->
        </div>
        <div class="cm_link">
         <a onclick="return comments.insertLink('<{$comment->username}>','<{$comment->comid}>');" name="<{$comment->comid}>" href="#com_input">#<{$comment->comid}></a>
        </div>
        </td>
    </tr>

    <tr class="cm_meta_info">
        <td colspan="3" class="cm_addtime">

         <div class="cm_pm_info">
          <a href="#commentN<{$comment->comid}>" onclick='return comments.cmSendAbuse("<{$comment->comid}>");' class="cm_send_abuse">[Пожаловаться]</a>
          <a class="cm_write_pm" href="<{$me.www}>/users/write-outbox/uid_<{$comment->uid}>/">[Написать ЛС]</a>
           Опубликовано:&nbsp;<{$comment->addtime|convert_time}>
         </div>

         <div class="cm_karma">
            <a href="#" onclick="return comment.updateComment(<{$comment->comid}>,'up');"><img src="<{$theme.images}>/core/plus.png" alt="+"></a>
            <span class="karma">
               <abbr id="comment_karma_<{$comment->comid}>" title="Положительных оценок: <{$comment->plus}>, Отрицательных оценок: <{$comment->minus}>"><{$comment->comment_karma}></abbr></span>
            <a href="#" onclick="return comments.updateComment(<{$comment->comid}>,'down');"><img src="<{$theme.images}>/core/minus.png" alt="-"></a>
          </div>
        </td>
    </tr>
    <tr>
        <td class="cm_avatar">
        <{if !empty($comment->avatar)}>
            <img src="<{$me.content}>/users/avatars/<{$comment->avatar}>">
        <{else}>
            <img src="<{$me.content}>/users/avatars/default.png">
        <{/if}>
        </td>
        <td colspan="2" rowspan="3" class="cm_comment">
        <div class="cm_user_menu">
          <{if $comment->uid == $user->uid}>
           <form method="get" action="<{$me.www}>/comments/edit-comment/comid_<{$comment->comid}>/">
            <input type="submit" class="submit submit_ok" value="Редактировать">
           </form>
         <{/if}>
        </div>
	  <span class="cm_comment_content"><{$comment->html}></span>
	  <{if $comment->updtime != 0}>
	   <div class="cm_last_updated">Обновлено <{$comment->updated->format('%Y/%m/%d %R')}></div>
	  <{/if}>
	  <{if !empty($comment->moderator_note)}>
	  <div class="cm_moderator_note">
	   <b>Примечание модератора:</b>
	    <{$comment->moderator_note}>
	  </div>
	  <{/if}>
	  <{if !empty($comment->sign)}>
	   <div class="cm_sign">
	   <{$comment->sign}>
	   </div>
	  <{/if}>
	</td>
    </tr>

     <tr><td class="cm_user_from">Откуда: <{$comment->user_from}></td></tr>
     <tr><td class="cm_user_group">Группа: <b style='color: <{$comment->group_color|dectocolor}>'><{$comment->group_name}></b></td></tr>
</tbody>