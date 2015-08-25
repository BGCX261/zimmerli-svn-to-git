<?php
$FORMS = array();

$FORMS['lblogs_lent_empty'] = <<<END
END;
$FORMS['lblogs_lent'] = <<<END
%rows%
%system numpages(%total%, %per_page%, 'standart')%
END;
$FORMS['lblogs_lentitem'] = <<<END
	<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;margin-bottom:12px;margin-top:12px;background-color:#f0f0f0;">
		<!-- blog hat - publish time -->
		<div style="padding:4px;margin:1px;background-color:#dddddd;"><strong>%system convertDate(%publish_time%, 'd.m.Y H:i')%</strong></div>
		<!-- blog body -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr>
			<!-- blog author (owner) -->
			<td style="width:20%;padding:8px;" valign="top">
				%users viewAuthor(%author_id%)%
			</td>
			<!-- blog message and count_subitems -->
			<td style="width:80%;padding:4px;padding-right:6px;" valign="top">
				<!-- blog message -->
				<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;padding:8px;background-color:#f8f8f8;">
					<a href="%link%"><h3 style="padding-bottom:0px;margin-bottom:0px;color:#666666;">%header%</h3></a>
					<div style="margin-top:4px;margin-bottom:12px;height:1px;overflow:hidden;background-color:#666666;"> </div>
					<p>%content%</p>
				</div>
				<!-- count_subitems -->
				<div style="margin-top:8px;">
					<a href="%link%">%blogs::LBL_TPL_OFTHEMESSAGES%: %blogs countSubitems(%id%)%</a>
					<br/><br/>
					Последнее сообщение:
					%system convertDate(%lmessage_time%, 'd.m.Y H:i')%
					<br/><br/>
					Последнмй комментарий:
					%system convertDate(%lcomment_time%, 'd.m.Y H:i')%
				</div>
			</td>
		</tr></tbody></table>
	</div>
END;
// tags (for blogs)
$FORMS['lblogs_lentitem_tags_empty'] = "";
$FORMS['lblogs_lentitem_tags'] = <<<END
	<div style="margin-top:8px;">
	Теги:<br/>
	%items%
	<div>
END;
$FORMS['lblogs_lentitem_tag'] = <<<END
	<a href="%module_http_path%/tag_messages/%tag_urlencoded%">%tag%</a>
END;
$FORMS['lblogs_lentitem_tagseparator'] = <<<END
	, 
END;
/*
%lmessages(...)% :
	lmessages_lent :
		- rows
		- total
	lmessages_lentitem :
		- publish_time (timestamp)
		- author_id
		- header
		- content
		- id
		- link
*/
$FORMS['lmessages_lent_empty'] = <<<END
END;
$FORMS['lmessages_lent'] = <<<END
%rows%
END;
$FORMS['lmessages_lentitem'] = <<<END
	<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;margin-bottom:12px;margin-top:12px;background-color:#f0f0f0;">
		<!-- hat - publish time -->
		<div style="padding:4px;margin:1px;background-color:#dddddd;"><strong>%system convertDate(%publish_time%, 'd.m.Y H:i')%</strong></div>
		<!-- blog body -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr>
			<!-- blog author (owner) -->
			<td style="width:20%;padding:8px;" valign="top">
				%users viewAuthor(%author_id%)%
			</td>
			<!-- post message and count_subitems -->
			<td style="width:80%;padding:4px;padding-right:6px;" valign="top">
				<!-- blog message -->
				<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;padding:8px;background-color:#f8f8f8;">
					<a href="%link%"><h3 style="padding-bottom:0px;margin-bottom:0px;color:#666666;">%header%</h3></a>
					<div style="margin-top:4px;margin-bottom:12px;height:1px;overflow:hidden;background-color:#666666;"> </div>
					<p>%content%</p>
				</div>
				<!-- item tags -->
				%tags%
				<!-- count_subitems -->
				<div style="margin-top:8px;">
					<a href="%link%">%blogs::LBL_TPL_OFTHECOMMENTS%: %blogs countSubitems(%id%, 100)%</a>
				</div>
			</td>
		</tr></tbody></table>
	</div>
END;
// tags (for posts)
$FORMS['lmessages_lentitem_tags_empty'] = "";
$FORMS['lmessages_lentitem_tags'] = <<<END
	<div style="margin-top:8px;">
	Теги:<br/>
	%items%
	<div>
END;
$FORMS['lmessages_lentitem_tag'] = <<<END
	<a href="%module_http_path%/tag_messages/%tag_urlencoded%">%tag%</a>
END;
$FORMS['lmessages_lentitem_tagseparator'] = <<<END
	, 
END;
/*
%lcomments(...)% :
	lcomments_lent :
		- rows
		- total
	lcomments_lentitem :
		- publish_time (timestamp)
		- author_id
		- header
		- content
		- id
		- link
*/
$FORMS['lcomments_lent_empty'] = <<<END
END;
$FORMS['lcomments_lent'] = <<<END
%rows%
END;
$FORMS['lcomments_lentitem'] = <<<END
	<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;margin-bottom:12px;margin-top:12px;background-color:#f0f0f0;">
		<!-- hat - publish time -->
		<div style="padding:4px;margin:1px;background-color:#dddddd;"><strong>%system convertDate(%publish_time%, 'd.m.Y H:i')%</strong></div>
		<!-- blog body -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr>
			<!-- blog author (owner) -->
			<td style="width:20%;padding:8px;" valign="top">
				%users viewAuthor(%author_id%)%
			</td>
			<!-- comment message and count_subitems -->
			<td style="width:80%;padding:4px;padding-right:6px;" valign="top">
				<!-- blog message -->
				<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;padding:8px;background-color:#f8f8f8;">
					<a href="%link%"><h3 style="padding-bottom:0px;margin-bottom:0px;color:#666666;">%header%</h3></a>
					<div style="margin-top:4px;margin-bottom:12px;height:1px;overflow:hidden;background-color:#666666;"> </div>
					<p>%content%</p>
				</div>
				<!-- count_subitems -->
				<div style="margin-top:8px;">
					<a href="%link%">%blogs::LBL_TPL_OFTHECOMMENTS%: %blogs countSubitems(%id%, 100)%</a>
				</div>
			</td>
		</tr></tbody></table>
	</div>
END;
// tags (for comments)
$FORMS['lcomment_lentitem_tags_empty'] = "";
$FORMS['lcomments_lentitem_tags'] = <<<END
	<div style="margin-top:8px;">
	Теги:<br/>
	%items%
	<div>
END;
$FORMS['lcomments_lentitem_tag'] = <<<END
	<a href="%module_http_path%/tag_messages/%tag_urlencoded%">%tag%</a>
END;
$FORMS['lcomments_lentitem_tagseparator'] = <<<END
	, 
END;
?>