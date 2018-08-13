<div class="pathtree">
 <img class="forumlogo" src="<{$theme.mimages}>/forumlogo.png">
 <span class="section_full_path">
<{foreach item=parent_section from=$section->pathtree}>
	<{if $parent_section.sid != 1}>
		<a href="<{$me.path}>/section/sid_<{$parent_section.sid}>/"><{$parent_section.name}></a>
	<{else}>
		<a href="<{$me.path}>/"><{$parent_section.name}></a>
	<{/if}>
	&rarr;
<{/foreach}>
<a href="<{$me.path}>/section/sid_<{$section->sid}>/"><{$section->name}></a>
</span>
<{if !empty($section->descr)}>
	<div class="descr"><{$section->descr}></div>
<{/if}>
<{if sizeof($section->moderators) > 0}>
<div class="moderators_list">
  <b>#MODERATORS#:</b>
   <{foreach item=moderator from=$section->moderators}>
    <a class="siteuser" href="<{$me.www}>/users/show/<{$moderator.uid}>/"><{$moderator.username}></a>&nbsp;
   <{/foreach}>
 </div>
<{/if}>
</div>