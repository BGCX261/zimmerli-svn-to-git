<?php
$FORMS = Array();

$FORMS['lastlist_block'] = <<<END

				<div id="news" class="block">
					<h2>Новости и публикации</h2>
						%items%
					<hr/>
					%archive%
					<a id="rss" href="/data/rss/%id%/">RSS</a>

					%dispatches subscribe('home')%
				</div>


END;

$FORMS['lastlist_item'] = <<<END

					<div class="item">
						<span class="date" umi:element-id="%block-element-id%" umi:field-name="publish_time">%system convertDate(%publish_time%, 'd.m.Y')%</span> | <a href="%lent_link%" umi:element-id="%lent_id%" umi:field-name="name">%lent_name%</a>
						<a href="%link%" class="title" umi:element-id="%block-element-id%" umi:field-name="name">%header%</a>

						%data getProperty(%id%, 'anons_pic', 'news.anons.home')%

						<div umi:element-id="%block-element-id%" umi:field-name="anons">
							%anons%
						</div>
						<div class="comments">
							<a href="%link%#comments" >Комментарии (%comments countComments(%id%)%)</a> | <a href="%link%#add_comment">Добавить комментарий</a>
						</div>
					</div>

END;

$FORMS['lastlist_archive'] = <<<END

<a id="archive" href="%archive_link%">Архив новостей</a>

END;


?>