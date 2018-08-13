<{foreach item=news from=$tpl.news}>
    <div class="news_block">
        <div class="news_header">
            <a class="news_title" href="<{$me.path}>/read/<{$news->nid}>/"><{$news->title}></a> /
            <a class="news_section_name" href="<{$me.path}>/section/<{$news->sid}>/"><{$news->section_name}></a></div>
        <div class="news_source_menu">Источник:&nbsp;<{$news->source}> / Добавлено: <{$news->addtime|convert_time}> /
        <span class="news_stat_block">
            <img src="<{$theme.images}>/read.gif"><{$news->readed}>
            <img src="<{$theme.images}>/comment.gif"><{$news->comments}>
        </span>
        </div>
        <div class="news_short_content"><{$news->short|bbcode}>
            <div class="news_details"><a class="details" href="<{$me.path}>/read/<{$news->nid}>/">Подробнее&raquo;</a></div>
        </div>
    </div>
<{/foreach}>