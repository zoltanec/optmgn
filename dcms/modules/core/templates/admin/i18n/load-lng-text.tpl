<h2>Загрузка локализации</h2>

<form method="post" action="<{$run.me}>/i18n.make-lng-load/">
<table class="cms_form">
	<{formline type='header'}>
	<{formblock title='Язык'}>
		<select name="lang">
			<{foreach item=lang from=$config->languages}>
			<option value="<{$lang}>"><{$lang}>
			<{/foreach}>
		</select>
	<{/formblock}>

	<{formblock title='Кодировка'}>
		<select name="enc">
			<option value="none">None
			<option value="base64">BASE-64
		</select>
	<{/formblock}>

	<{formblock title='Контент'}>
		<textarea name="content" cols="90" rows="50"></textarea>
	<{/formblock}>
	<{formline type='save'}>

</table>

</form>