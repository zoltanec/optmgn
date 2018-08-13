<script type="text/javascript">
$(document).ready(function() {
	$('.reload_i18n').click(function() {
		www = $(this).attr('href');
		$.get(www, function(answer) {
			if(answer == 'OK') {
				coreJS.notify("Файлы локализации успешно обновлены");
			} else {
				alert(answer);
			}
		});
		return false;
	});
});
</script>
<h1>Список доступных модулей системы</h1>

<table class="cms_list">
	<thead>
		<tr>
			<th>N</th>
			<th>#CORE_MODULE_CODE#</th>
			<th>#CORE_MODULE_VERSION#</th>
			<th>#CORE_MODULE_NAMES#</th>
			<th>#CORE_MODULE_DESCR#</th>
			<th colspan="5">#FUNCTIONS#</th>
		</tr>
	</thead>
 <{foreach item=module from=$modules_list}>
 	<tbody>
  		<tr>
   			<td class="num"><{$module.num}></td>
   			<td><{$module.code}></td>
   			<td><{$module.info.version}></td>
   			<td><{$module.info.name}></td>
   			<td><{$module.info.descr}></td>
   			<td><a class="reload_i18n"     href="<{$run.me}>/load-i18n-file/module_<{$module.code}>/">Обновить локализацию</a></td>
   			<td><a class="reload_settings" href="<{$run.me}>/load-settings/<{$module.code}>/">Загрузить настройки</a></td>
   			<td><a class="reload_sql"      href="<{$run.me}>/load-sql-file/<{$module.code}>/">Загрузить SQL</a></td>
   			<td><a class="reload_js"       href="<{$run.me}>/load-jscripts/<{$module.code}>/">Загрузить JS</a></td>
   			<td><a class="reload_theme"    href="<{$run.me}>/load-theme/<{$module.code}>/">Загрузить theme</a></td>

  		</tr>
  	</tbody>
 <{/foreach}>
</table>