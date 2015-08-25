<?php
$FORMS = Array();

$FORMS['settings_blogs_denied'] = "";

$FORMS['settings_blogs'] = <<<END
<tr>
	<td colspan="2" valign="top">
		&nbsp;
	</td>
</tr>
<tr>
	<td colspan="2" valign="top">
		<strong>%blogs::LBL_BLOGS%</strong>
	</td>
</tr>
<tr>
	<td colspan="2" valign="top">
		&nbsp;
	</td>
</tr>
%rows%
END;

// hidden field 'blog_id[%id%]' must present !!!
$FORMS['settings_blogrow'] = <<<END
<tr>
	<td colspan="2" valign="top" align="center"><b>%blog_name%</b></td>
</tr><tr>
	<td valign="top">%blogs::LBL_PAGEURL%:</td>
	<td valign="top"><a href="%blog_path%">%blog_path%</a></td>
</tr><tr>
	<td valign="top">%blogs::LBL_PGFLDS_NAME%:</td>
	<td valign="top"><input type="text" id="blog_name[%id%]" name="blog_name[%id%]" value="%blog_name%" style="width:360px;" /></td>
</tr><tr>
	<td valign="top">%blogs::LBL_PGFLDS_CONTENT%:</td>
	<td valign="top"><textarea id="blog_content[%id%]" name="blog_content[%id%]" style="width:360px;height:120px;">%blog_content%</textarea></td>
</tr><tr>
	<td valign="top">%blogs::LBL_TPL_PRIVACY%:</td>
	<td valign="top"><select id="blog_privacy[%id%]" name="blog_privacy[%id%]" style="width:360px;">%blog_privacy%</select></td>
</tr><tr>
	<td valign="top">%blogs::LBL_TPL_PRIVACYFORPOST%:</td>
	<td valign="top">%privacy_forpostonly%</td>
</tr><tr>
	<td valign="top">%blogs::LBL_TPL_FRIENDSLIST%:</td>
	<td valign="top"><select id="blog_prvlist_friends[%id%]" name="blog_prvlist_friends[%id%][]" multiple="multiple" style="width:360px;height:120px;">%blog_friends%</select></td>
</tr><tr>
	<td colspan="2" valign="top">
		&nbsp;<input type="hidden" name="blog_id[%id%]" value="%id%" />
	</td>
</tr>
END;

$FORMS['settings_addblog'] = <<<END
<tr>
	<td colspan="2" valign="top">%blogs::LBL_YOUCANADDBLOG%</td>
</tr><tr>
	<td colspan="2" valign="top">&nbsp;</td>
</tr><tr>
	<td colspan="2" valign="top">%blogs::LBL_PAGEURL%:</td>
</tr><tr>
	<td colspan="2" valign="top">%newblog_path_prefix%<input type="text" id="newblog_altname" name="newblog_altname" style="width:90px;" />%newblog_path_postfix%</td>
</tr>
END;
?>