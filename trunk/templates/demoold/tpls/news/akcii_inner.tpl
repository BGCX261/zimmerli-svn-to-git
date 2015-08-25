<?php

$FORMS = Array();

$FORMS['lastlist_block'] = <<<END

					<div id="promo" class="block">
						<h2>Акции</h2>
						%items%
					</div>

END;

$FORMS['lastlist_item'] = <<<END

						<div class="description">
							<h3 umi:element-id="%id%" umi:field-name="h1">%h1%</h3>
							<div umi:element-id="%id%" umi:field-name="anons">%anons%</div>
						</div>

END;

?>
