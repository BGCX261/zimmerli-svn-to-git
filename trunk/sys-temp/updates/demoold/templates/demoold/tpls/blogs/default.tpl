<?php
$s_blogs_JSToCheckForm = <<<END
	 <script type="text/javascript">
	 	function blogs_checkFrmToAdd(oForm) {
	 		var bPermit = true;
	 		//
	 		var arrFields = oForm.elements;
	 		var i = 0;
	 		for (i=0; i<arrFields.length; i++) {
				var theFld = arrFields[i];
				var sName = theFld.name;
	 			if (sName === 'title' || sName === 'message' || sName === 'author_nick') {
	 				var sValue = theFld.value;
	 				if (!sValue.length) {
	 					bPermit = false;
	 					break;
	 				}
	 			}
	 		}
	 		//
	 		if (!bPermit) alert("%blogs::LBL_TPL_NEEDFILLREQFIELDS%");
	 		//
	 		return bPermit;
	 	}
	 </script>
END;

$FORMS = Array();
// ==== blogmessages ===========================================================
// ==== для вывода блога и списка его постов макросом %blog%
// блок оформления для содержимого страницы типа "Блог"
$FORMS['blogmessages_itemslent'] = <<<END
	{$s_blogs_JSToCheckForm}
	%err_message%
	%parent%
	<p><h3>Сообщения :</h3><br/></p>
	%children%
	%system numpages(%total%, %per_page%, 'default')%
	%form_to_add%
END;
// == %parent% - карточка самого блога
$FORMS['blogmessages_parentitem'] = <<<END
	<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;margin-bottom:24px;background-color:#f0f0f0;">
		<!-- blog hat - publish time + remove link -->
		<div style="padding:4px;margin:1px;background-color:#dddddd;"><strong>%system convertDate(%publish_time%, 'd.m.Y H:i')%</strong>%link_to_remove_item% | приватность: %ttl_privacy%</div>
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
					<h3 style="padding-bottom:0px;margin-bottom:0px;color:#666666;">%header%</h3>
					<div style="margin-top:4px;margin-bottom:12px;height:1px;overflow:hidden;background-color:#666666;"> </div>
					<p>%content%</p>
				</div>
				<!-- count_subitems -->
				<div style="margin-top:8px;">
					%blogs::LBL_TPL_OFTHEMESSAGES%: %blogs countSubitems(%id%)% %link_to_add_item%
				</div>
			</td>
		</tr></tbody></table>
	</div>
END;
// == %tags% blocks for %parent% :
$FORMS['blogmessages_partags_empty'] = "";
$FORMS['blogmessages_partags'] = "";
$FORMS['blogmessages_partag'] = "";
$FORMS['blogmessages_partagseparator'] = "";
// == %children% - как формировать каждый пост
$FORMS['blogmessages_lentitem'] = <<<END
	<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;margin-bottom:16px;background-color:#f0f0f0;">
		<!-- message hat - publish time + remove link + message author -->
		<div style="padding:4px;margin:1px;background-color:#e4e4e4;">
			<strong>%system convertDate(%publish_time%, 'd.m.Y H:i')%</strong> | 
			%users viewAuthor(%author_id%)%
			%link_to_remove_item% | приватность: %ttl_privacy%
		</div>
		<!-- blog body -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr>
			<!-- message and count_subitems -->
			<td style="padding:4px;padding-right:6px;padding-left:6px;" valign="top">
				<!-- blog message -->
				<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;padding:8px;background-color:#f8f8f8;">
					<strong style="color:#666666;">%header%</strong>
					<div style="margin-top:4px;margin-bottom:12px;height:1px;overflow:hidden;background-color:#666666;"> </div>
					<p>%content%</p>
				</div>
				<!-- item tags -->
				%tags%
				<!-- count_subitems -->
				<div style="margin-top:8px;">
					<a href="%link%#subitems">%blogs::LBL_TPL_COMMENTS% (%blogs countSubitems(%id%, 100)%)</a> %link_to_add_item%
				</div>
			</td>
		</tr></tbody></table>
	</div>
