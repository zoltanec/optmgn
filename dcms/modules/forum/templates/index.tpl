
<{assign var="mainforum" value=D_Core_Factory::Forum_Section(1)}>
<div class="forum_logo"></div>
<br>
<{include forum=$mainforum file='dit:forum;sections-list.tpl'}>


<br>
<h2 class="fullhead forum_stat_head">#FORUM_STATISTICS#</h2>

<table class="forum_index_stat">
 <tr>
  <td rowspan="3" class="stat_image"><img src="<{$theme.mimages}>/stat.png"></td>
  <td>#FORUM_SECTION_TOPICS#: <{$mainforum->stat.topics}></td><td>#TOTAL_MESSAGES#: <{$mainforum->stat.messages}></td></tr>
 <tr><td>#LAST_MESSAGE#: </td><td><a href="<{$me.path}>/topic/tid_<{$mainforum->stat.lasttid}>/"><{$mainforum->stat.lasttitle}></a>
 #POSTED_BY# <a class="siteuser" href="<{$me.www}>/users/show/<{$mainforum->stat.lastuid}>/"><{$mainforum->stat.lastusername|left:25}></a> <{$mainforum->stat.lastupdate|convert_time}></td>
 <tr><td>#USERS_ON_FORUM#:</td>
  <td>
  <{assign var='stat' value=dOnlineStat::WhoIsOnline('forum')}>
   <{foreach item=siteuser from=$stat.users}>
     <a class="siteuser" href="<{$me.www}>/users/show/<{$siteuser.uid}>/"><{$siteuser.username|left:"25"}></a>,
   <{/foreach}>
 <{$stat.guests}> #GUESTS_COUNT#
 </td>
</tr>
</table>