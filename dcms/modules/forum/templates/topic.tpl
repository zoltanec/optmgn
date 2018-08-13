<{include section=$t.topic->section file='dit:forum;section-path'}>

<h2 class="fullhead"><{$t.topic->title}></h2>

<table class="first_message">
	<tr class="topic_head">
	 <td class="topic_username"><a href="<{$me.www}>/users/show/uid_<{$t.topic->uid}>/"><{$t.topic->username}></a></td>
	 <td class="topic_start_date"><{$t.topic->date}></td>
	</tr>
	<tr>
	 <td class="topic_avatar"><{if !empty($t.topic->avatar)}>
            <img src="<{$me.content}>/users/avatars/<{$t.topic->avatar}>">
        <{else}>
            <img src="<{$me.content}>/users/avatars/default.png">
        <{/if}>
     </td>
    	<td rowspan="4" class="topic_content">
    	 <{if $user}>
    	  <div class="topic_tools">
    	  <{if $user->uid == $t.topic->uid or $user->reqRights('edit/forum/forumtopic/')}>
    	    <a class="submit submit_ok" href="<{$me.path}>/edit-topic/tid_<{$t.topic->tid}>/">#EDIT#</a>
    	  <{/if}>

    	  <{if $user->reqRight('edit/forum/forumtopic')}>
    	   <a class="submit submit_delete" href="<{$me.path}>/delete-topic/tid_<{$t.topic->tid}>/">#DELETE#</a>
    	  <{/if}>
    	  </div>
    	 <{/if}>
    	   <{$t.topic->html}>
    	    <div class="cm_sign">
	          <{$t.topic->sign}>
	        </div>
    	</td>
    </tr>
     <tr><td class="topic_user_messages">#MESSAGES#: <b><{$t.topic->messages}></b></td></tr>
     <tr><td class="topic_user_from">#USER_FROM#: <{$t.topic->user_from}></td></tr>
     <tr><td class="topic_user_group">#USER_GROUP#: <b><{$t.topic->group_name}></b></td></tr>
</table>

<{include object_id=$t.topic->object_id() readonly=$t.topic->readonly file="comments;comments"}>
