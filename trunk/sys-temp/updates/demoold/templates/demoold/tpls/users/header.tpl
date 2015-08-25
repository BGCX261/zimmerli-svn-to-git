<?php

$FORMS = Array();

$FORMS['login'] = <<<END

				<form id="auth" action="%pre_lang%/users/login_do/" method="post" style="margin-left:12px;" >
					<label for="login">Логин:</label>
					<input type="text" id="login" name="login" class="input" value=""/>
					<label for="password">Пароль:</label>
					<input type="password" id="password" name="password" class="input" value=""/>
					<label>
						<input type="submit" value="%users_auth_enter%" style="float:left;"/>
						<input type="hidden" name="from_page" value="%from_page%" style="display:none;" />
					</label>
					<label style="position:relative; left:70px; top:8px;">
						<a href="%pre_lang%/users/forget/" class="sub" style="color:#002F81;">Забыли&nbsp;пароль?</a>
					 </label>
					 <div class="clear"></div>
					
				</form>
                 
END;

$FORMS['login_demo'] = <<<END

				<form id="auth" action="%pre_lang%/users/login_do/" method="post" style="margin-left:12px;" >
					<label for="login">Логин:</label>
					<input type="text" id="login" name="login" class="input" value="demo"/>
					<label for="password">Пароль:</label>
					<input type="password" id="password" name="password" class="input" value="demo"/>
					<label>
						<input type="submit" value="%users_auth_enter%" style="float:left;"/>
						<input type="hidden" name="from_page" value="%from_page%" style="display:none;" />
					</label>
					<label style="position:relative; left:70px; top:8px;">
						<a href="%pre_lang%/users/forget/" class="sub" style="color:#002F81;">Забыли&nbsp;пароль?</a>
					 </label>
					 <div class="clear"></div>
					
				</form>
                 
END;

$FORMS['logged'] = <<<END
			<div id="auth">
				<p>
					<b>
						%users_welcome%<br />
						<span umi:object-id="%user_id%" umi:field-name="fname">%fname%</span> (%user_login%)
					</b>
				</p>
				<!--ul>
					<li>
						<p>
							<a href="#" title="" id="on_edit_in_place" class="link_transfer_class">Включить быстрое редактирование</a>
						</p>
					</li>
					<li>
						<p>
							<a href="/admin/" title="" class="link_transfer_class">Перейти в администрирование</a>
						</p>
					</li>
				</ul-->
				<p>
					<a href="%pre_lang%/users/logout/" class="blue">Выйти</a> | <a href="%pre_lang%/users/settings/" class="blue">Настройка</a>
				</p>
			</div>

END;
?>