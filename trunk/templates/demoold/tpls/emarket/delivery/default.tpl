<?php
$FORMS = Array();

$FORMS['delivery_block'] = <<<END
<form action="%pre_lang%/emarket/purchase/delivery/choose/do/" method="post">
	Выберите подходящий вам способ доставки:
	<ul>
		%items%
	</ul>

	<p>
		<input type="submit" />
	</p>
</form>
END;

$FORMS['delivery_item_free'] = <<<END
	<li><input type="radio" name="delivery-id" value="%id%" %checked%/> %name% - бесплатно</li>
END;

$FORMS['delivery_item_priced'] = <<<END
	<li><input type="radio" name="delivery-id" value="%id%" %checked%/> %name% - %price%</li>
END;

$FORMS['self_delivery_block'] = <<<END
	<p></p>
	или пункт выдачи:
		%items%
	<p></p>
	или укажите новый адрес:
	<p></p>
END;

$FORMS['self_delivery_item_free'] = <<<END
	<li><input type="radio" name="delivery-address" value="delivery_%id%" %checked%/> %name% - бесплатно</li>
END;

$FORMS['self_delivery_item_priced'] = <<<END
	<li><input type="radio" name="delivery-address" value="delivery_%id%" %checked%/> %name% - %price%</li>
END;

$FORMS['delivery_address_block'] = <<<END
<form action="%pre_lang%/emarket/purchase/delivery/address/do/" method="post">
	<p>Выберите адрес доставки:</p>
		%items%
		%delivery%
		<input type="radio" name="delivery-address" value="new" /> Новый адрес доставки:
	<p></p>
	%data getCreateForm(%type_id%, 'purchase')%
	<p>
		<input type="submit" />
	</p>
</form>
END;

$FORMS['delivery_address_item'] = <<<END
	<li><input type="radio" name="delivery-address" value="%id%" %checked%/> %data getPropertyGroupOfObject(%id%, 'common', 'purchase')%</li>
END;
?>