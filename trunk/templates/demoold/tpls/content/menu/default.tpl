<?php

$FORMS = Array();


$FORMS['menu_block_level1'] = <<<END
<ul id="menu"
	umi:element-id="%id%"
	umi:module="content"
	umi:method="menu"
	umi:sortable="sortable"
	umi:add-method="popup"
	umi:region="list"
	umi:button-position="bottom right"
>
	%lines%
</ul>

END;

$FORMS['menu_line_level1'] = <<<END
<li>
<a href="%link%"
	umi:element-id="%id%"
	umi:field-name="name"
	umi:delete="delete"
	umi:region="row"
	umi:empty="Название страницы"
>
	%text%
</a></li>

END;

$FORMS['menu_line_level1_a'] = <<<END
<li class="active">
  <a href="%link%"
	umi:element-id="%id%"
	umi:field-name="name"
	umi:delete="delete"
	umi:region="row"
	umi:empty="Название страницы"
>
	%text%
</a>
</li>

END;

?>