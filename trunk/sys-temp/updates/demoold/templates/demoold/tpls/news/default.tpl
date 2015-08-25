<?php
$FORMS = Array();

$FORMS['lastlist_block'] = <<<END

<div umi:module="news" umi:method="lastlist" umi:element-id="%id%">
%items%
%system numpages(%total%, %per_page%, 'standart')%
</div>


END;

$FORMS['lastlist_item'] = <<<END

					<div class="item" umi:element-id="%id%">
						<span class="date" umi:element-id="%id%" umi:field-name="publish_time">%system convertDate(%publish_time%, 'd.m.Y')%</span> | 
						<a href="%link%" class="title" umi:element-id="%id%" umi:field-name="h1">%header%</a>

						%data getProperty(%id%, 'anons_pic', 'news.anons')%

						<p umi:element-id="%id%" umi:field-name="anons">%anons%</p>
						<div class="comments">
							<a href="%link%#comments" >Комментарии (%comments countComments(%id%)%)</a> | <a href="%link%#add_comment">Добавить комментарий</a>
						</div>
					</div>

END;

$FORMS['view'] = <<<END

%data getProperty(%id%, 'publish_pic', 'news.view')%

%content%

%news related_links(%id%)%

%comments insert('%id%')%

END;

$FORMS['related_block'] = <<<END

<div id="related_news" style="margin-top:150px">
	<p>Похожие новости:</p>
	<ul>
		%related_links%
	</ul>
</div>

END;

$FORMS['related_line'] = <<<END
	<li><a href="%link%"><b>%name%</b> (%system convertDate(%publish_time%, 'Y-m-d')%)</a></li>
END;



$FORMS['listlents_block'] = <<<END

<p>Рубрики новостей:</p>
<ul>
%items%
</ul>


END;

$FORMS['listlents_item'] = <<<END

	<li><a href="%link%" class="title">%header%</a></li>

END;

$FORMS['listlents_block_empty'] = <<<END
END;

?>