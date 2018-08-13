
<{if $comments_meta->count > 0}>
<table class="cm_pager">
 <tr>
  <td class="cm_totalmsg">

   <span class="cm_comments_counter">Всего сообщений:<b><{$comments->meta->comments}></b>
   									 месяц:&nbsp;<i><{$comments->meta->month_comments}></i>
   									 неделя:&nbsp;<strong><{$comments->meta->week_comments}></strong>
   									 день:&nbsp;<span><{$comments->meta->day_comments}></span></span>
  </td>
   </tr>
 </table>
<{/if}>


<{if $comments->totalpages > 1}>
<div class="cm_pages_links">Страницы:
	<{if $comments->order == 'normal'}>
			<{if $comments->page != $comments->firstpage}>
				<a class="cm_tobegin cm_page_link" title="<{$comments->firstpage}>" href="<{modify_request cmpage=$comments->firstpage}>">&laquo;</a>
				<a class="cm_prevpage cm_page_link" title="<{$comments->prevpage}>" href="<{modify_request cmpage=$comments->prevpage}>">&lt;</a>
			<{/if}>
		<{if $comments->lastpage!=$comments->firstpage}>
				<{foreach item=page from=$comments->pager2()}><a title="<{$page}>" class="cm_page_link<{if $page == $comments->page}> cm_page_current<{/if}>" href="<{modify_request cmpage=$page}>"><{$page}></a><{/foreach}>
		<{/if}>
		<{if $comments->page != $comments->lastpage}>
			<a class="cm_nextpage cm_page_link" class="<{$comments->nextpage}>" href="<{modify_request cmpage=$comments->nextpage}>">&gt;</a>
			<a class="cm_toend cm_page_link" class="<{$comments->lastpage}>" href="<{modify_request cmpage=$comments->lastpage}>">&raquo;</a>
		<{/if}>
	<{else}>
		<a class="cm_toend cm_page_link" title="<{$comments->firstpage}>" href="<{modify_request cmpage=$comments->firstpage}>">&laquo;</a>
		<{if $comments->page != $comments->firstpage}>
		<a title="<{$comments->nextpage}>" class="cm_nextpage cm_page_link" href="<{modify_request cmpage=$comments->nextpage}>">&lt;</a>
		<{/if}>
		<{if $comments->lastpage!=$comments->firstpage}>

			<form action="<{modify_request}>" method="post" onsubmit="return comments.getPage($(this).find('[name=cmpage]').val())">
			  <input type="text" size="4" name="cmpage" value="<{$comments->page}>"> из <{$comments->totalpages}>
			</form>
		<{/if}>
		<{if $comments->page != $comments->lastpage}>
		<a class="cm_prevpage cm_page_link" title="<{$comments->prevpage}>" href="<{modify_request cmpage=$comments->prevpage}>">&gt;</a>
		<a class="cm_tobegin cm_page_link" title="<{$comments->lastpage}>" href="<{modify_request cmpage=$comments->lastpage}>">&raquo;</a>
		<{/if}>
	<{/if}>
</div>
<{/if}>