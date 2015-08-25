<?php
$FORMS = Array();

$FORMS['category'] = <<<END
<p>%descr%</p>
%catalog getCategoryList('default', '%category_id%', 100, 1)%
%catalog getObjectsList('default', '%category_id%')%

END;


$FORMS['category_block'] = <<<END
<h3>Подразделы</h3>
<ul>
	%lines%
</ul>

END;


$FORMS['category_block_empty'] = "";


$FORMS['category_block_line'] = <<<END
<li><a href="%link%"><b>%text%</b></a></li>

END;




$FORMS['objects_block'] = <<<END
<table style="width: 100%;">
	<tr>
		<td>
			%catalog search('%category_id%', 'cenovye_svojstva short_info', 'search')%
		</td>
	</tr>
</table>
<br />
%system numpages(%total%, %per_page%, 'catalog')%
<br />
<div umi:method="catalog" umi:module="category" umi:element-id="%category_id%">
%lines%
</div>
<div style="clear: both;"></div>

%system numpages(%total%, %per_page%, 'catalog')%

<br /><br />

END;


$FORMS['objects_block_search_empty'] = <<<END

<table style="width: 100%;">
	<tr>
		<td>
			%catalog search('%category_id%', 'cenovye_svojstva short_info', 'search')%
		</td>
	</tr>
</table>

<p>По Вашему запросу ничего не найдено.</p>

END;


$FORMS['objects_block_line'] = <<<END

%catalog viewObject(%id%, 'preview')%


END;



$FORMS['view_block'] = <<<END

%data getProperty(%id%, 'photo', 'catalog_view')%

%data getPropertyGroup(%id%, 'short_info short_params', 'catalog_full')%

<p align="right">
	%emarket basketAddLink(%id%)% |
	(<b>Цена: <span>%emarket price('%id%', 'short')%</span></b>)
</p>

<div style="clear: both;"></div>

<div style="margin-top: 20px;">
%data getPropertyGroup(%id%, 'other_proerties imported', 'catalog_full')%
</div>


%data getProperty(%id%, 'opisanie', 'catalog_opisanie')%

%data getPropertyGroup('%id%', 'catalog_option_props', 'catalog_options')%

<div style="margin-top: 20px;">
	%data getPropertyGroup(%id%, 'recommend imported', 'catalog_full')%
</div>

<div style="clear: both;"></div><br />
%comments insert('%id%')%

END;

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