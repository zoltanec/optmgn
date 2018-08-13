<{if !$req->isAjax()}>
<{include file="dit:news;sections.list.tpl"}>
<script type="text/javascript">
var current_section_key = '<{$section->section_key}>';
function getNewsPage(page) {
	$('.news_list_block').css('opacity',0.3).css('cursor','wait');
	$.get(siteVars.www + '/news/archive/<{$section->section_key}>/' + page, function(answer) {
		$('#news_page_content').html(answer);
	});
	//document.location.href='<{$me.path}>/archive/<{$section->section_key}>/' + page;
	return false;
}
$(document).ready(function() {
	$('.news_select_section [data-section-key="' + current_section_key + '"]').addClass('news_active_section');
});
</script>
<div id="news_page_content">
<{/if}>

<div class="news_pager">
	<{pager total=$newslist->totalpages call='getNewsPage' current=$newslist->page}>
</div>

<div class="news_list_block">
<{foreach item=news from=$newslist}>
    <div class="news_block">
        <div class="news_header">
            <a class="news_title" href="<{$me.path}>/read/<{$news->nid}>/"><{$news->title}></a></div>
            <div class="news_source_menu">Источник:&nbsp;<{$news->source}>
        </div>
        <div class="news_short_content"><{$news->content_preview}>
    	    <div class="news_full_details stat">
       		Добавлено: <{$news->addtime|convert_time}> |
        	<span class="views">Просмотров:&nbsp;<{$news->readed}></span>

        	<{if $news->comments > 0}> |
           		<a class="comments" href="<{$me.path}>/comments/<{$news->nid}>/">Комментариев: &nbsp;<{$news->comments}></a>
           	<{/if}>
           	| <a class="details" href="<{$me.path}>/read/<{$news->nid}>/">Подробнее&raquo;</a>
        	</div>
    	</div>
	</div>
<{/foreach}>
</div>

<div class="news_pager">
	<{pager total=$newslist->totalpages call='getNewsPage' current=$newslist->page}>
</div>

<{if !$req->isAjax()}>
</div>
<{/if}>