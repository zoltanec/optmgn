<table>
<form action='https://merchant.webmoney.ru/lmi/payment.asp' method=post>
     <tbody class="ps_wm">
      <tr class="p_header">
      	<td rowspan="2"><img alt="webmoney" src="<{$theme.images}>/paysystems/webmoney_img.png"></td>
      	<td colspan="3" class="p_name">WebMoney</td>
      </tr>

      <tr>
    	  <td>#PAYMENT_AMOUNT#:
		  <br>
		  </td>
      	  <td>
      	  <input type="hidden" name="LMI_PAYMENT_NO" value="<{$user->cid}>">
      	  <input type="hidden" name="LMI_PAYMENT_DESC" value="Account <{$user->cid}>">
      	  <input type="hidden" name="LMI_SUCCESS_URL" value="<{$me.path}>/good-pay/">
      	  <input type="hidden" name="LMI_FAIL_URL" value="<{$me.path}>/bad-pay/">
      	  <input class="paysum" type="text" name="LMI_PAYMENT_AMOUNT" value="<{$req->float('sum')}>">
      	    <select name=LMI_PAYEE_PURSE>
      	    <option value="<{$purse.WMZ}>">WMZ
      	    <option value="<{$purse.WME}>">WME
      	    <option value="<{$purse.WMR}>">WMR
      	    </select>
      	  </td>
      	  <td>
      		<input type="submit" class="submit" value="#PAY_SUBMIT#">
          </td>
      </tr>
    </tbody>
    </form>
 </table>