END;
// == %tags% blocks for %blogmessages_lentitem% :
$FORMS['blogmessages_itemtags_empty'] = "";
$FORMS['blogmessages_itemtags'] = "Тэги: %items%";
$FORMS['blogmessages_itemtag'] = "<a href=\"%module_http_path%/tag_messages/%tag_urlencoded%\">%tag%</a>";
$FORMS['blogmessages_itemtagseparator'] = ", ";
// == %form_to_add% (обрабатывается в blogmessages_itemslent)
// для добавления поста к своему блогу
$FORMS['form_to_add_message'] = <<<END
	<br/><hr/><br/><br/>
	<form name="frm_addblogmsg" method="post" action="%module_http_path%/post/%parent_id%/" onsubmit="return blogs_checkFrmToAdd(this);">
		<table cellspacing="5" cellpadding="0" border="0"><tbody>
			<tr><td>
				* %blogs::LBL_TPL_MESSAGETITLE%:<a name="additem">&nbsp;</a><br />
				<input type="text" name="title" size="50" style="width: 350px;" class="textinputs" />
			</td></tr><tr><td>
				* %blogs::LBL_TPL_MESSAGETEXT%:<br />
				<textarea name="message" style="width: 350px; height: 120px;" class="textinputs"></textarea>
			</td></tr><tr><td>
				%blogs::LBL_TPL_PRIVACY%:<br />
				%input_privacy%
			</td></tr><tr><td>
				* %blogs::LBL_TPL_REQFIELDSWARNING%:
			</td></tr><tr><td>
				%blogs::LBL_TPL_MESSAGETAGS%:<br />
				<textarea name="tags" style="width: 350px; height: 120px;" class="textinputs"></textarea>
			</td></tr><tr><td>
				<input type="submit" value="%blogs::LBL_TPL_ADDMESSAGE%" />
			</td></tr>
		</tbody></table>
	</form>
END;
// если приватность не позволяет (т.е. всем, кроме владельца и супервайзеров)
$FORMS['form_to_add_message_denied'] = "";
// == %link_to_add_item% - обрабатывается в %parent%
// ссылка типа "добавить сообщение к блогу" (видима только владельцу блога)
$FORMS['link_to_add_message'] = <<<END
| <a href="%link%#additem" class="link">%blogs::LBL_TPL_ADDMESSAGE%</a>
END;
// "добавить сообщение к блогу" для всех остальных
$FORMS['link_to_add_message_denied'] = "";
// =============================================================================
// ==== blogmsgcomments ========================================================
// ====  для вывода поста блога и списка его комментов макросом %blog_message%
// блок оформления для содержимого страницы типа "Сообщение блога"
$FORMS['blogmsgcomments_itemslent'] = <<<END
	{$s_blogs_JSToCheckForm}
	%err_message%
	%parent%
	<p><h3>Комментарии :</h3><br/></p>
	%children%
	%system numpages(%total%, %per_page%, 'default')%
	%form_to_add%
END;
// == %parent% - карточка самого сообщения
$FORMS['blogmsgcomments_parentitem'] = <<<END
	<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;margin-bottom:24px;background-color:#f0f0f0;">
		<!-- blog hat - publish time + remove link -->
		<div style="padding:4px;margin:1px;background-color:#dddddd;"><strong>%system convertDate(%publish_time%, 'd.m.Y H:i')%</strong>%link_to_remove_item%</div>
		<!-- blog body -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr>
			<!-- blog author (owner) -->
			<td style="width:20%;padding:8px;" valign="top">
				%users viewAuthor(%author_id%)%
				<br/>
				%tags%
			</td>
			<!-- blog message and count_subitems -->
			<td style="width:80%;padding:4px;padding-right:6px;" valign="top">
				<!-- blog message -->
				<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;padding:8px;background-color:#f8f8f8;">
					<h3 style="padding-bottom:0px;margin-bottom:0px;color:#666666;">%header%</h3>
					<div style="margin-top:4px;margin-bottom:12px;height:1px;overflow:hidden;background-color:#666666;"> </div>
					<p>%content%</p>
				</div>
				<!-- count_subitems -->
				<div style="margin-top:8px;">
					%blogs::LBL_TPL_OFTHECOMMENTS%: %blogs countSubitems(%id%, 100)% %link_to_add_item% | <a href="%parent_link%">На уровень выше</a>
				</div>
			</td>
		</tr></tbody></table>
	</div>
