<?php

$FORMS = Array();

$FORMS['album_block'] = <<<END

				<div id="gallery" class="block">
					<a href="%link%" class="go">Перейти в Фотогалерею</a>
					<h2>%h1%</h2>
					<p>%descr%</p>
%lines%
				</div>

END;


$FORMS['album_block_empty'] = <<<END

<p>Фотогалерея пуста.</p>

END;


$FORMS['album_block_line'] = <<<END

					<div class="item">
						<a href="%link%" umi:element-id="%id%" umi:field-name="photo">%data getProperty(%id%, 'photo', 'home')%</a>
						<div class="description">
							<div class="title" umi:element-id="%id%" umi:field-name="name">%name%</div>
							<div class="category">Категория: <span umi:element-id="%id%" umi:field-name="tags">%tags%</span></div>
							<div class="author">Автор: %data getPropertyOfObject(%user_id%, 'login', 'home')%</div>
							<div class="comments">
								<a href="%link%#comments">Отзывы (%comments countComments(%id%)%)</a> | <a href="%link%#add_comment">Добавить комментарий</a>
							</div>
						</div>
					</div>

END;

?>
