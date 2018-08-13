<{include file="dit:media;dirinfo.tpl" album=$file->parent}>
<div class="content_block">
<table class="media_content_main">
 <tr>
  <td class="media_content_left_block media_go_prev"></td>
  <td class="media_content_center_block media_go_next" id="media_content_container">
    <{include file='media;single-media-object'}>
  </td>
  <td class="media_content_right_block media_go_next"></td>
</tr>
</table>
</div>

<div id="test"></div>
<script type="text/javascript">
<{foreach item=dirfile from=$file->parent->files}>
D.modules.media.append_file_to_list({fileid: '<{$dirfile->fileid}>', object_id: '<{$dirfile->object_id}>'});
<{/foreach}>
D.modules.media.set_current_dir('<{$file->parentid}>');
D.modules.media.set_current_fileid('<{$file->fileid}>');
D.modules.media.bind_show_page();
$(document).ready(function() {
	return true;
	$('.media_slider').each(function() {
		var slider = $(this).find('.photo_previews').slider({'animation_time': 350, 'perclick' : 550, 'animation_steps' : 5, 'animate': 1,'width': 870});
		$(this).find('.move_left').bind('click', function() {
			slider.move(-1);
		});
		$(this).find('.move_right').bind('click', function() {
			slider.move(1);
		});
		mediaJS.setOnFileSelectHandler(function(file) {
			slider.move_to(file.fileid);
			//alert(file.fileid);
			$('.photo_preview_current').removeClass('photo_preview_current');
			$('[title2=' + file.fileid + ']').addClass('photo_preview_current');
		});
		mediaJS.setCurrentFile('<{$file->fileid}>');
		if(document.location.href.split('#').length == 2 ) {
			mediaJS.setRequiredFile(document.location.href.split('#')[1]);
		}
	});
	$('.media_file_preview').click(function(){
		var fileid = $(this).attr('data-fileid');
		return mediaJS.getMediaFile(fileid);
	});
});
</script>

<{include object_id=$file->object_id() file="comments;comments"}>