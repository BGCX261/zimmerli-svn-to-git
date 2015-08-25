<?php
$FORMS = Array();

$FORMS['payment_block'] = <<<END
<form action="%submit_url%" method="post" id="payment_choose" onsubmit="return checkPaymentReceipt();">
	Выберите подходящий вам способ оплаты:
	<ul>
		%items%
	</ul>

	<p>
		<input type="submit" />
	</p>

	<script>
		function checkPaymentReceipt() {
			if (jQuery(':radio:checked','#payment_choose').attr('class') == 'receipt') {
				var url = "%submit_url%";
				var win = window.open("", "_blank", "width=710,height=620,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no");
				win.document.write("<html><head><" + "script" + ">location.href = '" + url + "?payment-id=" + jQuery(':radio:checked','#payment_choose').attr('value') + "'</" + "script" + "></head><body></body></html>");
				win.focus();
				return false;
			}
			return true;
		}
	</script>

</form>
END;

$FORMS['payment_item'] = <<<END
	<li><input type="radio" name="payment-id" value="%id%" class="%type-name%"/> %name%</li>
END;

$FORMS['bonus_block'] = <<<END

	<form id="bonus_payment" method="post" action="%pre_lang%/emarket/purchase/payment/bonus/do/">
		<p>Вы можете оплатить ваш заказ накопленными бонусами. Доступно бонусов на %available_bonus%.</p>
		<p>Вы собираетесь оплатить заказ на сумму %actual_total_price%.</p>
		<label><input type="text" name="bonus"/>Количество бонусов</label>
		<input type="submit" value="Продолжить" />
	</form>

END;

?>