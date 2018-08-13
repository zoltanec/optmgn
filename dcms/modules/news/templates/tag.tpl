<h2 class="fullhead">Новости дня</h2>
<{foreach item=news from=$t.news}>
    <div class="news_block">
        <div class="news_header">
            <a class="news_title" href="<{$me.path}>/read/<{$news->nid}>/"><{$news->title}></a> /
            <a class="news_section_name" href="<{$me.path}>/archive/<{$news->sid}>/"><{$news->section_name}></a></div>
        <div class="news_source_menu">Источник:&nbsp;<{$news->source}> / Добавлено: <{$news->addtime|convert_time}> /
        <span class="news_stat_block">
            <img src="<{$theme.images}>/read.gif"><{$news->readed}>
           <{if $news->comments != 0}>
           	<a href="<{$me.path}>/comments/<{$news->nid}>/">
           		<img src="<{$theme.images}>/comment.gif"><span class="news_comments"><{$news->comments}>
           	</a>
           	</span><{/if}>
        </span>
        </div>
        <div class="news_short_content"><{$news->short}>
            <div class="news_details"><a class="details" href="<{$me.path}>/read/<{$news->nid}>/">Подробнее&raquo;</a></div>
        </div>
    </div>
<{/foreach}>