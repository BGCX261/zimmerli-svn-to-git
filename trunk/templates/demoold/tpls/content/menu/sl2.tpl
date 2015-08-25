<?php

$FORM = Array();

$FORMS['menu_block_level1'] = <<<END
<ul id="submenu">%lines%</ul>
END;

$FORMS['menu_line_level1'] = <<<END
<li><a href="%link%">%text%</a></li>
END;

$FORMS['menu_line_level1_a'] = <<<END
<li class="active"><a href="%link%">%text%</a></li>
END;

?>