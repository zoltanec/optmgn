<script type="text/javascript">
$(document).ready(function(){
	$("#browser").treeview({
			persist: "location",
			collapsed: true,
			unique: true
	});

	$("div.file").bind('click',select);
	$("div.file").bind('mouseover', show_preview);
	$("div.file").bind('mouseout', hide_preview);
	$("#control a").bind('click', action);

	function select(){
		if($(this).hasClass("fileselect"))
		$(this).removeClass("fileselect");
		else $(this).addClass("fileselect");
	}
	function show_preview(){
		if($(this).hasClass('jpg')||$(this).hasClass('png')||$(this).hasClass('gif')){
			$(this).children("img.preview").show();
			$(this).children("img.preview").css({'top':'-155px', 'left':'-20px'});
		}
	}
	function hide_preview(){
	    if($(this).hasClass('jpg')||$(this).hasClass('png')||$(this).hasClass('gif'))
	    	$(this).children("img.preview").hide();
	}

	function action(){
		if($(this).attr("id")=="selectall") {
		    $(".file").addClass("fileselect");
		} else if($(this).attr("id")=="deselectall") {
		    $(".file").removeClass("fileselect");
		} else {
		    var url=$(this).attr("href");
		    var file=new Array();
		    var dir=$("#parent_dir").html();
		    $("div.fileselect").each(function(){
				file[file.length]=dir+'/'+$(this).children("#filename").html();
			});
		    $.post(url, { 'file': file, 'dir': dir }, loadContent);
		}
		return false;
	}
	$('a.lsfiles').click(function(){
	    var url=$(this).attr("href");
	    $.post(url, loadContent);
	    return false;
	});
	$("#adding_files form").submit(function(){
		var url=$(this).attr("action");
		var file=$("input[name=new_file]").val();
		var dir=$("input[name=current_dir]").val();
		$.post(url,{'file': file, 'dir': dir},loadContent);
		return false;
	});
	function loadContent(data){
		$("div#view").html(data);
		$("div.file").bind('click',select);
		$("div.file").bind('mouseover', show_preview);
		$("div.file").bind('mouseout', hide_preview);
		$("input[name=current_dir]").attr('value',$("#parent_dir").html());
}
});
</script>
<h2>Управление файлами</h2>
<div id="control">
		<a id="selectall" href="#">Выделить все</a>
		<a id="deselectall" href="#">Снять выделение</a>
		<a id="deletefiles" href="<{$run.me}>/delete-file/">#DELETE#</a>
		<a id="edit" href="<{$t.run.me}>/edit-file">#EDIT#</a>
</div>
<div id="adding_files">
	<form action="<{$t.run.me}>/add-dir" method="post">
		<input type="hidden" name="current_dir" value="<{$dir->pwd}>" />
		<input type="text" name="new_file" value="Новая директория" />
		<input type="submit" class="submit_add" value="#ADD#"/>
	</form>
	<form action="<{$t.run.me}>/add-file" enctype="multipart/form-data" method="post">
		<input type="hidden" name="current_dir" value="<{$dir->pwd}>" />
		<input type="file" name="new_file" />
		<input type="submit" class="submit_add" value="#ADD#"/>
	</form>
</div>
<div id="tree">
	<ul id="browser" class="filetree"><li><span class="root"><a class="root" id="0">Файлы</a></span></li>
		<{$dir->get_tree()}>
	</ul>
</div>

<div id="view">
	<span id="parent_dir"><{$dir->pwd}></span>
	<{foreach item=file from=$dir->lsdir()}>
		<div class="file <{$file->ext}> <{if $file->filetype=='dir'}>dir<{/if}>">
		<span id="filename"><{$file->filename}></span><br />
		<span class="grey"><{$file->owner.name}> <{$file->group.name}></span><br />
		<span class="grey"><{$file->perms}></span><br />
		<{if $file->filetype!='dir'}>
		<span class="grey"><{$file->filesize}></span><br />
		<{/if}>
		<{if $file->ext=='jpg' || $file->ext=='png' || $file->ext=='gif'}>
			<img class="preview" src="<{$file->url}>" />
		<{/if}>
		</div>
	<{/foreach}>
</div>
<style type="text/css">

</style>