<form method="post" action="<{$run.me}>/delivery.update-delivery/">
	<input type="hidden" name="did" value="<{$delivery->did}>">
	<table class="cms_list">
		<thead>
			<tr>
				<th>Заголовок</th>
				<th>Значение</th>
			</tr>
		</thead>
		<{formline title='Название' name='name' value=$delivery->name}>
		<{formline type='select' title='Подписчики' showfield='name' name='lid' value=$delivery->lid list=Notify_Delivery_Lists::find()}>
		<{formline type='select' title='Тип' name='mode' value=$delivery->mode list=Notify_Delivery::getModes()}>
		<{formline type='textarea' title='Сообщение' name='msg' value=$delivery->msg}>
		<{formline type='save'}>
	</table>
</form>