<h2>Управление основными настройками ядра</h2>

<table class="cms_admin_settings">
	<tr>
		<td></td>
		<td><a href="<{$run.me}>/i18n.view-lng-messages/">Управление локализацией</a></td>
	</tr>

	<tr>
		<td>Выгрузить языковой файл:</td>
		<td>Модуль:
			<form method="post" action="<{$run.me}>/i18n.export-i18n/">
			<select name="target_module">
				<{foreach item=module from=D::getModulesList()}>
					<option value="<{$module.code}>"><{$module.code}>
				<{/foreach}>
			</select>

			Язык:
			<select name="target_lang">
				<{foreach item=lang from=$config->languages}>
					<option value="<{$lang}>"><{$lang}>
				<{/foreach}>
			</select>
			<input type="submit" value="Export"></form>
		</td>
	</tr>
</table>