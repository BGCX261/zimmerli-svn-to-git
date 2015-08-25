<?php

$FORM = Array();

$FORMS['menu_block_level1'] = <<<END

<nav id="catalog">
			<div class="cat">
				<ul id="for-him">
					<li class="opened"><a href="#">Для мужчин</a>
						<ul>
							<li class="opened"><a href="#">Плавки</a>
								<ul>
									<li class="opened"><a href="#">Rich <span>7</span></a></li>
									<li><a href="#">Rich</a></li>
									<li><a href="#">Rich</a></li>
									<li><a href="#">Rich</a></li>
								</ul>
							</li>
							<li><a href="#">Боксеры</a></li>
							<li><a href="#">Майки</a></li>
							<li><a href="#">Футболки</a></li>
						</ul>
					</li>
				</ul>
				<ul id="for-her">
					<li><a href="#">Для женщин</a>
						<ul>
							<li><a href="#">Плавки</a></li>
							<li><a href="#">Боксеры</a></li>
							<li><a href="#">Майки</a></li>
							<li><a href="#">Футболки</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
  
END;

$FORMS['menu_line_level1'] = <<<END

END;

$FORMS['menu_line_level1_a'] = <<<END
%sub_menu%
END;

$FORMS['menu_block_level2'] = <<<END
<ul id="submenu">%lines%</ul>
%content menu('sl2',%pid%,10)%
END;

$FORMS['menu_line_level2'] = <<<END
<li><a href="%link%">%text%</a></li>
END;

$FORMS['menu_line_level2_a'] = <<<END
<li class="active"><a href="%link%">%text%</a></li>
END;


?>
