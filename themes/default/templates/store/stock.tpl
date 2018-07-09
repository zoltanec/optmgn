<div class="pull">
 <div class="titles"><span>Акции</span></div>
 <div class="text_block">
	<{foreach item=news from=News_News::LatestNews(100,array('actions'))}>
		<div class="action_item">
		 <div class="ai_img"><{if $news->icon}><img src="<{$me.content}>/news/icons/<{$news->icon}>" /><{/if}></div>
		 <div class="ai_info">
		  <h2><{$news->title}></h2>
		  <p class="ai_content"><{$news->content_preview}></p>
		 </div>
		</div>		
	<{/foreach}>
	</div>
</div>