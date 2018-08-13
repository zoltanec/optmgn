<{if empty($comments->meta->template)}>
	<{assign var=template value='comments;single-comment'}>
<{else}>
	<{assign var=template value=$comments->meta->template}>
<{/if}>
<{foreach item=comment from=$comments}>
	<{include file=$template comment=$comment}>
<{/foreach}>