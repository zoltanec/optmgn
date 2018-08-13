<{include tpl=$tpl file="dit:media;dirinfo.tpl"}>

<{if sizeof($current_dir->subdirs) > 0}>
	<div class="media_list_div">
	<{foreach item=dir from=$current_dir->subdirs}>
		<div class="media_list_element" title2="<{$dir->dirid}>" title="Открыть в новой вкладке/окне">
      		<div class="media_open_in_newtab"></div>
      			<img class="media_element_logo" src="<{$me.my_content}>/dir_preview/<{$dir->dirid}>.png" />
      			<a href="<{$me.path}>/ls/dir_<{$dir->dirid}>/"><{$dir->dirname}></a><br>
     			<span><{$dir->pictures_count}> фото <{$dir->videos_count}> видео</span>
      	</div>
     <{/foreach}>
     </div>
<{/if}>

<div class="media_dir_files">
<{foreach item=file from=$current_dir->files}>
	<div class="media_ls_file_preview media_ls_file_preview_<{$file->type}>" data-fileid="<{$file->fileid}>" style="background-image: url('<{$me.my_content}>/thumbs/<{$current_dir->dirid}>/<{$file->fileid}>');">
		<div></div>
	</div>
<{/foreach}>
</div>
<script type='text/javascript'>
$(document).ready(function() {
	$('.media_list_element').each(function() {
		var url = siteVars.www + '/media/ls/dir_' + $(this).attr('title2');
		$(this).find('.media_element_logo, .media_element_name').click(function() {
			document.location.href = url;
		});
		$(this).find('.media_open_in_newtab').click(function() {
			window.open(url);
		});
	});

	$('.media_ls_file_preview').click(function() {
		var fileid = $(this).attr('data-fileid');
		var dirid = '<{$current_dir->dirid}>';
		//alert(dirid);
		//alert('<{$me.path}>/show/' + dirid + '/' + fileid);
		$.post('<{$me.path}>/show', {'dirid' : dirid, 'fileid' : fileid, 'render_full' : 1} , function(answer) {
			UI.popup(answer, {'classes': 'media_view'});
		});
	});
});
</script>