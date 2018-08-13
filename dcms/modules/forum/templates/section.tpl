<{capture name="page_link"}>
<{$me.path}>/section/sid_<{$section->sid}>/page_!PAGE!/
<{/capture}>
<{include section=$t.section file='section-path'}>
<{include forum=$section file='sections-list'}>
<{if is_object($user) and not $section->readonly}>
  <div class="newtopic">
	<a class="newtopic" href="<{$me.path}>/new-topic/sid_<{$t.section->sid}>/"><img src="<{$theme.mimages}>/<{$req->lang}>/new_topic.png"></a>
	<!-- <a class="newtopic" href="<{$me.path}>/new-topic/sid_<{$t.section->sid}>/"><img src="<{$theme.mimages}>/<{$req->lang}>/new_vote.png"></a>-->
  </div>
<{/if}>

<div class="forum_page_select">
<{pager total=$list->totalpages current=$list->page url=$smarty.capture.page_link}>
</div>

<table class="topics">
 <tr class="header">
 	<td colspan="6">#FORUM_SECTION_TOPICS#</td>
 </tr>
 <tr class="topics_legend">
  <td></td>
  <td>#TOPIC_NAME#</td>
  <td>#AUTHOR#</td>
  <td>#TOTAL_MESSAGES#</td>
  <td>#TOTAL_VIEWS#</td>
  <td>#LAST_MESSAGE#</td>
 </tr>
<{foreach item=topic from=$list}>
	<tbody class="topic" ondblclick="document.location.href='<{$me.path}>/topic/tid_<{$topic->tid}>/';">
		<tr>
	  	 <td class="topic_icon"><a class="topic_status" href="<{$me.path}>/topic/tid_<{$topic->tid}>/last_<{$topic->lastupdate}>/cmpage_<{$topic->pages}>/cmperpage_<{Forum_Topic::FORUM_MESSAGES_ON_PAGE}>/"> &nbsp; </a></td>
		<td class="name"><{if $topic->sticked}><b>#STICKED_TOPIC_PREFIX#:</b>&nbsp;<{/if}>
		  <a href="<{$me.path}>/topic/tid_<{$topic->tid}>/last_<{$topic->lastupdate}>/cmpage_<{$topic->pages}>/cmperpage_<{Forum_Topic::FORUM_MESSAGES_ON_PAGE}>/"><{$topic->title}></a>
		 <{if !empty($topic->descr)}>
		  <div class="topic_descr"><{$topic->descr}></div>
		 <{/if}>
		 <{if $topic->isNeedPager()}>
		  <div class="topic_pages">#TOPIC_PAGES#:
		   <img src="<{$theme.mimages}>/pager.gif">
		   <{foreach item=page from=$topic->getPager()}>
		    <{if $page == '0'}> ...
		    <{else}>
		    	<a href="<{$me.path}>/topic/tid_<{$topic->tid}>/last_<{$topic->lastupdate}>/cmpage_<{$page}>/cmperpage_<{Forum_Topic::FORUM_MESSAGES_ON_PAGE}>/"><{$page}></a>
		    <{/if}>
		   <{/foreach}>
		  </div>
		 <{/if}>
		</td>
		<td class="topic_author">
		 <a onclick='return D.modules.users.show_user_page("<{$topic->uid}>");' class="first_poster siteuser" href="<{$me.www}>/users/show/<{$topic->uid}>/" title="<{$topic->username}>"><{$topic->username|left:25}></a></td>
		<td class="topic_messages"><{$topic->messages}></td>
		<td class="topic_readed"><{$topic->readed}></td>
		<td class="topic_last_update">
			<span class="topic_update_time"><{$topic->lastupdate|convert_time}></span>
			<br>#POSTED_BY# <a class="topic_updater" href="<{$me.www}>/users/show/<{$topic->lastuid}>/"><{$topic->lastusername|left:25}></a></td>
	</tr>
	</tbody>
<{/foreach}>
</table>
<div class="forum_page_select">
<{pager total=$list->totalpages current=$list->page url=$smarty.capture.page_link}>
</div>


<div class="forum_section_select">
#FORUM_CURRENT_SECTION#:
<form method="post" action="<{$me.path}>/section/">
<select name="sid" onchange='document.location.href="<{$me.path}>/section/sid_" + this.value + "/";'>
<{Forums::AllSectionsTree($t.section->sid)}>
</select>
<input type="submit" class="submit submit_ok" value="#GOTO#">
</form>
</div>