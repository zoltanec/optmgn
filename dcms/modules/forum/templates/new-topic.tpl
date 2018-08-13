<{include section=$t.section file='dit:forum;section-path'}>

<h2 class="fullhead">#FORUM_CREATE_NEW_TOPIC#</h2>

 <script type="text/javascript" src="<{$config.jscripts_path}>/tiny_mce/tiny_mce.js"></script>
 <script type="text/javascript">
    tinyMCE.init({
        theme_advanced_buttons1 : "bold,italic,underline, strikethrough, separator,justifyleft, justifycenter,justifyright,  justifyfull, separator,help",
        theme_advanced_buttons2: "",
        theme_advanced_buttons3: "",
        theme_advanced_buttons4: "",
    	theme_advanced_toolbar_location : "top",
    	theme : "advanced",
        mode : "exact",
       	plugins: "bbcode",
    	add_unload_trigger : false,
    	remove_linebreaks : false,
       	elements: "rich"});
    function toggleEditor(id) {
    	if (!tinyMCE.get(id))
   			tinyMCE.execCommand('mceAddControl', false, id);
    	else
    	   	tinyMCE.execCommand('mceRemoveControl', false, id);
   	}
   	function onSubmitTopic() {
   	   	if(document.getElementById('title').value.length == 0 ) {
   	   	   	alert("Вам необходимо указать и тему и содержимое.");
   	   	   	return false;
   	   	}
   	}
  </script>

 <form onsubmit='return onSubmitTopic();' action="<{$me.path}>/submit-topic/" method="post">
  <input type="hidden" name="sid" value="<{$t.section->sid}>">
<table class="forum_new_topic_form">
 <tbody>
	<tr class="forum_edit_topic_title">
		<td><b>#FORUM_TOPIC_TITLE#:</b></td>
		<td><input type="text" size="70" id="title" name="title" value="<{$preview.title}>"></td>
	</tr>
	<tr class="forum_edit_topic_descr">
	    <td><b>#FORUM_TOPIC_DESCRIPTION#:</b></td>
	    <td><input type="text" size="70" name="descr" value="<{$preview.descr}>"></td>
	</tr>
	<tr>
		<td colspan="2">
			<{include file='dit:core;text-editor' content=$t.preview.content}>
		</td>
	</tr>
	<tr class="forum_new_topic_controls">
		<td colspan="2">
		    <button type="submit" class="submit_button forum_submit_preview" name="preview-me"><span>#FORUM_TOPIC_PREVIEW#</span></button>
			<button type="submit" class="submit_button forum_submit_topic" name="post-me"><span>#FORUM_POST_TOPIC#</span></button>
		</td>
	</tr>
	</form>
	</tbody>
</table>

<{if isset($t.preview)}>
<h2 class="fullhead"><{$t.preview.title}></h2>

<table class="first_message">
	<tr>
	 <td><{if !empty($user->avatar)}>
            <img src="<{$me.content}>/users/avatars/<{$user->avatar}>">
        <{else}>
            <img src="<{$me.content}>/users/avatars/default.png">
        <{/if}>
     </td>
    	<td><{$t.preview.content|bbcode}></td>
    </tr>
</table>
<{/if}>
