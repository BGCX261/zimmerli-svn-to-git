<?php

$FORMS = Array();

// answer mail for user
$FORMS['answer_mail_subj'] = <<<MAIL_USER_SBJ
[#%ticket%] Ответ на Ваш вопрос
MAIL_USER_SBJ;

$FORMS['answer_mail'] = <<<MAIL_USER

Здравствуйте, <br /><br />

Ответ на Ваш вопрос Вы можете прочитать по следующему адресу:<br />
<a href="%question_link%">%question_link%</a><br />

<br /><hr />
С уважением, <br />
Администрация сайта <b>%domain%</b>

MAIL_USER;


?>