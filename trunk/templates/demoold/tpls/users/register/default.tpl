<?php

$FORMS = Array();

$FORMS['registrate_block'] = <<<REGISTRATE
<script type="text/javascript" src="/js/phone_valid.js"></script>
<script type="text/javascript">$(document).ready(function(){ fieldPhone("#phone"); })</script>
<style type="text/css">article h1 { display: none !important; }</style>
<div id="registration">
    <form action="%pre_lang%/users/registrate_do/" method="post" enctype="multipart/form-data" id="registrate" onsubmit="saveFormData(this); return true;">
	<div class="login">
	    <h4>Персональные данные</h4>
	    <div class="sint">
		<div class="title"><i>*</i> Телефон:</div>
		<div class="phone-num">
		<input type="text" name="data[new][phone]" id="phone" />
		    <!--+7 <input type="text" class="code" name="phone_code" /> <input type="text" class="pn" name="phone_number" />-->
		</div>
		<div class="title"><i>*</i> Имя:</div>
		<input type="text" name="data[new][fname]" />
		<div class="title"><i>*</i> Фамилия:</div>
		<input type="text" name="data[new][lname]" />
		<div class="title"><i>*</i> E-mail:</div>
		<input type="hidden" name="login" id="login" />
		<input type="text" name="email" onchange="javascript:document.getElementById('login').value = (this.value)" />
		<div class="title"><i>*</i> Пароль:</div>
		<input type="password" name="password" />
		<div class="title"><i>*</i> Повтор пароля:</div>
		<input type="password" name="password_confirm" />
		<div class="subs">
		    <input type="hidden" id="data[new][mailing]" name="data[new][mailing]" value="0" />
		    <input onclick="javascript:document.getElementById('data[new][mailing]').value = (this.checked) ? '1' : '0';" type="checkbox" id="subs" value="1" /><label for="subs">Подписаться на новости и скидки</label>
		</div>
	    </div>
	</div>
	<div class="reg">
	    <h4>Адрес доставки</h4>
	    <div class="title">Адрес:</div>
	    <textarea name="data[new][address]"></textarea>
	    <input type="submit" value="Завершить регистрацию" />
	</div>
    </form>
</div>

REGISTRATE;



$FORMS['settings_block'] = <<<REGISTRATE
<script type="text/javascript" src="/js/phone_valid.js"></script>
<script type="text/javascript">$(document).ready(function(){ fieldPhone("#phone"); })</script>
<style type="text/css">article h1 { display: none !important; }</style>
<form action="%pre_lang%/users/settings_do/" method="post" enctype="multipart/form-data">
    <div id="registration" class="vis edit">
	<div class="login">
		<h4>Персональные данные</h4>
		<div class="sint">
			<div class="title pph"><i>*</i> Телефон:</div>
			<div class="phone-num">
				<input type="text" name="data[%user_id%][phone]" id="phone" value="%phone%" />
			</div>
			<div class="title"><i>*</i> Имя:</div>
			<input type="text" name="data[%user_id%][fname]" value="%fname%" />
			<div class="title"><i>*</i> Фамилия:</div>
			<input type="text" name="data[%user_id%][lname]" value="%lname%" />
			<div class="title"><i>*</i> E-mail:</div>
			<input type="text" name="email" value="%e-mail%" />
			<div class="title"><i>*</i> Пароль:</div>
			<input type="password" name="password" value="" />
			<div class="title"><i>*</i> Подтвердите пароль:</div>
			<input type="password" name="password_confirm" value="" />
			<div class="subs">
				<input type="hidden" id="data[%user_id%][mailing]" name="data[%user_id%][mailing]" value="%mailing%" />
				<input onclick="javascript:document.getElementById('data[42][mailing]').value = (this.checked) ? '1' : '0';" type="checkbox" id="subs" %mailing_checked% value="1" /><label for="subs">Подписаться на новости и скидки</label>
			</div>
		</div>
	</div>
	<div class="reg">
		<h4>Адрес доставки</h4>
		<div class="title">Адрес:</div>
		<textarea name="data[%user_id%][address]">%address%</textarea>
		<input type="submit" value="сохранить" />
	</div>
    </div>
</form>

REGISTRATE;






$FORMS['registrate_done_block'] = <<<END

Регистрация прошла успешно. На ваш e-mail отправлено письмо с инструкциями по активации аккаунта.

END;

$FORMS['registrate_done_block_without_activation'] = <<<END

Регистрация прошла успешно.

END;

$FORMS['registrate_done_block_error'] = <<<END

Регистрация завершилась неудачей. Проверьте правильность заполнения всех полей.

END;

$FORMS['registrate_done_block_user_exists'] = <<<END

Пользователь с таким именем уже существует. Попробуйте выбрать другое.

END;


$FORMS['activate_block'] = <<<END

<p>Аккаунт активирован.</p>

END;

$FORMS['mail_registrated_subject'] = "Регистрация на UMI.CMS Demo Site";

$FORMS['activate_block_failed'] = <<<END

<p>Неверный код активации.</p>

END;


$FORMS['mail_registrated'] = <<<MAIL

	<p>
		Здравствуйте, %lname% %fname% %father_name%, <br />
		Вы зарегистрировались на сайте <a href="http://%domain%">%domain%</a>.
	</p>


	<p>
		Логин: %login%<br />
		Пароль: %password%
	</p>


	<p>
		<div class="notice">
			Чтобы активировать Ваш аккаунт, необходимо перейти по ссылке, либо скопировать ее в адресную строку браузера:<br />
			<a href="%activate_link%">%activate_link%</a>
		</div>
	</p>

MAIL;

$FORMS['mail_registrated_subject_noactivation'] = "Регистрация на сайте %domain%";

$FORMS['mail_registrated_noactivation'] = <<<MAIL
	<p>
		Здравствуйте, %lname% %fname% %father_name%, <br />
		Вы зарегистрировались на сайте <a href="http://%domain%">%domain%</a>.
	</p>
	<p>
		Логин: %login%<br />
		Пароль: %password%
	</p>
MAIL;

$FORMS['mail_admin_registrated'] = <<<END
<p>Зарегистрировался новый пользователь "%login%".</p>
END;
$FORMS['mail_admin_registrated_subject'] = "Зарегистрировался новый пользователь";


?>