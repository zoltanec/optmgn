<div id="content" class="clearfix news-wrapper pz">
    <div class="content" style="width:100%;">
        <ul class="contentBlocks clearfix">
            <{include newslist=$newslist file='news-item.tpl'}>
            <{$newslist->totalpages}>
            <{$newslist->page}>
            <{if $newslist->page != $newslist->totalpages}>
                <li class="load-more" data-page="<{($newslist->page+1)}>" onclick="Ajax.loadNews($(this).attr('data-page'), '/<{D::$req->uri}>'); return false;">
                    ЗАГРУЗИТЬ ЕЩЁ		
                </li>
            <{/if}>
            </ul>
    </div>
</div>
