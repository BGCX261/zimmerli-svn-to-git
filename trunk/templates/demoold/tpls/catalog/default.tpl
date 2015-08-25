<?php
$FORMS = Array();

$FORMS['category'] = <<<END
%catalog getObjectsList('default', '%category_id%')%

END;


$FORMS['category_block'] = <<<END


END;
/*
<ul>
	%lines%
</ul>*/

$FORMS['category_block_empty'] = "";


$FORMS['category_block_line'] = <<<END
<li><a href="%link%"><b>%text%</b></a></li>

END;




$FORMS['objects_block'] = <<<END
 
  <ul id="prod-list">%lines%</ul>  

END;
/*
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
*/

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




<li>
				<a href="%link%">
                  %system makeThumbnailFull(%data getProperty(%id%, 'pic1','catalog_fitting_products')%, 212, 237)%	
                  
					<span class="title">%text%</span>
					<span class="sizes">
						<i></i>
						%data getProperty(%id%, 'razmer', 'catalog_size_in_list')%                
					</span>
				</a>%catalog is_new(%id%)%
			</li>
            


END;
/*
%catalog viewObject(%id%, 'preview')% */


$FORMS['view_block'] = <<<END


<a class="pathway" href="#">обратно в каталог</a>
		<div class="image-col">
			<div class="p-wrap">
				<div class="big-image">
                  
					<a class="zoom" href="%pic1%" rel="prettyPhoto"></a>
					%system makeThumbnailFull(%data getProperty(%id%, 'pic1','catalog_fitting_products')%, 330, 'auto')%	
				</div>
				<div class="small-img">
                  %data getProperty(%id%, 'pic1', 'catalog_view')%
                  %data getProperty(%id%, 'pic2', 'catalog_view')%
                  %data getProperty(%id%, 'pic3', 'catalog_view')%
                  %data getProperty(%id%, 'pic4', 'catalog_view')%
                  %data getProperty(%id%, 'pic5', 'catalog_view')%
                  %data getProperty(%id%, 'pic6', 'catalog_view')%
                  %data getProperty(%id%, 'pic7', 'catalog_view')%
                  %data getProperty(%id%, 'pic8', 'catalog_view')%
                  %data getProperty(%id%, 'pic9', 'catalog_view')%
                  %data getProperty(%id%, 'pic10', 'catalog_view')%
					
					<!--<a href="#" ><img src="/img/x40.png" alt="name" /><span></span></a>-->
				</div>
				<div class="share">
					<span>Поделитесь с друзьями</span>
					<img src="/img/x41.png" alt="name" />
				
				</div>
			</div>
			<script type="text/javascript" charset="utf-8">
				$(document).ready(function(){
					$("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'facebook',slideshow:0, autoplay_slideshow: false,social_tools:false,deeplinking:false});
				});
			</script>
		</div>
		<div class="content">
			<div class="c-wrap">
				<h1>%name%</h1><br />
				%opisanie%
				<div class="price">
					Цена: <span>%emarket price('%id%', 'short')%</span>
				</div>
                %data getPropertyGroup(%id%, 'usloviya_chistki', 'catalog_clean_options')%                
				
                <form action="%pre_lang%/emarket/basket/put/element/%id%/" method="get">
				<h4>Выберите цвет вещи</h4>
                %data getProperty(%id%, 'cvet', 'catalog_color')%                
				<h4>Выберите размер вещи</h4>
				%data getProperty(%id%, 'razmer', 'catalog_size')%                
                
				<a class="size-table" href="#"><span>Таблица размеров</span></a>
				<br />
                <input type="submit" value="купить" class="bye" />
                <input type="button" value="Добавить в список желаний" class="towish" />
				</form>
				
				
				<div id="size-table">
                  <h4>Размеры одежды<span></span></h4>                  
                  %catalog size_table()%
				</div>
			</div>
		</div>
        %data getProperty(%id%, 'fitting_products', 'catalog_fitting_products')%                        
		
END;
/*
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

*/


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