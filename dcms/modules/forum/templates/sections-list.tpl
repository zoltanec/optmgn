<{if sizeof($forum->subsections) > 0}>
<table class="sections">
<{foreach item=category from=$forum->subsections}>
	<tr class="category">
		<td colspan="5"><{$category.name}></td>
	</tr>
	<tr class="category_legend">
		<td></td>
		<td>#FORUM_SECTION_NAME#</td>
		<td>#FORUM_SECTION_TOPICS#</td>
		<td>#TOTAL_MESSAGES#</td>
		<td>#LAST_MESSAGE#</td>
	</tr>
	<{foreach item=section from=$category.sections}>
	<tbody class="section">
		<tr>
			<td class="section_icon" rowspan="3"><a href="<{$me.path}>/section/sid_<{$section->sid}>/last<{$section->date}>/">&nbsp;</a></td>
			<td class="section_name"><a href="<{$me.path}>/section/sid_<{$section->sid}>/last<{$section->date}>/"><{$section->name}></a></td>
			<td rowspan="3" class="section_topics"><{$section->topics}></td>
			<td rowspan="3" class="section_messages"><{$section->messages}></td>
			<td rowspan="3" class="section_last">
			<{if $section->lastupdate != 0}>
			<a class="topic_last" href="<{$me.path}>/topic/tid_<{$section->lasttid}>/cmpage_last/#commentN<{$section->lastcomid}>"><{$section->lasttitle}></a><br>
			<span class="topic_update_time"><{$section->lastupdate|convert_time}></span>
			<br>#POSTED_BY# <a class="topic_updater siteuser" title="<{$section->lastusername}>" onclick='return D.modules.users.show_user_page("<{$section->lastuid}>");' href="<{$me.www}>/users/show/<{$section->lastuid}>/"><{$section->lastusername|left:25}></a><{/if}>
			</td>
		</tr>
		<tr>
			<td class="section_descr"><{$section->descr}></td>
		</tr>
		<tr>
			<td class="section_moderators">

			</td>
		</tr>
	</tbody>
	<{/foreach}>
<{/foreach}>
</table>
<{/if}>