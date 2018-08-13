<h2>Настройки профиля</h2>
		<{if $req->status=='PASSWD_ERROR'}>
		<div class="error">Извините, но пароли не совпадают</div>
		<{/if}>
		<form id="profile" action="<{$me.www}>/store/update-profile" method="post">
			<div id="modal_basket_input">
				<div>Имя</div>
				<input type="text" name="fullname" value="<{$user->store->fullname}>" />
				<div>
					Номер телефона <span>&nbsp;Обязательно!</span>
				</div>
				<input type="text" name="username" value="<{$user->username}>"/>
				<div>Адрес</div>
				<textarea name="address"><{$user->store->address}></textarea>
				<div>Новый пароль</div>
				<input type="text" name="password" />
				<div>Повторите новый пароль</div>
				<input type="text" name="password_confirm" />
			</div>
			<br />
			<div onclick="$('form#profile').submit();" class="submit_order button buy_button_mini">
				<div>
					<div class="button_small_text">Сохранить</div>
				</div>
			</div>
		</form>
