<?php

$FORMS = Array();

$FORMS['captcha'] = <<<CAPTCHA

	<table border="0" cellpadding="2">
		<tr>
			<td width="200">
				Введите текст на картинке
			</td>

			<td>
				<img src="/captcha.php" style="border: #000 1px solid;" alt="" id="captcha_img" />
				<div style="margin-bottom:5px;">
					<span	style="border-bottom:1px dashed; cursor:pointer;"
							onclick="var d = new Date(); jQuery('#captcha_img').attr('src', '/captcha.php?reset&amp;' + d.getTime());">
						обновить текст
					</span>
				</div>
				<input type="text" id="%input_id%" name="captcha" class="textinputs" style="width:119px" />
			</td>
		</tr>
	</table>

CAPTCHA;
?>