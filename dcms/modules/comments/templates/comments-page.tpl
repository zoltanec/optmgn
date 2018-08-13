<{if !empty($comments->meta->template)}>
    <{assign var=template value=$comments->meta->template}>
<{else}>
	<{assign var=template value='comments;single-comment'}>
<{/if}>

<div class="comments_pages_select">
	<{pager total=$comments->totalpages call='D.modules.comments.get_page' mode=$comments->order current=$comments->page}>
</div>


<table class="comments comments_container<{if $user and $user->reqRights('delete/comments/comment/')}> comments_moderator_mode<{/if}>">
 <{foreach item=comment from=$comments->fetchPage()}>
  <{include file=$template comment=$comment}>
 <{/foreach}>
</table>


<{if isset($noautoload)}>
<div class="comments_pages_select">
	<{pager total=$comments->totalpages call='D.modules.comments.get_page' mode=$comments->order current=$comments->page}>
</div>
<{/if}>

