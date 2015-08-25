<?php
$FORMS = Array();

$FORMS['group'] = <<<END
<div class="lb">
  %lines%
</div> 
 
END;

$FORMS['group_line'] = <<<END
  %prop%
END;


$FORMS['relation'] = <<<END
<img src="%data getPropertyOfObject(%object_id%, 'pic','catalog_clean_options')%" title="%value%" alt="%value%" />    
END;

$FORMS['img_file'] = <<<END
%src%
END;


?>