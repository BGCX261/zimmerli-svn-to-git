<?php
 $FORMS = Array();

$FORMS['guide_block'] = <<<END
<div id="size-box">
			<h4>Размер</h4>
			<div class="box">
			%lines%	
			</div>
		</div>  
END;

$FORMS['guide_item'] = <<<END
  <input type="checkbox" data-label="%name%" name="size[]" value="%id%" />
  <!-- fields_filter[razmer]= -->
END;


?>