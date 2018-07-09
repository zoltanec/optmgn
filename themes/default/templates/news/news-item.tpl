<{foreach item=news from=$newslist}>
    <li class="news-new">
        <a href="<{$me.path}>/read/<{$news->nid}>/">
            <img class="news-img back" src="<{$news->__thumbs_url()}>" alt="<{$news->title}>"/>
            <div class="layercontent">
                <div class="headerPart">
                    <h3><{$news->title}></h3>
                </div>
                <div class="line"></div>
                <p><{$news->content_preview}></p>
            </div>
        </a>
    </li>
<{/foreach}>