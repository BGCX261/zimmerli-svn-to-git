<?php

$FORMS = Array();


$FORMS['search_block'] = <<<END

%search insert_form()%

<p>%search_founded_total1% %total% %search_founded_total%.</p>

%lines%

<p>%system numpages(%total%, %per_page%)%</p>

END;

$FORMS['search_block_line'] = <<<END

<p>
	<span class="s_num">%num%.</span> <a href='%link%' style="font-weight: bold;" umi:element-id="%id%" umi:field-name="name">%name%</a>
	%context%
</p>


END;

$FORMS['search_empty_result'] = <<<END
	%search insert_form()%

	<p>
		Извините. По данному запросу ничего не найдено.
	</p>
END;

$FORMS['search_form'] = <<<END

	<form id="search" class="block" method="get" action="%pre_lang%/search/search_do/">
		<input type="text" class="textinputs" style="width:180px;" name="search_string" value="%last_search_string%" onfocus="javascript: if(this.value == '%last_search_string%') this.value = '';" onblur="javascript: if(this.value == '') { this.value = '%last_search_string%';}" x-webkit-speech="" speech=""/>
		<input type="submit" value="%search_dosearch%"/>
		
		<p>
			Нужно искать:
			<input type="radio" name="search-or-mode" id="search-and-mode" value="0" %search_mode_and_checked%>
			<label for="search-and-mode">Все слова</label>
			
			<input type="radio" name="search-or-mode" id="search-or-mode" value="1" %search_mode_or_checked%>
			<label for="search-or-mode">Хотя бы одно</label>
		</p>
		
	</form>

END;

?>