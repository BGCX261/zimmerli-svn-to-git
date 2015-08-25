<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet SYSTEM "ulang://common">
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="/result[@module = 'social_networks']/data/object" mode="form-modify">
		<xsl:apply-templates select="properties/group" mode="form-modify">
			<xsl:with-param name="show-name"><xsl:text>0</xsl:text></xsl:with-param>
		</xsl:apply-templates>
	</xsl:template>

	<xsl:template match="field[@type = 'symlink' and @name='iframe_pages']" mode="form-modify">
		<div class="field symlink" id="{generate-id()}" name="{@input_name}">
			<label for="symlinkInput{generate-id()}">
				<span class="label">
					<acronym>
						<xsl:apply-templates select="." mode="sys-tips" />
						<xsl:value-of select="@title" />
					</acronym>
					<xsl:apply-templates select="." mode="required_text" />
				</span>

				<span id="symlinkInput{generate-id()}" rel="1">
					<ul>
						<xsl:apply-templates select="values/item" mode="symlink" />
					</ul>
				</span>
			</label>
		</div>
	</xsl:template>

	<xsl:template match="properties/group[1]" mode="form-modify">
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

				<xsl:apply-templates select="." mode="form-modify-group-fields">
					<xsl:with-param name="show-name" select="$show-name" />
					<xsl:with-param name="show-type" select="$show-type" />
				</xsl:apply-templates>

				<xsl:call-template name="std-form-template-id">
					<xsl:with-param name="value" select="//template-id/@id" />
				</xsl:call-template>

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

</xsl:stylesheet>