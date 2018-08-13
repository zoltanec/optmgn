<style>
.comments_edit_comment_ajax {
	width: 90%;
}
</style>
<h2>Управление комментариями</h2>
<table>
 <tr>
	<td class="but"><a class="cm_toend" href="<{modify_request cmpage=$comments->firstpage}>">[конец]</a></td>
		<{if $comments->page != $comments->firstpage}>
		<td class="but"><a class="cm_nextpage" href="<{modify_request cmpage=$comments->nextpage}>">[вперед]</a></td>
		<{/if}>
		<{if $comments->lastpage!=$comments->firstpage}>
			<td class="but"><select name="cmpage">
				<{foreach item=page from=$comments->pager()}>
					<option <{if $page==$comments->page}> selected <{/if}>value="<{$page}>" onclick="document.location.href='<{modify_request cmpage=$page}>';"><{$page}>
				<{/foreach}>
			</select></td>
		<{/if}>
		<{if $comments->page != $comments->lastpage}>
			<td class="but"><a class="cm_prevpage" href="<{modify_request cmpage=$comments->prevpage}>">[назад]</a></td>
			<td class="but"><a class="cm_tobegin" href="<{modify_request cmpage=$comments->lastpage}>">[начало]</a></td>
		<{/if}>
	 </tr>
	</table>

<table class="list">

<{foreach item=comment from=$comments}>
  <tbody id="usercomment<{$comment->comid}>">
    <tr class="linehead">
        <td>Автор: <a href="<{$run.admin}>/users/edit-user/uid_1/"><{$comment->username}></a></td>
        <td>Добавлен:<{$comment->addtime|convert_time}></td>
        <td>IP: <{$comment->ip_info.ip}></td>
        <td><a href="<{$run.me}>/show-comment-object/<{$comment->object_id}>/">[объект]</a></td>
    </tr>
    <tr>
        <td colspan="4" class="comment_html">
            <{$comment->content|strip}>
        </td>
    </tr>
    <tr>
        <td colspan="4">
         <a class="edit_link" onclick="return comments.editUserComment('<{$comment->comid}>');">#EDIT#</a>
         <a class="delete_link" onclick="return confirm('Удалить комментарий? ID: <{$comment->comid}>');" href="<{$tpl.run.me}>/delete-comment/comid_<{$comment->comid}>/">Удалить</a>
         <{if !$comment->approved}>
         	<a href="approve_link" onclick="return approveComment(<{$comment->comid}>);">Подтвердить</a>
         <{/if}>

         </td>
    </tr>
   </tbody>
<{/foreach}>
<script type="text/javascript">
function approveComment(comid) {
	$.getJSON('<{$run.me}>/approve-comment/comid_' + comid, function(answer) {
		alert("Комментарий подтвержден!");
		$('#comment' + comid).hide();
		return false;
	});
	return false;
}
</script>