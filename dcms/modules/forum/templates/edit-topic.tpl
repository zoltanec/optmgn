<{include section=$topic->section file='section-path'}>

<h2 class="fullhead">#FORUM_TOPIC_EDIT#</h2>
<form  action="<{$me.path}>/update-topic/" method="post">
<input type="hidden" name="tid" value="<{$t.topic->tid}>">
<table class="forum_edit_topic_form">
 <tbody>
	<tr class="forum_edit_topic_title">
		<td><b>#FORUM_TOPIC_TITLE#:</b></td>
		<td><input type="text" size="70" id="title" name="title" value="<{$t.topic->title}>"></td>
	</tr>
	<tr class="forum_edit_topic_descr">
	    <td><b>#FORUM_TOPIC_DESCRIPTION#:</b></td>
	    <td><input type="text" size="70" name="descr" value="<{$t.topic->descr}>"></td>
	</tr>
	<tr>
		<td colspan="2">
			<{include file='dit:core;text-editor' content=$topic->content}>
		</td>
	</tr>
	<tr class="forum_edit_topic_controls">
		<td colspan="2">
		 <button class="submit_button" type="submit"><span>#FORUM_POST_TOPIC#</span></button>
		</td>
	</tr>
	</tbody>
</table>
</form>