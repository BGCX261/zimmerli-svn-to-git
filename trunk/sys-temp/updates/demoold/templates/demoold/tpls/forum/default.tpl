<?php

$FORMS = Array();


$FORMS['confs_block'] = <<<CONFS_BLOCK

<br />

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tforum">
	<tr>
		<td class="hforum">Рубрики</td>
		<td class="hforum">Темы</td>
		<td class="hforum">Сообщения</td>
		<td class="hforum">Последние&nbsp;сообщения</td>
	</tr>
%lines%
</table>

CONFS_BLOCK;

$FORMS['confs_block_line'] = <<<CONFS_LINE

<tr>

	<td class="nforum"  width="200">
		<p><a href="%link%" class="forum">%name%</a><br />
		%descr%</p>
	</td>

	<td class="nforum" align="center">
		%topics_count%
	</td>

	<td class="nforum" align="center">
		%messages_count%
	</td>

	<td class="nforum">
		%forum conf_last_message(%id%, 'default')%
	</td>

</tr>

CONFS_LINE;

$FORMS['topics_block'] = <<<TOPICS_BLOCK


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tforum">
	<tr>
		<td class="hforum" width="200">Темы</td>
		<td class="hforum">Ответов</td>
		<td class="hforum">Последнее сообщение</td>
	</tr>
%lines%
</table>

<p>%system numpages(%total%, %per_page%)%</p>

<br />

%forum topic_post(%id%)%

<br />

TOPICS_BLOCK;


$FORMS['topics_block_line'] = <<<TOPICS_LINE

<tr>
	<td class="nforum">
		<p><a href="%link%" class="forum">%name%</a><p>
	</td>

	<td class="nforum" align="center">
		%messages_count%
	</td>

	<td class="nforum">
		%forum topic_last_message(%id%, 'default')%
	</td>
</tr>

TOPICS_LINE;


$FORMS['messages_block'] = <<<MESSAGES_BLOCK



<table width="100%" border="0" cellspacing="0" cellpadding="0">
%lines%
</table>

<p>%system numpages(%total%, %per_page%)%</p>

<br />

%forum message_post(%id%)%

<br />


MESSAGES_BLOCK;


$FORMS['messages_block_line'] = <<<MESSAGES_LINE

<tr>
	<td class="f_mess">
		<a name="%id%"></a>
		<span style="cursor: pointer;" onclick="javascript: return forum_toAuthor(this);" id="author_%num%">
			%users viewAuthor(%author_id%)%
		</span>

		%system convertDate(%publish_time%, 'd.m.Y в H:i')%<br />
		<b>%name%</b><br /></br >
	</td>
</tr>

<tr>
	<td>
		<div style="display: inline;" id="mess_%id%" umi:element-id="%id%" umi:field-name="message">%message%</div>
		<br /><br />
		(<a href="#add" onmousedown="javascript: forum_quote(%id%); return false;" onfocus="javascript: return false;">Цитировать</a>)<br /><br />
	</td>
</tr>

<tr>
	<td colspan="2"><div class="spacer"></div></td>
</tr>

MESSAGES_LINE;



$FORMS['add_message_user'] = <<<ADD_MESSAGE_USER

<form method="post" action="%action%" onsubmit="javascript: return true; forum_check_form(this);">

<div class="forum_add" style="width: 100%;">
<br />
<div>
<a name="add"></a>
	<span style="color: #000;">Заголовок сообщения:</span>
	<input type="text" name="title" style="width: 90%; " class="textinputs" value="Re: %name%" /><br /><br />


	<span style="color: #000;">Ваши комментарии:</span>
	<textarea name="body" id="message" style="width: 90%;height:150px;" class="textinputs"></textarea>
	%smiles%
	<p><input type="submit" value="Отправить" /></p>
</div>
<br />
</div>

<input type="hidden" name="login" disabled="disabled" />

</form>

ADD_MESSAGE_USER;

$FORMS['add_message_guest'] = <<<ADD_MESSAGE_GUEST

<form method="post" action="%action%" onsubmit="javascript: return true; forum_check_form(this);">

<div class="forum_add" style="width: 100%;">
<br />
<div>

<a name="add"></a>
	<span style="color: #000;">Ваше имя:</span>
	<input type="text" name="nickname" style="width: 90%; " class="textinputs" /><br /><br />

	<span style="color: #000;">Ваш e-mail:</span>
	<input type="text" name="email" style="width: 90%; " class="textinputs" /><br /><br />

	<span style="color: #000;">Название темы:</span>
	<input type="text" name="title" style="width: 90%;" class="textinputs" /><br /><br />
	%system captcha()%
	<span style="color: #000;">Ваши комментарии:</span>
	<textarea name="body" id="message" style="width: 90%; height: 240px;" class="textinputs"></textarea>
	%smiles%
	<p><input type="submit" value="Отправить" /></p>