END;
// == %tags% blocks for %parent% :
$FORMS['blogmsgcomments_partags_empty'] = "";
$FORMS['blogmsgcomments_partags'] = "Тэги: %items%";
$FORMS['blogmsgcomments_partag'] = "<a href=\"%module_http_path%/tag_messages/%tag_urlencoded%\">%tag%</a>";
$FORMS['blogmsgcomments_partagseparator'] = ", ";
// == %children% - как формировать каждый коммент
$FORMS['blogmsgcomments_lentitem'] = <<<END
	<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;margin-bottom:16px;background-color:#f0f0f0;">
		<!-- message hat - publish time + remove link + message author -->
		<div style="padding:4px;margin:1px;background-color:#e4e4e4;">
			<strong>%system convertDate(%publish_time%, 'd.m.Y H:i')%</strong> | 
			%users viewAuthor(%author_id%)%
			%link_to_remove_item%
		</div>
		<!-- blog body -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr>
			<!-- comment and count_subitems -->
			<td style="padding:4px;padding-right:6px;padding-left:6px;" valign="top">
				<!-- blog message -->
				<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;padding:8px;background-color:#f8f8f8;">
					<strong style="color:#666666;">%header%</strong>
					<div style="margin-top:4px;margin-bottom:12px;height:1px;overflow:hidden;background-color:#666666;"> </div>
					<p>%content%</p>
				</div>
				<!-- count_subitems -->
				<div style="margin-top:8px;">
					<a href="%link%#subitems">%blogs::LBL_TPL_COMMENTS% (%blogs countSubitems(%id%, 100)%)</a> %link_to_add_item%
				</div>
			</td>
		</tr></tbody></table>
		<div style="margin:6px;margin-left:24px;margin-right:8px;">%subitems%</div>
	</div>
END;
// == %form_to_add% (обрабатывается в blogmsgcomments_itemslent)
// для добавления коммента к посту своего блога
$FORMS['form_to_add_comment_blogowner'] = <<<END
	<br/><hr/><br/><br/>
	<form name="frm_addblogmsg" method="post" action="%module_http_path%/post/%parent_id%/" onsubmit="return blogs_checkFrmToAdd(this);">
		<table cellspacing="5" cellpadding="0" border="0"><tbody>
			<tr><td>
				* %blogs::LBL_TPL_COMMENTTITLE%:<a name="additem">&nbsp;</a><br />
				<input type="text" name="title" size="50" style="width: 350px;" class="textinputs" />
			</td></tr><tr><td>
				* %blogs::LBL_TPL_COMMENTTEXT%:<br />
				<textarea name="message" style="width: 350px; height: 120px;" class="textinputs"></textarea>
			</td></tr><tr><td>
				%blogs::LBL_TPL_PRIVACY%:<br />
				%input_privacy%
			</td></tr><tr><td>
				* %blogs::LBL_TPL_REQFIELDSWARNING%:
			</td></tr><tr><td>
				<input type="submit" value="%blogs::LBL_TPL_ADDCOMMENT%" />
			</td></tr>
		</tbody></table>
	</form>
