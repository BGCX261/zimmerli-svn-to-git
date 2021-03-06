<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet SYSTEM "ulang://common">
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:umi="http://www.umi-cms.ru/TR/umi">

	<xsl:template match="object" mode="form-modify" priority="1">
		<xsl:variable name="permissions" select="document(concat('udata://users/choose_perms/', $param0))/udata" />

		<xsl:apply-templates select="properties/group" mode="form-modify">
			<xsl:with-param name="show-name" select="count(.//field[@name = 'nazvanie'])" />
		</xsl:apply-templates>

		<xsl:apply-templates select="$permissions" />
	</xsl:template>

	<xsl:template match="properties/group[@name = 'idetntify_data']" mode="form-modify">
		<xsl:param name="show-name"><xsl:text>1</xsl:text></xsl:param>
		<xsl:param name="show-type"><xsl:text>1</xsl:text></xsl:param>
		<div class="panel properties-group" name="g_{@name}">
			<div class="header">
				<span>
					<xsl:value-of select="@title" />
				</span>
				<div class="l" /><div class="r" />
			</div>
			<div class="content">
				<xsl:apply-templates select="field[@name = 'groups']" mode="form-modify" />
				<xsl:apply-templates select="field[@name != 'groups']" mode="form-modify" />
				<xsl:choose>
					<xsl:when test="$data-action = 'create'">
						<xsl:call-template name="std-form-buttons-add" />
					</xsl:when>
					<xsl:otherwise>
						<xsl:call-template name="std-form-buttons" />
					</xsl:otherwise>
				</xsl:choose>
			</div>
		</div>
	</xsl:template>
	
	<xsl:template match="properties/group[@name = 'more_info']" mode="form-modify">
		<xsl:param name="show-name"><xsl:text>1</xsl:text></xsl:param>
		<xsl:param name="show-type"><xsl:text>1</xsl:text></xsl:param>

		<div class="panel properties-group" name="g_{@name}">
			<div class="header">
				<span class="c">
					<xsl:value-of select="@title" />
				</span>
				<div class="l" /><div class="r" />
			</div>

			<div class="content">
				<div style="margin-bottom:13px;">
					<xsl:variable name="user-id" select="/result/data/object/@id" />
					<a href="{$lang-prefix}/admin/emarket/actAsUser/{$user-id}/">
						<xsl:attribute name="title">&label-act-as-user-tip;</xsl:attribute>
						<xsl:text>&label-act-as-user;</xsl:text>
					</a>
				</div>
				<xsl:apply-templates select="." mode="form-modify-group-fields">
					<xsl:with-param name="show-name" select="$show-name" />
					<xsl:with-param name="show-type" select="$show-type" />
				</xsl:apply-templates>

				<xsl:choose>
					<xsl:when test="$data-action = 'create'">
						<xsl:call-template name="std-form-buttons-add" />
					</xsl:when>
					<xsl:otherwise>
						<xsl:call-template name="std-form-buttons" />
					</xsl:otherwise>
				</xsl:choose>
			</div>
		</div>
	</xsl:template>

	<xsl:template match="field[@type = 'string' and @name = 'nazvanie']" mode="form-modify" />

	<xsl:template match="udata[@module = 'users' and @method = 'choose_perms']">
		<div class="panel properties-group">
			<div class="header">
				<span>
					<xsl:text>&permissions-panel;</xsl:text>
				</span>
				<div class="l" /><div class="r" />
			</div>

			<div class="content">
				<table class="tableContent permissions">
					<thead>
						<tr>
							<th>
								<xsl:text>&permissions-module;</xsl:text>
							</th>

							<th>
								<xsl:text>&permissions-use-access;</xsl:text>
							</th>

							<th>
								<xsl:text>&permissions-other-access;</xsl:text>
							</th>
						</tr>
					</thead>

					<tbody>
						<xsl:apply-templates select="module" />
					</tbody>
				</table>

				<xsl:choose>
					<xsl:when test="$data-action = 'create'">
						<xsl:call-template name="std-form-buttons-add" />
					</xsl:when>
					<xsl:otherwise>
						<xsl:call-template name="std-form-buttons" />
					</xsl:otherwise>
				</xsl:choose>
			</div>
		</div>
	</xsl:template>

	<xsl:template match="module[@name = 'config']" />

	<xsl:template match="module">
		<tr>
			<td>
				<div class="module_icon">
					<img src="/images/cms/admin/mac/icons/small/{@name}.png" />
					<xsl:value-of select="@label" />
				</div>
			</td>

			<td align="center">
				<input value="{@name}" name="ps_m_perms[{@name}]" type="hidden" />
				<input value="{@name}" name="m_perms[]" type="checkbox" class="check">
					<xsl:if test="@access > 0">
						<xsl:attribute name="checked"/>
					</xsl:if>
				</input>
			</td>

			<td>
				<xsl:if test="@name = 'content'">
					<ul style="margin-bottom:15px;">
						<xsl:apply-templates select="../domains/domain" />
					</ul>
				</xsl:if>

				<ul>
					<xsl:apply-templates select="option" />
				</ul>
			</td>
		</tr>
	</xsl:template>

	<xsl:template match="module/option">
		<li>
			<label>
				<input type="checkbox" name="{../@name}[{@name}]" class="check" value="1">
					<xsl:if test="@access > 0">
						<xsl:attribute name="checked" />
					</xsl:if>
				</input>
				<xsl:value-of select="@label" />
			</label>
		</li>
	</xsl:template>

	<xsl:template match="domains/domain">
		<li>
			<input type="hidden" name="domain[{@id}]" value="0"/>
			<label>
				<input type="checkbox" name="domain[{@id}]" value="1" class="check" >
					<xsl:if test="@access > 0">
						<xsl:attribute name="checked"/>
					</xsl:if>
				</input>
				<xsl:value-of select="@host" />
			</label>
		</li>
	</xsl:template>

	<xsl:template match="field[@name = 'groups' and document('udata://system/getGuideItemsCount/users-users/')/udata/items/@total &lt; 16]" mode="form-modify" priority="1">
		<dl class="field">
			<dt>
				<xsl:value-of select="@title" />
			</dt>

			<xsl:apply-templates select="values/item" mode="form-modify" />
		</dl>
	</xsl:template>

	<xsl:template match="field[@name = 'groups']/values/item" mode="form-modify" priority="1">
		<xsl:choose>
			<xsl:when test="document(concat('uobject://', @id))/udata/object/@guid = 'users-users-15'">
				<xsl:variable name="userInfo" select="document(concat('uobject://', $current-user-id))/udata/object" />
				<xsl:if test="$userInfo/@guid = 'system-supervisor' or count($userInfo//property[@name='groups']/value/item[@guid='users-users-15'])">
					<dd>
						<input type="hidden" name="{../../@input_name}" value="0" />
						<input type="checkbox" name="{../../@input_name}" value="{@id}" class="checkbox" id="group-{@id}">
							<xsl:if test="@selected = 'selected'">
								<xsl:attribute name="checked"><xsl:text>checked</xsl:text></xsl:attribute>
							</xsl:if>
						</input>
						<label for="group-{@id}">
							<xsl:value-of select="." />
						</label>
					</dd>
				</xsl:if>
			</xsl:when>
			<xsl:otherwise>
				<dd>
					<input type="hidden" name="{../../@input_name}" value="0" />
					<input type="checkbox" name="{../../@input_name}" value="{@id}" class="checkbox" id="group-{@id}">
						<xsl:if test="@selected = 'selected'">
							<xsl:attribute name="checked"><xsl:text>checked</xsl:text></xsl:attribute>
						</xsl:if>
					</input>
					<label for="group-{@id}">
						<xsl:value-of select="." />
					</label>
				</dd>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="/result[@method = 'add']//field[@name = 'is_activated' and @type = 'boolean']" mode="form-modify">
		<xsl:if test="preceding-sibling::field/@type != 'boolean'">
			<div style="clear: left;" />
		</xsl:if>
		<div class="field">
			<label for="{generate-id()}">
				<span class="label">
					<input type="hidden" name="{@input_name}" value="0" />
					<input type="checkbox" name="{@input_name}" value="1" id="{generate-id()}" checked="checked">
						<xsl:apply-templates select="." mode="required_attr">
							<xsl:with-param name="old_class" select="'checkbox'" />
						</xsl:apply-templates>
					</input>
					<acronym>
						<xsl:apply-templates select="." mode="sys-tips" />
						<xsl:value-of select="@title" />
					</acronym>
					<xsl:apply-templates select="." mode="required_text" />
				</span>
			</label>
		</div>
	</xsl:template>
	
	<xsl:template match="field[@name = 'filemanager_directory']" mode="form-modify" priority="1">		
		<xsl:variable name="userInfo" select="document(concat('uobject://', $current-user-id))/udata/object" />
		<xsl:if test="$userInfo/@guid = 'system-supervisor' or count($userInfo//property[@name='groups']/value/item[@guid='users-users-15'])">
			<div class="field">
				<label for="{generate-id()}">
					<span class="label">
						<acronym>
							<xsl:apply-templates select="." mode="sys-tips" />
							<xsl:value-of select="@title" />
						</acronym>
					</span>
					<span>
						<input id="{generate-id()}" class="string" type="text" value="{.}" name="{@input_name}"/>
					</span>
				</label>
			</div>
		</xsl:if>
	</xsl:template>
	
		<xsl:template match="properties/group[@name = 'statistic_info']" mode="form-modify">
		<div class="panel properties-group">
			<div class="header">
				<span>
					<xsl:value-of select="@title" />
				</span>
				<div class="l" /><div class="r" />
			</div>
			<div class="content">
				<xsl:if test="position() = 1 and not(/result/@method='template_add') and not(/result/@method='template_edit')">
					<div class="field">
						<label>
							<span class="label"><xsl:text>&label-name;</xsl:text></span>
							<span><input type="text" name="name" value="{../../@name}" /></span>
						</label>
					</div>
				</xsl:if>
				<xsl:apply-templates select="field" mode="form-modify" />
			</div>
		</div>
	</xsl:template>
	
	<xsl:template match="properties/group[@name = 'statistic_info']/field" mode="form-modify">
		<div class="field text">
			<label for="{generate-id()}">
				<span class="label">
					<acronym><xsl:value-of select="./@title" /></acronym>
				</span>
				<a href="{.}" id="{generate-id()}" class="text" name="{@input_name}">
					<xsl:apply-templates select="." mode="value" />
				</a>
			</label>
		</div>
	</xsl:template>

	<xsl:template match="properties/group[@name = 'statistic_info']/field" mode="value">
		<xsl:text>/</xsl:text>
	</xsl:template>

	<xsl:template match="properties/group[@name = 'statistic_info']/field[. != '']" mode="value">
		<xsl:value-of select="." disable-output-escaping="yes" />
	</xsl:template>

</xsl:stylesheet>
