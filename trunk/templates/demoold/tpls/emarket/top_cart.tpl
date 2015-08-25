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
<a class="basket" href="#">Корзина <span>(%total-amount%)</span></a>
    <div id="basket">
      <a class="bas-up" href="#"></a>
      <ul>
        %items%
      </ul>
      <a class="bas-down" href="#"></a>
      <div class="end">
        Итого: <span>%total-price%</span><br />
        <a href="/emarket/cart/">Перейти в корзину</a>
      </div>
    </div>
    
END;

$FORMS['order_item'] = <<<END
<li>
          <a class="img" href="%link%">%system makeThumbnailFull(%data getProperty(%element_id%, 'pic1','catalog_fitting_products')%, 66, 'auto')%</a>
          <div class="txt">
            <a href="%link%">%name%</a>
            <!--Цвет и размер: %options%<br />-->
            Количество: %amount%<br />
            <span class="price">%price%</span>
          </div>
          <a class="delete" title="Удалить товар из корзины" href="/emarket/basket/remove/item/%id%/"></a>
        </li>
  
END;

$FORMS['options_block'] = <<<END
%items%
END;

$FORMS['options_block_empty'] = "---";

$FORMS['options_item'] = <<<END
%name% 
END;

$FORMS['order_block_empty'] = <<<END
<a class="basket" href="#">Корзина пуста<span></span></a>
    
END;


$FORMS['purchase'] = <<<END
%purchasing%

%emarket ordersList()%
END;


$FORMS['orders_block'] = <<<END
<p>Список ваших заказов:</p>
<ul>
	%items%
</ul>
END;

$FORMS['orders_block_empty'] = <<<END
<p>Заказов нет</p>
END;

$FORMS['orders_item'] = <<<END
	<li>%name% (%id%)</li>
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