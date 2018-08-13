<div class="users_avatar_top_toolbar">
<a href="#"  onclick='return UI.popup_close();'><img src="<{$theme.mimages}>/modal_window_close.png"></a>
</div>
<div class="users_all_avatars">
<{foreach item=dir from=$images}>
<div class="users_avatars_dir_header"><{$dir.name}></div>
<div class="users_avatars_dir">
	<{foreach item=image from=$dir.files}>
	<table class="single_avatar" title="<{$image.name}>">
 		<tr><td><img src="<{$me.my_content}>/avatars/defaults/<{$image.name}>"></td></tr>
	</table>
	<{/foreach}>
</div>
<{/foreach}>
</div>