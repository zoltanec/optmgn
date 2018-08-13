<h2>Настройки модуля обратной связи</h2>

<form method="post" action="<{$t.run.me}>/update-feedback">
<table class="form">
	<tr>
		<td>Активность поля "телефон (факс)"</td>
		<td><input type="checkbox" name="phone" value="1" <{if $conf->phone==1}> checked<{/if}>></td>
	</tr>

	<tr>
		<td>Активность поля "компания"</td>
		<td><input type="checkbox" name="company" <{if $conf->company==1}> checked<{/if}>></td>
	</tr>

	<tr>
		<td>Активность поля страна</td>
		<td><input type="checkbox" name="country" value="1" <{if $conf->country==1}> checked<{/if}>></td>
	</tr>

	<tr>
		<td>Активность поля регион и город</td>
		<td><input type="checkbox" name="region" value="1" <{if $conf->region==1}> checked<{/if}>></td>
	</tr>
	<{if D::getModulePath('contacts')}>
	<tr>
		<td>Активность поля "департамент"</td>
		<td><input type="checkbox" name="depart" value="1" <{if $conf->depart==1}> checked<{/if}>></td>
	</tr>
	<{/if}>
	<tr>
		<td>Активность поля "причина обращения?"</td>
		<td><input type="checkbox" name="cause" value="1" <{if $conf->cause==1}> checked<{/if}>></td>
	</tr>

	<tr>
		<td>Подписка на новости</td>
		<td><input type="checkbox" name="subscribe" value="1" <{if $conf->subscribe==1}> checked<{/if}>></td>
	</tr>
<tr>
		<td>Активность поля "как вы узнали о нас?</td>
		<td><input type="checkbox" name="know" value="1" <{if $conf->know==1}> checked<{/if}>></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" class="submit_update" value="#SAVE#"></td>
	</tr>
	</table>
	</form>
	<h3>Редактирование вариантов ответа на вопрос "Причина обращения?"</h3>
	<table class="list">
	<tr><td><b>Добавить новый вариант ответа</b></td><td></td></tr>
	<tr>
  <td >
     <form method="post" action="<{$run.me}>/add-cause/">
    <input type="text" name="cause" value="Новый вариант ответа">
    <input type="submit" class="submit_add" value="#ADD#">
   </form>
  </td>
  <td></td>
 </tr>
	<tr>
		<td><b>Ответ</b></td>
		<td><b>Функции</b></td>
	</tr>
	<{foreach item=cause from=$conf->getCauses()}>
	<tr>
		<td><form method="post" action="<{$t.run.me}>/update-cause/">
 <input type="hidden" name="csid" value="<{$cause.csid}>">
 <input type="text" name ="cause" value="<{$cause.csname}>" />
 <input type="submit" class="submit_update" value="#SAVE#">
 </form></td>
		<td><a class="delete_link" href="<{$run.me}>/delete-cause/csid_<{$cause.csid}>/">#DELETE#</a></td>
	</tr>
	<{/foreach}>
</table>
	<h3>Редактирование вариантов ответа на вопрос "Как вы узнали о нас?"</h3>
	<table class="list">
	<tr><td><b>Добавить новый вариант ответа</b></td><td></td></tr>
	<tr>
  <td >
     <form method="post" action="<{$run.me}>/add-reply/">
    <input type="text" name="reply" value="Новый вариант ответа">
    <input type="submit" class="submit_add" value="#ADD#">
   </form>
  </td>
  <td></td>
 </tr>
	<tr>
		<td><b>Ответ</b></td>
		<td><b>Функции</b></td>
	</tr>
	<{foreach item=reply from=$conf->getReply()}>
	<tr>
		<td><form method="post" action="<{$t.run.me}>/update-reply/">
 <input type="hidden" name="rid" value="<{$reply.rid}>">
 <input type="text" name ="reply" value="<{$reply.rname}>" />
 <input type="submit" class="submit_update" value="#SAVE#">
 </form></td>
		<td><a class="delete_link" href="<{$run.me}>/delete-reply/rid_<{$reply.rid}>/">#DELETE#</a></td>
	</tr>
	<{/foreach}>
</table>