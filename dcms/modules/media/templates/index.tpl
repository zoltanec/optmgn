<h1 class="media_top"><{$root->dirname}></h1>
<table class="media_dirs">
<{foreach item=dir from=$root->subdirs}>
 <tbody>
    <tr>
        <td rowspan="3"><img width="130" src="<{$me.my_content}>/dir_preview/<{$dir->dirid}>.png"></td>
        <td class="dirname"><a href="<{$me.path}>/ls/dir_<{$dir->dirid}>/"><{$dir->dirname}></a></td></tr>
    <tr><td class="dirdescr"><{$dir->descr}></td></tr>
    <tr><td class="subdirs">
    <{if sizeof($dir->subdirs) > 0}>
    	<b>Разделы:</b>
        <{foreach item=subdir from=$dir->subdirs}>
            <a href="<{$me.path}>/ls/dir_<{$subdir->dirid}>/"><{$subdir->dirname}></a>
        <{/foreach}>
    <{/if}>
    </td>
  </tr>
 </tbody>
<{/foreach}>
</table>