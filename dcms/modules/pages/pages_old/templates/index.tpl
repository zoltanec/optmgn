<h1><{$page->title}></h1>
<{$page->content_html}>
<{if $page->comments}>
 <{include object_id=$page->object_id() file="comments;comments"}>
<{/if}>