END;
// для добавления коммента к посту зарегистрированным пользователем
$FORMS['form_to_add_comment_user'] = <<<END
	<br/><hr/><br/><br/>
	<form name="frm_addblogmsg" method="post" action="%module_http_path%/post/%parent_id%/" onsubmit="return blogs_checkFrmToAdd(this);">
		<table cellspacing="5" cellpadding="0" border="0"><tbody>
			<tr><td>
				* %blogs::LBL_TPL_COMMENTTITLE%:<a name="additem">&nbsp;</a><br />
				<input type="text" name="title" size="50" style="width: 350px;" class="textinputs" />
			</td></tr><tr><td>
				* %blogs::LBL_TPL_COMMENTTEXT%:<br />
				<textarea name="message" style="width: 350px; height: 120px;" class="textinputs"></textarea>
			</td></tr><tr><td>
				* %blogs::LBL_TPL_REQFIELDSWARNING%:
			</td></tr><tr><td>
				<input type="submit" value="%blogs::LBL_TPL_ADDCOMMENT%" />
			</td></tr>
		</tbody></table>
	</form>
END;
// для добавления коммента к посту незарегистрированным пользователем
$FORMS['form_to_add_comment_guest'] = <<<END
	<br/><hr/><br/><br/>
	<form name="frm_addblogmsg" method="post" action="%module_http_path%/post/%parent_id%/" onsubmit="return blogs_checkFrmToAdd(this);">
		<table cellspacing="5" cellpadding="0" border="0"><tbody>
			<tr><td>
				* %blogs::LBL_TPL_COMMENTTITLE%:<a name="additem">&nbsp;</a><br />
				<input type="text" name="title" size="50" style="width: 350px;" class="textinputs" />
			</td></tr><tr><td>
				* %blogs::LBL_TPL_YOURNICK%:<br />
				<input type="text" name="author_nick" style="width: 350px;" class="textinputs" />
			</td></tr><tr><td>
				%blogs::LBL_TPL_YOUREMAIL%:<br />
				<input type="text" name="author_email" style="width: 350px;" class="textinputs" />
			</td></tr><tr><td>
				* %blogs::LBL_TPL_COMMENTTEXT%:<br />
				<textarea name="message" style="width: 350px; height: 120px;" class="textinputs"></textarea>
			</td></tr><tr><td>
				%system captcha('default')%
			</td></tr><tr><td>
				* %blogs::LBL_TPL_REQFIELDSWARNING%:
			</td></tr><tr><td>
				<input type="submit" value="%blogs::LBL_TPL_ADDCOMMENT%" />
			</td></tr>
		</tbody></table>
	</form>
END;
// если приватность не позволяет
$FORMS['form_to_add_comment_denied'] = "";
// == %link_to_add_item% - обрабатывается в %parent%
// ссылка типа "добавить комментарий" - для владельца блога
$FORMS['link_to_add_comment_blogowner'] = <<<END
 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий" - для авторизованных
$FORMS['link_to_add_comment_user'] = <<<END
 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий" - для гостей
$FORMS['link_to_add_comment_guest'] = <<<END
 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий" - если приватность не позволяет
$FORMS['link_to_add_comment_denied'] = "";
// =============================================================================
// ==== blogcmntcomments =======================================================
// ====  для вывода коммента и его подкомментариев макросом %blog_comment%
// блок оформления для содержимого страницы типа "Комментарий к сообщению"
$FORMS['blogcmntcomments_itemslent'] = <<<END
	{$s_blogs_JSToCheckForm}
	%err_message%
	%toppost%
	%parent%
	<p><h3>Комментарии :</h3><br/></p>
	%children%
	%system numpages(%total%, %per_page%, 'default')%
	%form_to_add%
