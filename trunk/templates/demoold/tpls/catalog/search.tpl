<?php

$FORMS = Array();


$FORMS['search_block'] = <<<END

<form method="get" action="%content get_page_url(%category_id%)%">
	<div>
		<div style="padding-bottom:5px;">Фильтр по товарам</div>

		%lines%
		
		<div style="clear:both;"></div>
	</div>

	<p style="padding-left:9px;"><input type="submit" class="filter_btn" value="Подобрать" />&nbsp;&nbsp;&nbsp;<input class="filter_btn" type="button" onclick="javascript: window.location = '%content get_page_url(%category_id%)%';" value="Сбросить" class="filter_btn" /></p>
</form>


END;


$FORMS['search_block_line'] = <<<END

	<table border="0" cellpadding="0" cellspacing="0" style="float:left;" id="search_block" rules="rows">
		%selector%
	</table>

END;



$FORMS['search_block_line_relation'] = <<<END

<tr id="hat">
	<td style=" width: 100px;">
		%title%
	</td>
</tr>
<tr>
	<td>
		<select name="fields_filter[%name%]" class="textinputs" style="width:100px; height: 18px;"><option />%items%</select>
	</td>
</tr>
END;

$FORMS['search_block_line_symlink'] = <<<END

<tr id="hat">
	<td style=" width: 100px;">
		%title%
	</td>
</tr>
<tr>
	<td>
		<select name="fields_filter[%name%]" class="textinputs" style="width:100px; height: 18px;"><option />%items%</select>
	</td>
</tr>
END;


$FORMS['search_block_line_text'] = <<<END

<tr id="hat">
	<td>
		%title%
	</td>
</tr>
<tr>
	<td>
		<input type="text" name="fields_filter[%name%]" class="textinputs" value="%value%" />
	</td>
</tr>

END;

$FORMS['search_block_line_price'] = <<<END


<tr id="hat">
	<td>
		%title% от &nbsp;до
	</td>
</tr>
<tr>
	<td>
		<input type="text" name="fields_filter[%name%][0]" class="textinputs" style="width:40px;" value="%value_from%" size="12" /> <input type="text" name="fields_filter[%name%][1]" class="textinputs" style="width:40px;" value="%value_to%" size="12" />
	</td>
</tr>


END;

$FORMS['search_block_line_boolean'] = <<<END

<tr id="hat">
	<td>
		<label for="fields_filter[%name%]" style="">%title%</label>
	</td>
</tr>
<tr>
	<td>
		<input type="checkbox" name="fields_filter[%name%]" id="fields_filter[%name%]" %checked% value="1" /> 
	</td>
</tr>

END;


?>
