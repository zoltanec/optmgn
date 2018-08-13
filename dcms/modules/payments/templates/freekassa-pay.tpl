<html>
<body>
	<form method="get" id="forms" action="http://www.free-kassa.ru/merchant/cash.php">
		<input type="hidden" name="m" value="<{$config['payments.freekassa.merchant_id']}>">
		<input type="hidden" name="oa" value="<{$order->sum}>">
		<input type="hidden" name="s" value="<{$signature}>">
		<input type="hidden" name="o" value="<{$order->ordid}>">
		<input type="hidden" name="i" value="USD">
		Redirect to payment gateway...
	</form>
	<script type="text/javascript">
	document.getElementById('forms').submit();
	</script>
</body>
</html>