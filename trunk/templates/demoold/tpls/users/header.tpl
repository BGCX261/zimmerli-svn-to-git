<?php

$FORMS = Array();

$FORMS['login'] = <<<END

<div class="links">
		<a class="registration" href="#">Регистрация</a><br />
		<a class="enter bg ar" href="#">Вход</a>
	    </div>				
  <!--<form id="auth" action="%pre_lang%/users/login_do/" method="post" style="margin-left:12px;" >
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
					
				</form>-->
                 
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
        <div class="links">
			<a class="bg ad lk-but" href="#">Личный кабинет</a>
			<br />
			<a class="logout" href="%pre_lang%/users/logout/">Выход</a>
			<div class="lk">
				<a class="akk" href="%pre_lang%/account/settings/">Аккаунт</a>
				<a class="orders" href="%pre_lang%/account/orders_list/">Мои заказы</a>
				<a class="wish" href="%pre_lang%/account/wishlist/">Мои желания</a>
			</div>
		</div>			
  

END;
?>