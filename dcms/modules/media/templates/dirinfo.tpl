<{if D::$config->breadcrumbs==true}>
	<div class="breadcrumbs">
		<a href="<{$me.www}>" title="Главная">Главная</a> <span>></span>
		<{foreach item=breadcrumb from=$tpl->getBreadCrumbs()}>
			<a href="<{$breadcrumb.link}>" title="<{$breadcrumb.name}>"><{$breadcrumb.name}></a> <span>></span>
		<{/foreach}>
		<b><{$current_dir->dirname}></b>
	</div>
<{/if}>


<h1 class="fullhead"><{$current_dir->dirname}></h1>
<table class="cur_dir">
 <tr>
  <td class="image" rowspan="3"><img width="130" src="<{$me.my_content}>/dir_preview/<{$current_dir->dirid}>.png"></td>
  <td class="descr"><b>Примечание</b><br>
  <{$current_dir->descr}></td>
 </tr>
</table>