END;
// == %toppost% верхнее сообщение (пост) для подветки комментов
$FORMS['blogcmntcomments_toppost'] = <<<END
	<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;margin-bottom:24px;background-color:#f0f0f0;">
		<!-- blog hat - publish time + remove link -->
		<div style="padding:4px;margin:1px;background-color:#dddddd;"><strong>%system convertDate(%publish_time%, 'd.m.Y H:i')%</strong></div>
		<!-- blog body -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr>
			<!-- blog author (owner) -->
			<td style="width:20%;padding:8px;" valign="top">
				%users viewAuthor(%author_id%)%
				%tags%
			</td>
			<!-- blog message and count_subitems -->
			<td style="width:80%;padding:4px;padding-right:6px;" valign="top">
				<!-- blog message -->
				<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;padding:8px;background-color:#f8f8f8;">
					<h3 style="padding-bottom:0px;margin-bottom:0px;color:#666666;">%header%</h3>
					<div style="margin-top:4px;margin-bottom:12px;height:1px;overflow:hidden;background-color:#666666;"> </div>
					<p>%content%</p>
				</div>
			</td>
		</tr></tbody></table>
	</div>
END;
// == %tags% blocks for %toppost% :
$FORMS['blogcmntcomments_posttags_empty'] = "";
$FORMS['blogcmntcomments_posttags'] = "";
$FORMS['blogcmntcomments_posttag'] = "";
$FORMS['blogcmntcomments_posttagseparator'] = "";
// == %parent% - комментарий, который корень подветки
$FORMS['blogcmntcomments_parentitem'] = <<<END
	<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;margin-bottom:16px;background-color:#f0f0f0;">
		<!-- message hat - publish time + remove link + message author -->
		<div style="padding:4px;margin:1px;background-color:#e4e4e4;">
			<strong>%system convertDate(%publish_time%, 'd.m.Y H:i')%</strong> | 
			%users viewAuthor(%author_id%)%
			%link_to_remove_item%
		</div>
		<!-- blog body -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr>
			<!-- comment and count_subitems -->
			<td style="padding:4px;padding-right:6px;padding-left:6px;" valign="top">
				<!-- blog message -->
				<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;padding:8px;background-color:#f8f8f8;">
					<strong style="color:#666666;">%header%</strong>
					<div style="margin-top:4px;margin-bottom:12px;height:1px;overflow:hidden;background-color:#666666;"> </div>
					<p>%content%</p>
				</div>
				<!-- count_subitems -->
				<div style="margin-top:8px;">
					%blogs::LBL_TPL_OFTHECOMMENTS%: %blogs countSubitems(%id%, 100)% %link_to_add_item% | <a href="%parent_link%">На уровень выше</a>
				</div>
			</td>
		</tr></tbody></table>
	</div>
END;
// == %children% - список комментариев подветки
$FORMS['blogcmntcomments_lentitem'] = <<<END
	<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;margin-bottom:16px;background-color:#f0f0f0;">
		<!-- message hat - publish time + remove link + message author -->
		<div style="padding:4px;margin:1px;background-color:#e4e4e4;">
			<strong>%system convertDate(%publish_time%, 'd.m.Y H:i')%</strong> | 
			%users viewAuthor(%author_id%)%
			%link_to_remove_item%
		</div>
		<!-- blog body -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr>
			<!-- comment and count_subitems -->
			<td style="padding:4px;padding-right:6px;padding-left:6px;" valign="top">
				<!-- blog message -->
				<div style="border-style:solid;border-color:#d0d0d0;border-width:1px;padding:8px;background-color:#f8f8f8;">
					<strong style="color:#666666;">%header%</strong>
					<div style="margin-top:4px;margin-bottom:12px;height:1px;overflow:hidden;background-color:#666666;"> </div>
					<p>%content%</p>
				</div>
				<!-- count_subitems -->
				<div style="margin-top:8px;">
					<a href="%link%#subitems">%blogs::LBL_TPL_COMMENTS% (%blogs countSubitems(%id%, 100)%)</a> %link_to_add_item%
				</div>
			</td>
		</tr></tbody></table>
	</div>

