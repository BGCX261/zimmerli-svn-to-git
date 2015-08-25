<?php
$FORMS = array();

$FORMS['price_block'] = <<<END

<h5>Вывод цены</h5>
%price-original%
%price-actual%

%emarket discountInfo(%discount_id%)%

%currency-prices%


END;

$FORMS['price_original'] = <<<END
<!-- %currency_name% -->
<p>
	<strike>%prefix%&nbsp;%original%&nbsp;%suffix%</strike>
</p>
END;

$FORMS['price_actual'] = <<<END
<!-- %currency_name% -->
	%prefix%&nbsp;%actual%&nbsp;%suffix%
END;


$FORMS['order_block'] = <<<END
<h3>Информация о покупателе</h3>
<p>%emarket getCustomerInfo()%</p>
<h3>Список покупок</h3>

<table width="100%" rules="rows" cellspacing="0" cellpadding="0" border="0" id="order_block">
	<thead>
		<tr class="orow_hat">
			<th>#</th>
			<th>Наименования</th>
			<th>Опции</th>
			<th>Q</th>
			<th>Цена</th>
			<th>Сумма</th>
			<th>Скидки</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		%items%
	</tbody>
</table>
<div class="basket_remove_all">
<a href="/emarket/basket/remove_all/">Очистить корзину</a>
</div>
<h3>Скидка на заказ</h3>
%emarket discountInfo(%discount_id%)%

<h3>Доставка</h3>
%delivery-price%

<h3>Использованные бонусы</h3>
%bonus%

<h3>Сумма</h3>
%total-price%
<p>Товаров в корзине: %total-amount%</p>

<form action="%pre_lang%/emarket/purchase/">
<input type="submit" value="Оформить заказ" />
</form>


END;

$FORMS['order_item'] = <<<END
<tr>
	<td>
		#
	</td>

	<td>
		<a href="%link%">%name%</a>
	</td>

	<td>
		%options%
	</td>

	<td>
		%amount%
	</td>

	<td>
		%price%
	</td>

	<td>
		%total-price%
	</td>

	<td>
		%emarket discountInfo(%discount_id%)%
	</td>
	<td>
		<a href="/emarket/basket/remove/item/%id%/">(X)</a>
	</td>
</tr>
END;

$FORMS['options_block'] = <<<END
 %items%
END;

$FORMS['options_block_empty'] = "---";

$FORMS['options_item'] = <<<END
%name% +%price%%list-comma%
END;

$FORMS['order_block_empty'] = <<<END
<p>Корзина пуста</p>
END;


$FORMS['purchase'] = <<<END
%purchasing%
END;


$FORMS['orders_block'] = <<<END
<p>Список ваших заказов:</p>
<table class="table_personal" cellpadding="0" cellspacing="0">
	<thead>
		<th>№ Заказа</th>
		<th>Наименование</th>
		<th>Стоимость доставки</th>
		<th>Сумма</th>
	</thead>
	<tbody>
		%items%
	</tbody>
</table>
END;

$FORMS['orders_block_empty'] = <<<END
<p>Заказов нет</p>
END;

$FORMS['orders_item'] = <<<END
	<tr>
		<td class="first">
			%name% (%id%)
		</td>
		<td>
			%order_items%
		</td>
		<td class="fix fix_p">
			%delivery_price%
		</td>
		<td class="fix">
			%total_price% руб
		</td>
	</tr>
END;

$FORMS['basket_add_link'] = <<<END
	<a href="%link%" class="basket_add_link">Положить в корзину</a>
END;


$FORMS['purchase_successful'] = <<<END
<p>Заказ успешно добавлен</p>
END;

$FORMS['purchase_failed'] = <<<END
<p>Не удалось добавить заказ</p>
END;

$FORMS['personal'] = <<<END
	%emarket ordersList()%
END;

?>