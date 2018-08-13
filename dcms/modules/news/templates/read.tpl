<table id="rn_block">
 <tr>
  <td id="rn_content">
  <h2 class="fullhead"><{$t.news->title}></h2>
  <table class="public_info">
   <tr><td><b>Автор:</b></td><td><i><{$t.news->author}></i></td></tr>
   <tr><td><b>Источник:</b></td><td><{$t.news->source}></td></tr>
   <tr><td><b>Опубликовано:</b></td><td><i><{$t.news->addtime|convert_time}></i></td></tr>
  </table>
    <p class="news_content">
    	<{if $t.news->mode=='html'}>
    		<{$tnews->content}>
    	<{else}>
    		<{$t.news->content|bbcode}>
    	<{/if}>
    </p>
    	<{if $t.news->comments_status}>
    		<{include object_id=$news->object_id() order_mode='normal' file="comments;comments"}>
    	<{/if}>
 </td>
 <td id="rn_allnews">
 <{foreach item=news_day from=News::DayGrouped()}>
  <div class="new_day"><{$news_day.name}></div>
   <ul class="this_day_news">
    <{foreach item=news from=$news_day.news}>
        <li><a href="<{$me.path}>/read/<{$news->nid}>/"><{$news->title}></a>
        <span class="news_stat_block">
        <img src="<{$theme.images}>/read_white.gif"><{$news->readed}>
        <{if $news->comments!=0}>
        	<a href="<{$me.path}>/comments/<{$news->nid}>/">
        	<img src="<{$theme.images}>/comment_white.gif"><span class="news_comments"><{$news->comments}></span></a>
        <{/if}>
        </span>
        </li>
    <{/foreach}>
   </ul>
 <{/foreach}>
 </ul>
  </td>
</tr>
</table>
