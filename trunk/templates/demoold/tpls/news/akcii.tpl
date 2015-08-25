<?php

$FORMS = Array();

$FORMS['lastlist_block'] = <<<END
					<div id="promo" class="block">
						<h2 umi:element-id="%block-element-id%" umi:field-name="h1">Акции</h2>
						<div>%items%</div>
					</div>

END;

$FORMS['lastlist_item'] = <<<END
						<h3 umi:element-id="%id%" umi:field-name="h1">%h1%</h3>
						<p umi:element-id="%id%" umi:field-name="anons">%anons%</p>

END;

?>
