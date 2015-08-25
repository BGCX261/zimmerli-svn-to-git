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
<style type="text/css">
    article h1 {
	display: none !important;
    }
</style>
		<div class="basket">
			<h2>Корзина</h2>
			<table>
				<tr>
					<th class="prod">Товар</th>
					<th class="stoi">Стоимость</th>
					<th class="kolvo">Количество</th>
					<th class="itogo">Итого</th>
				</tr>
				%items%
			</table>
			<hr />
			<table class="prices">
				<tr>
					<td>
						Способы оплаты:
					</td>
					<td class="stoi"></td>
					<td></td>
				</tr>
				<tr>
					<td>
						<span>Наличными при получении</span>
					</td>
					<td></td>
					<td><i>Подитог:</i> <b>%original-price%</b></td>
				</tr>
				<tr class="sep">
					<td>
						&nbsp;
					</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>
						Способы доставки:
					</td>
					<td></td>
					<td><i>Доставка:</i> <b>%delivery-price%</b></td>
				</tr>
				<tr>
					<td>
						<span>Курьером (по Москве в пределах МКАД)</span>
					</td>
					<td>%delivery-price%</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td><i>ИТОГО:</i> <b class="red">%total-price%</b></td>
				</tr>
				<tr class="sep">
					<td>
						&nbsp;
					</td>
					<td></td>
					<td></td>
				</tr>
				<tr class="sep">
					<td>
						&nbsp;
					</td>
					<td></td>
					<td></td>
				</tr>
			</table>
		</div>
		<form action="%pre_lang%/emarket/purchase/">
		    <input type="submit" value="Оформить заказ" />
		</form>

END;

$FORMS['order_item'] = <<<END
				<tr>
					<td>
						<div class="img">
							<img src="img/img5.png" alt="name" />
						</div>
						<div class="info">
							<h3>%name%</h3>
							<br />
							%options%<br />
							<span class="exist"></span>
						</div>
					
					</td>
					<td class="pr">%price%</td>
					<td class="count">
					
						<a href="#" class="minus"></a>
						<span class="numnum">%amount%</span>
						<a href="#" class="plus"></a>
						<a class="del" href="/emarket/basket/remove/item/%id%/">Удалить</a>
						<input type="hidden" class="num" value="%amount%" />
					</td>
					<td class="total">%total-price%</td>
				</tr>

END;

$FORMS['options_block'] = <<<END
 %items%
END;

$FORMS['options_block_empty'] = "---";

$FORMS['options_item'] = <<<END
%name% 
END;
/*+%price%%list-comma%*/

$FORMS['order_block_empty'] = <<<END
<p>Корзина пуста</p>
END;


$FORMS['purchase'] = <<<END
%purchasing%
END;


$FORMS['orders_block'] = <<<END
<style type="text/css">article h1 { display:none; }</style>
<div class="basket wish">
	<table class="orders">
		<tr>
			<th>Заказ</th>
			<th>Дата</th>
			<th>Адрес</th>
			<th>Сумма заказа</th>
		</tr>
		%items%
	</table>
	<hr />
</div>
END;

$FORMS['orders_block_empty'] = <<<END
<p>Заказов нет</p>
END;

$FORMS['orders_item'] = <<<END
	<tr class="order-line">
		<td>
			<span class="order-num">№ %number%</span>
		</td>
		<td class="pr"></td>
		<td class="date"></td>
		<td class="add"></td>
	</tr>
	<tr>
		<td>
			<div class="item">
				<!--<div class="img">
					<img src="img/img6.png" alt="name" />
				</div>
				<div class="info2">
					<span><i>207</i> just richelieu</span><br />
					Размер: <b>8,5 (41 RUS)</b>&nbsp; Кол-во: <b>2 шт.</b>
				</div>-->
				%order_items%
			</div>
		</td>
		<td class="pr2">%delivery_allow_date%</td>
		<td class="pr2">%delivery_address%</td>
		<td class="pr2"><span class="price">%total_price% руб.</span></td>
	</tr>
END;

$FORMS['orders_order_item'] = <<<END
				<div class="item">
					<div class="img">
						%system makeThumbnailFull(%data getProperty(%element_id%, 'pic1','catalog_fitting_products')%, 66, 'auto')%
					</div>
					<div class="info2">
						<span>%name%</span><br />
						Кол-во: <b>%item_amount% шт.</b>
					</div>
				</div>

END;

$FORMS['basket_add_link'] = <<<END
  <input type="submit" value="купить" onclick="document.location.href='%link%'" class="bye" />
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