END;
// == %form_to_add% (обрабатывается в blogcmntcomments_itemslent)
// для добавления подкоммента к комменту своего блога
$FORMS['form_to_add_subcomment_blogowner'] = <<<END
	<br/><hr/><br/><br/>
	<form name="frm_addblogmsg" method="post" action="%module_http_path%/post/%parent_id%/" onsubmit="return blogs_checkFrmToAdd(this);">
		<table cellspacing="5" cellpadding="0" border="0"><tbody>
			<tr><td>
				* %blogs::LBL_TPL_COMMENTTITLE%:<a name="additem">&nbsp;</a><br />
				<input type="text" name="title" size="50" style="width: 350px;" class="textinputs" />
			</td></tr><tr><td>
				* %blogs::LBL_TPL_COMMENTTEXT%:<br />
				<textarea name="message" style="width: 350px; height: 120px;" class="textinputs"></textarea>
			</td></tr><tr><td>
				%blogs::LBL_TPL_PRIVACY%:<br />
				%input_privacy%
			</td></tr><tr><td>
				* %blogs::LBL_TPL_REQFIELDSWARNING%:
			</td></tr><tr><td>
				<input type="submit" value="%blogs::LBL_TPL_ADDCOMMENT%" />
			</td></tr>
		</tbody></table>
	</form>
END;
// для добавления подкоммента к комменту зарегистрированным пользователем
$FORMS['form_to_add_subcomment_user'] = <<<END
	<br/><hr/><br/><br/>
	<form name="frm_addblogmsg" method="post" action="%module_http_path%/post/%parent_id%/" onsubmit="return blogs_checkFrmToAdd(this);">
		<table cellspacing="5" cellpadding="0" border="0"><tbody>
			<tr><td>
				* %blogs::LBL_TPL_COMMENTTITLE%:<a name="additem">&nbsp;</a><br />
				<input type="text" name="title" size="50" style="width: 350px;" class="textinputs" />
			</td></tr><tr><td>
				* %blogs::LBL_TPL_COMMENTTEXT%:<br />
				<textarea name="message" style="width: 350px; height: 120px;" class="textinputs"></textarea>
			</td></tr><tr><td>
				* %blogs::LBL_TPL_REQFIELDSWARNING%:
			</td></tr><tr><td>
				<input type="submit" value="%blogs::LBL_TPL_ADDCOMMENT%" />
			</td></tr>
		</tbody></table>
	</form>
END;
// для добавления подкоммента к комменту незарегистрированным пользователем
$FORMS['form_to_add_subcomment_guest'] = <<<END
	<br/><hr/><br/><br/>
	<form name="frm_addblogmsg" method="post" action="%module_http_path%/post/%parent_id%/" onsubmit="return blogs_checkFrmToAdd(this);">
		<table cellspacing="5" cellpadding="0" border="0"><tbody>
			<tr><td>
				* %blogs::LBL_TPL_COMMENTTITLE%:<a name="additem">&nbsp;</a><br />
				<input type="text" name="title" size="50" style="width: 350px;" class="textinputs" />
			</td></tr><tr><td>
				* %blogs::LBL_TPL_YOURNICK%:<br />
				<input type="text" name="author_nick" style="width: 350px;" class="textinputs" />
			</td></tr><tr><td>
				%blogs::LBL_TPL_YOUREMAIL%:<br />
				<input type="text" name="author_email" style="width: 350px;" class="textinputs" />
			</td></tr><tr><td>
				* %blogs::LBL_TPL_COMMENTTEXT%:<br />
				<textarea name="message" style="width: 350px; height: 120px;" class="textinputs"></textarea>
			</td></tr><tr><td>
				%system captcha('default')%
			</td></tr><tr><td>
				* %blogs::LBL_TPL_REQFIELDSWARNING%:
			</td></tr><tr><td>
				<input type="submit" value="%blogs::LBL_TPL_ADDCOMMENT%" />
			</td></tr>
		</tbody></table>
	</form>
END;
// если приватность не позволяет
$FORMS['form_to_add_subcomment_denied'] = "";
// == %link_to_add_item% - обрабатывается в %parent%
// ссылка типа "добавить комментарий" - для владельца блога
$FORMS['link_to_add_subcomment_blogowner'] = <<<END
 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий" - для авторизованных
