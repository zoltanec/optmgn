<html>
	<body>
	Оплата через систему RBK Money...
		<form id="form" action="https://rbkmoney.ru/acceptpurchase.aspx" name="pay" method="POST">
			<input type="hidden" name="eshopId" value="<{$config['payments.rbk.shopid']}>">
			<input type="hidden" name="orderId" value="<{$order->ordid}>">
			<input type="hidden" name="serviceName" value="<{$order->object->name}>">
			<input type="hidden" name="recipientAmount" value="<{$order->sum}>">
			<input type="hidden" name="recipientCurrency" value="RUR">
			<input type="hidden" name="user_email" value="">
			<input type="hidden" name="successUrl" value="<{$me.path}>/completed/">
			<input type="hidden" name="failUrl" value="<{$me.path}>/broken/">
			<input type="hidden" name="userField_1" value="value_1">
			<input type="hidden" name="userField_2" value="value_2">
			<input type="submit" name="button" value="Продолжить">
		</form>
		<script type="text/javascript">
		document.getElementById('form').submit();
		</script>
	</body>
</html>