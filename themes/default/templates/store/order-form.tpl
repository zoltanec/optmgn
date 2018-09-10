<div class="container l-order">
	<div class="row "><div class="col-item"><h1 class="title-h1">Оформление заказа</h1></div></div>
	<form action="<{$me.www}>/store/submit-order" method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="col-item">
				<div class="l-order__panel panel" id="sale_order_props">
					<div class="form-group order-props__row-form">
						<div class="order-props__col-label">
							<label class="label label_inline required">Ф.И.О.&nbsp;/&nbsp;Компания</label>
						</div>
						<div class="order-props__col-input">
							<input type="text" class="input required 
							<{if isset(D::$session['errorFilled']) && in_array('order_name', D::$session['errorFilled'])}>class="error"<{/if}>" 
							value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['order_name']}><{/if}>" 
							name="order_name">
						</div>
					</div>
					<div class="form-group order-props__row-form">
						<div class="order-props__col-label">
							<label class="label label_inline required">Телефон</label>
						</div>
						<div class="order-props__col-input">
							<input type="text" class="input required 
							<{if isset(D::$session['errorFilled']) && in_array('order_phone', D::$session['errorFilled'])}>class="error"<{/if}>" 
							value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['order_phone']}><{/if}>" 
							name="order_phone">
						</div>
					</div>
					<div class="form-group order-props__row-form">
						<div class="order-props__col-label">
							<label class="label label_inline required">Email</label>
						</div>
						<div class="order-props__col-input">
							<input type="text" class="input required 
							<{if isset(D::$session['errorFilled']) && in_array('order_email', D::$session['errorFilled'])}>class="error"<{/if}>" 
							value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['order_email']}><{/if}>" 
							name="order_email">
						</div>
					</div>
					<div class="form-group order-props__row-form">
						<div class="order-props__col-label">
							<label class="label label_inline required">Адрес</label>
						</div>
						<div class="order-props__col-input">
							<input type="text" class="input required 
							<{if isset(D::$session['errorFilled']) && in_array('order_address', D::$session['errorFilled'])}>class="error"<{/if}>" 
							value="<{if isset(D::$session['formFilled'])}><{D::$session['formFilled']['order_address']}><{/if}>" 
							name="order_address">
						</div>
					</div>
				</div>
			</div>								
		</div>
		<div class="row l-order__row-total">
			<div class="col-item">
				<div class="order-total">
					<table>
						<tbody>
							<tr>
								<td class="order-total__td content">Товаров на:</td>
								<td class="order-total__td">
									<div class="price">
										<span class="price__value">11&nbsp;690.38</span> руб.
									</div>
								</td>
							</tr>
							<tr>
								<td class="order-total__td content">
									<div class="h6">Итого:</div>
								</td>
								<td class="order-total__td">
									<div class="price">
										<span class="price__value"><{$cartTotal.total_cost}></span> руб.
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="btn-line btn-line_right btn-line_border">
			<input type="submit" class="btn btn_primary btn_size_m" value="Оформить заказ">
		</div>
	</form>
</div>
