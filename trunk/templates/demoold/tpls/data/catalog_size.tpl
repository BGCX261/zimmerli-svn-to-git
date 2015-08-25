<?php 
$FORMS = Array(); 
 
$FORMS['relation_mul_block'] = <<<END
<div class="sizes">
  %items%	
  <script type="text/javascript">
    $(function(){
  $('a[rel^="size"]:first').attr('class','active');
  $('input[id^="size"]:first').attr('checked','checked');
  
  })
</script>
</div>

END;
 
$FORMS['relation_mul_item'] = <<<END
<a rel="size%object_id%" href="#">%value%<span></span></a>
<input type="checkbox" id="size%object_id%" name="options[razmer]" value="%object_id%" /> 

END;


?>