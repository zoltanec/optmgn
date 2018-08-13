<h1>Просмотр сообщения</h1>
<table class="cms_form">
	<tr>
		<td><b>Сообщение от</b></td>
		<td><{$msg->name}></td>
	</tr>
	<tr>
		<td><b>E-mail</b></td>
		<td><{$msg->email}></td>
	</tr>
	<{if $conf->phone==1}><tr>
		<td><b>Телефон(факс)</b></td>
		<td><{$msg->phone}></td>
	</tr>
	<{/if}>
	<{if $conf->company==1}><tr>
		<td><b>Компания</b></td>
		<td><{$msg->company}></td>
	</tr>
	<{/if}>
	<{if $conf->country==1}><tr>
		<td><b>Страна</b></td>
		<td><{$msg->countryname}></td>
	</tr>
	<{/if}>
	<{if $conf->region==1}><tr>
		<td><b>Регион</b></td>
		<td><{$msg->regname}></td>
	</tr>
	<tr>
		<td><b>Город</b></td>
		<td><{$msg->cityname}></td>
	</tr>
	<{/if}>
	<{if $conf->depart==1}><tr>
		<td><b>Департамент</b></td>
		<td><{$msg->dep_name}></td>
	</tr>
	<{/if}>
	<{if $conf->cause==1}><tr>
		<td><b>Причина обращения?</b></td>
		<td><{$msg->csname}></td>
	</tr>
	<{/if}>
	<{if $conf->know==1}><tr>
		<td><b>Как вы узнали о нас</b></td>
		<td><{$msg->rname}></td>
	</tr>
	<{/if}>
	<{if $conf->subscribe==1}><tr>
		<td><b>Подписка на новости:</b></td>
		<td><{if $msg->subscribe==1}>
		активна<{else}>неактивна<{/if}></td>
	</tr>
	<{/if}>
	<tr>
		<td><b>Сообщение:</b></td>
		<td><{$msg->content}></td>
	</tr>
</table>