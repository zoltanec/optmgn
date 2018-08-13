<span id="parent_dir"><{$dir->pwd}></span>
<{foreach item=file from=$dir->lsdir()}>
		<{if $file->filename!=".."}>
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
		<{/if}>
<{/foreach}>