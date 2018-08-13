<table class="users_pm_message_his users_pm_message" title="<{$msg->msgid}>" id="msgid<{$msg->msgid}>">
 <tr>
  <td colspan="3">
   <div class="users_pm_header">
    <div class="users_pm_message_delete" onclick='return D.modules.users.delete_pm("<{$msg->msgid}>");'></div>
    <div class="users_pm_message_top_end_self"></div>
    <div class="users_pm_message_nick"><a onclick='return D.modules.users.show_user_page("<{$recipient->uid}>");' href="<{$me.path}>/show/<{$recipient->uid}>/"><{$recipient->username|left:30}></a><span><{$msg->add_time|convert_time}></span></div>
   </div>
  </td>
 </tr>
 <tr class="comment_top_border_user">
  <td rowspan="2" class="users_pm_content comment_content"><{$msg->content|bbcode}></td>
  <td></td>
 </tr>
</table>
