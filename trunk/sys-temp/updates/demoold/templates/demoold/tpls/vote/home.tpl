<?php

$FORMS = Array();

$FORMS['vote_block'] = <<<END


					<div id="vote" class="block">
						<h2>Голосование</h2>
						<p>%text%</p>
						<form method="post" name="postForm">
							%lines%
							%submit%
						</form>
					</div>

END;


$FORMS['vote_block_line'] = <<<END
							<div><input type="radio" name="vote_results" value="%item_id%" /> <span umi:object-id="%block-object-id%" umi:field-name="name">%item_name%</span></div>

END;

$FORMS['vote_block_submit'] = <<<END

<input type="button" value="Отправить" onclick="javscript: cms_vote_postDo('postForm', 'vote_results', '%vote_not_selected%'); return false;" />

END;


$FORMS['result_block'] = <<<END


					<div id="vote" class="block">
						<h2>Голосование</h2>
						<p>%question%</p>
						<form method="post" name="postForm">
							%lines%
						</form>

						<p>Всего голосов: %total_posts%</p>
					</div>
END;


$FORMS['result_block_line'] = <<<END

	<table width="150" cellspacing="0" cellpadding="0" style="border: #000 1px solid">
		<tr>
			<td style="width: %item_result_proc%px; background-color: red;" height="10"></td>
			<td style="width: %item_result_proc_reverce%px;"></td>
		</tr>
	</table>
<span umi:object-id="%block-object-id%" umi:field-name="name">%item_name%</span> (<span umi:object-id="%block-object-id%" umi:field-name="count">%item_result%</span> голосов)

END;

?>