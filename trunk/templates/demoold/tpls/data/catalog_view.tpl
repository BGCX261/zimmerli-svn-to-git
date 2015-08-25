<?php

$FORMS = Array();

$FORMS['img_file'] = <<<END
	<a class="photo" href="%system makeThumbnailFull(%filepath%, 330, 'auto','thumb_src')%" id="%name%" onclick="change_foto('%name%','%system makeThumbnailFull(%filepath%, 330, 207,'thumb_src')%','%src%'); return false;" >%system makeThumbnail(%filepath%, 'auto', 44, 'catalog_view')%</a>
END;


?>