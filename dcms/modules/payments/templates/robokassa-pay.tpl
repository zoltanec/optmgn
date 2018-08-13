<form id="roboform" action='https://merchant.roboxchange.com/Index.aspx' method=POST>
      <input type=hidden name=MrchLogin value="<{$mrh_login}>">
      <input type=hidden name=OutSum value="<{$out_summ}>">
      <input type=hidden name=InvId value="<{$inv_id}>">
      <input type=hidden name=Desc value="<{$inv_desc}>">
      <input type=hidden name=SignatureValue value="<{$crc}>">
      <input type=hidden name=IncCurrLabel value="<{$in_curr}>">
      <input type=hidden name=Culture value="<{$culture}>">
</form>
Redirecting to payment gateway...
<script type="text/javascript">
document.getElementById('roboform').submit();
</script>