</div>

<br />
</div>



</form>



ADD_MESSAGE_GUEST;


$FORMS['add_topic_user'] = <<<ADD_TOPIC_USER

<form method="post" action="%action%" onsubmit="javascript: return true; forum_check_form(this);">

<div class="forum_add" style="width: 100%;">
<br />
<div>

<a name="add"></a>
	<span style="color: #000;">Название темы:</span>
	<input type="text" name="title" style="width: 90%;" class="textinputs" /><br /><br />

	<span style="color: #000;">Ваши комментарии:</span>
	<textarea name="body" id="forum_body" style="width: 90%; height: 240px;" class="textinputs"></textarea>
	%smiles%
	<p><input type="submit" value="Отправить" /></p>

</div>
<br />
</div>

<input type="hidden" name="login" disabled="disabled" />
</form>

ADD_TOPIC_USER;


$FORMS['add_topic_guest'] = <<<ADD_TOPIC_GUEST

<form method="post" action="%action%" onsubmit="javascript: return true; forum_check_form(this);">

<div class="forum_add" style="width: 100%;">
<br />
<div>

<a name="add"></a>
	<span style="color: #000;">Ваше имя:</span>
	<input type="text" name="login" style="width: 90%;" /><br /><br />
	<span style="color: #000;">Ваше email:</span>
	<input type="text" name="email" style="width: 90%;" value="" /><br /><br />
	<span style="color: #000;">Название темы:</span>
	<input type="text" name="title" style="width: 90%;" class="textinputs" /><br /><br />
	%system captcha()%
	<span style="color: #000;">Ваши комментарии:</span>
	<textarea name="body" id="forum_body" style="width: 90%; height: 240px;" class="textinputs"></textarea>
	%smiles%
	<p><input type="submit" value="Отправить" /></p>
</div>

<br />
</div>

</form>

ADD_TOPIC_GUEST;




$FORMS['add_topic_unauth'] = <<<ADD_TOPIC_UNAUTH

Для создания топиков необходимо <a href="%pre_lang%/forum/registrate/">зарегистрироваться</a>.

ADD_TOPIC_UNAUTH;

$FORMS['add_message_unauth'] = <<<ADD_MESSAGE_UNAUTH

Для добавления сообщений необходимо <a href="%pre_lang%/forum/registrate/">зарегистрироваться</a>.

ADD_MESSAGE_UNAUTH;

$FORMS['num_block'] = <<<NUM_BLOCK

Страницы: %items%&nbsp;&nbsp;&nbsp;%show_all%

NUM_BLOCK;

$FORMS['num_item'] = <<<NUM_ITEM

<a href="%link%"><b>%num%</b></a>%quant%

NUM_ITEM;

$FORMS['num_item_a'] = <<<NUM_ITEM_A

<span class="num_a">%num%</span>%quant%

NUM_ITEM_A;

$FORMS['num_quant'] = <<<NUM_QUANT

&nbsp;

NUM_QUANT;

$FORMS['num_show_all'] = <<<NUM_SHOW_ALL
<a href="%link%">Показать все</a>
NUM_SHOW_ALL;




$FORMS['conf_last_message'] = <<<END

<a href="%link%">%name%</a><br />

%system convertDate(%publish_time%, 'd.m.Y в H:i')%<br />
%users viewAuthor(%author_id%, 'default')%

END;

$FORMS['topic_last_message'] = <<<END

<a href="%link%">%name%</a><br />

%system convertDate(%publish_time%, 'd.m.Y в H:i')%<br />
%users viewAuthor(%author_id%, 'default')%

END;


$FORMS['smiles'] = <<<END
<div class="smiles">
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/1.gif" alt="1"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/2.gif" alt="2"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/3.gif" alt="3"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/4.gif" alt="4"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/5.gif" alt="5"></a>
	
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/6.gif" alt="6"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/7.gif" alt="7"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/8.gif" alt="8"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/9.gif" alt="9"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/10.gif" alt="10"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/11.gif" alt="11"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/12.gif" alt="12"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/13.gif" alt="13"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/14.gif" alt="14"></a>
	
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/15.gif" alt="15"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/16.gif" alt="16"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/17.gif" alt="17"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/18.gif" alt="18"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/19.gif" alt="19"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this); return false;"><img src="/templates/demoold/images/forum/smiles/20.gif" alt="20"></a>
</div>
END;

?>
