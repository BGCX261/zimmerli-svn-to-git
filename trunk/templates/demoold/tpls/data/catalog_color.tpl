<?php 
$FORMS = Array(); 
 
$FORMS['relation_mul_block'] = <<<END
<div class="colors">
  <script type="text/javascript">
    $(function(){
  $('a[rel^="color"]:first').attr('class','active');
  $('input[id^="color"]:first').attr('checked','checked');
  $('a[style="background:#ffffff"]').html('<img alt="name" src="/img/x45.png"><span></span>');
  })
</script>
  %items%					
</div>
END;
 
$FORMS['relation_mul_item'] = <<<END

<a rel="color%object_id%" style="background:#%data getPropertyOfObject(%object_id%, 'nazvanie','catalog_color')%" href="#"><span></span></a>
<input type="radio" id="color%object_id%" name="options[color]" value="%object_id%"  /> 	
 

END;

$FORMS['string'] = <<<END
%value%
END;

?>