$FORMS['link_to_add_subcomment_user'] = <<<END
 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий" - для гостей
$FORMS['link_to_add_subcomment_guest'] = <<<END
 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий" - если приватность не позволяет
$FORMS['link_to_add_subcomment_denied'] = "";
// =============================================================================
// ==== shared blocks ==========================================================
// == %link_to_add_item% - обрабатывается в %children%'ах, которые посты
// ссылка типа "добавить комментарий к данному посту" - для владельца блога
$FORMS['cardlink_to_add_comment_blogowner'] = <<<END
	 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий к данному посту" - для авторизованных
$FORMS['cardlink_to_add_comment_user'] = <<<END
	 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий к данному посту" - для гостей
$FORMS['cardlink_to_add_comment_guest'] = <<<END
	 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий к данному посту" - если приватность не позволяет
$FORMS['cardlink_to_add_comment_denied'] = <<<END
	 | <a href="%link%#additem">Комментировать</a>
END;
// == %link_to_add_item% - обрабатывается в %children%'ах, которые комменты
// ссылка типа "добавить комментарий к данному комменту" - для владельца блога
$FORMS['cardlink_to_add_subcomment_blogowner'] = <<<END
	 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий к данному комменту" - для авторизованных
$FORMS['cardlink_to_add_subcomment_user'] = <<<END
	 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий к данному комменту" - для гостей
$FORMS['cardlink_to_add_subcomment_guest'] = <<<END
	 | <a href="%link%#additem">Комментировать</a>
END;
// ссылка типа "добавить комментарий к данному комменту" - если приватность не позволяет
$FORMS['cardlink_to_add_subcomment_denied'] = "";
// ================================================================
// %link_to_remove_item% - кнопка "удалить"
$FORMS['link_to_remove_item'] = <<<END
 | <a href="%module_http_path%/remove/%id%/">Удалить</a>
END;
// ================================================================
// %link_to_edit_item% - кнопка "редактировать" для блога
$FORMS['link_to_edit_blog'] = <<<END
| <a href="%module_http_path%/edit/%id%/" class="link">Редактировать</a>
END;
// %link_to_edit_item% - кнопка "редактировать" для сообщения
$FORMS['link_to_edit_message'] = <<<END
| <a href="%module_http_path%/edit/%id%/" class="link">Редактировать</a>
END;
// %link_to_edit_item% - кнопка "редактировать" для комментария
$FORMS['link_to_edit_comment'] = <<<END
| <a href="%module_http_path%/edit/%id%/" class="link">Редактировать</a>
END;
// ================================================================
$FORMS['err_message'] = <<<END
	<div style="margin:8px;border-style:solid;border-color:red;border-width:1px;color:red;">
		<strong>%err_title%</strong>:<br/>
		%err_description%
	</div>
	<br/><hr/><br/><br/>
END;
// 1. invalid parent id
$FORMS['err_title_1'] = "Can not append Your message";
$FORMS['err_descr_1'] = "invalid parent id";
// 2. invalid parent element
$FORMS['err_title_2'] = "Can not append Your message";
$FORMS['err_descr_2'] = "invalid parent element";
// 3. invalid parent element type
$FORMS['err_title_3'] = "Can not append Your message";
$FORMS['err_descr_3'] = "invalid parent element type";
// 4. access denied by privacy status
$FORMS['err_title_4'] = "Can not append Your message";
$FORMS['err_descr_4'] = "access denied by privacy status";
// 5. invalid captcha
$FORMS['err_title_5'] = "Can not append Your message";
$FORMS['err_descr_5'] = "invalid captcha";
// 5. required fields
$FORMS['err_title_6'] = "Can not append Your message";
$FORMS['err_descr_6'] = "fill all required fields";
// ================================================================
?>