<?php 
$FORMS = Array(); 
 
$FORMS['symlink_block'] = <<<END
<div class="additional">
			<h2>Подходящие товары</h2>
			<ul>
			%items%		

			</ul>
		
		</div>
  

END;
 
$FORMS['symlink_item'] = <<<END
              <li>
					<a href="%link%">
						<span class="img">
						%system makeThumbnailFull(%data getProperty(%id%, 'pic1','catalog_fitting_products')%, 116, 116)%	
                          
						</span>
						<span class="title">%value%</span>
						<span class="price">Цена: <i>%data getProperty(%id%, 'price','catalog_fitting_products')%</i></span>
					</a>
				</li>


END;

$FORMS['img_file'] = <<<END
%filepath%
END;

$FORMS['price'] = <<<END
%value% руб.
END;

$FORMS['image'] = <<<END
%src%"
END;

$FORMS['symlink_quant'] = <<<END

END;

?>