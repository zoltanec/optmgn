<div class="modal_window_wrap">
	<div class="modal_window" id="modal_basket_second">
		<div class="modal_close"></div>
<{if $status=="OK"}>
		<h3>Уведомление о приеме заказа</h3>
		<p><span class="green bold">Ваш заказ принят</span></p>
		<p>В течении 10 минут наш оператор перезвонит вам для подтверждения заказа.</p>
<{elseif $status=="REG_USER"}>
		<h3>Уведомление о приеме заказа</h3>
		<p><span class="green bold">Ваш заказ принят</span></p>
		<p>В течении 10 минут наш оператор перезвонит вам для подтверждения заказа.</p>
		<div class="clear"></div>
		<p>Вы автоматически зарегистрированы, ваш логин номер вашего телефона <b><{$user->username}></b>, 
		пароль мы выслали вам по смс.</p>
		<p>Ваше имя, номер телефона, адрес сохранены, вы можете изменить в <a href="<{$me.www}>/store/profile">личном кабинете</a></p>
<{else}>
		<h3>Ошибка!</h3><br />
		<b>Ваша корзина пуста!</b>
<{/if}>
		<div class="close button buy_button_mini">
						<div>
							<div class="button_small_text">Закрыть</div>
						</div>
		</div>
	</div>
</div>