<?php

$FORMS = Array();

$FORMS['comments_block'] = <<<COMMENT_BLOCK

<div style="clear: both;"></div>
<h3>Комментарии</h3>
<a name="comments"></a>

<div class="spacer"></div>

%lines%

%system numpages(%total%, %per_page%, 'default')%

<br />
%add_form%

COMMENT_BLOCK;


$FORMS['comments_block_line'] = <<<COMMENT_LINE_USER
<a name="%id%"></a>
<p><b class="s_num">%num%.</b> <b umi:element-id="%id%" umi:field-name="name" umi:delete="delete">%title%</b> - %users viewAuthor(%author_id%)%<br />
<i>%system convertDate(%publish_time%, 'Y-m-d в H:i')%</i></p>
<div umi:element-id="%id%" umi:field-name="message" umi:delete="delete">%message%</div>

COMMENT_LINE_USER;



$FORMS['comments_block_add_user'] = <<<ADD_FORM_USER

<form method="post" action="%action%">

<table cellspacing="5" cellpadding="0" border="0">
	<tr>
		<td>
			Заголовок комментария:<br />
			<input type="text" name="title" size="50" style="width: 350px;" class="textinputs" />
		</td>
	</tr>

	<tr>
		<td>
			Текст комментария:<br />
			<textarea id="message" name="comment" style="width: 350px; height: 120px;" class="textinputs"></textarea>
		</td>
	</tr>
	
	<tr>
		<td>
			%smiles%
		</td>
	</tr>

	<tr>
		<td>
			<input type="submit" value="Добавить комментарий" />
		</td>
	</tr>
</table>

</form>

ADD_FORM_USER;


$FORMS['comments_block_add_guest'] = <<<ADD_FORM_GUEST

<form method="post" action="%action%">

<table cellspacing="5" cellpadding="0" border="0" width="100%">
	<tr>
		<td nowrap="nowrap">
			Заголовок комментария:<br />
			<input type="text" name="title" style="width: 350px;" class="textinputs" />
		</td>
	</tr>

	<tr>
		<td nowrap="nowrap">
			Ваш ник:<br />
			<input type="text" name="author_nick" style="width: 350px;" class="textinputs" />
		</td>
	</tr>

	<tr>
		<td nowrap="nowrap">
			Ваш e-mail:<br />
			<input type="text" name="author_email" style="width: 350px;" class="textinputs" />
		</td>
	</tr>

	<tr>
		<td nowrap="nowrap">
			Текст комментария:<br />
			<textarea id="message" name="comment" style="width: 350px;height:120px" class="textinputs"></textarea>
		</td>
	</tr>

	<tr>
		<td>
			%system captcha('default')%
		</td>
	</tr>
	
	<tr>
		<td>
			%smiles%
		</td>
	</tr>

	<tr>
		<td>
			<input type="submit" value="Добавить комментарий" />
		</td>
	</tr>
</table>


</form>

ADD_FORM_GUEST;


$FORMS['smiles'] = <<<END
<div class="smiles">
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/1.gif" alt="1"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/2.gif" alt="2"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/3.gif" alt="3"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/4.gif" alt="4"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/5.gif" alt="5"></a>
	
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/6.gif" alt="6"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/7.gif" alt="7"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/8.gif" alt="8"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/9.gif" alt="9"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/10.gif" alt="10"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/11.gif" alt="11"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/12.gif" alt="12"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/13.gif" alt="13"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/14.gif" alt="14"></a>
	
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/15.gif" alt="15"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/16.gif" alt="16"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/17.gif" alt="17"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/18.gif" alt="18"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/19.gif" alt="19"></a>
	<a href="#" onclick="javascript: forum_insert_smile(this, '%element%'); return false;"><img src="/templates/demoold/images/forum/smiles/20.gif" alt="20"></a>
</div>
END;

?>