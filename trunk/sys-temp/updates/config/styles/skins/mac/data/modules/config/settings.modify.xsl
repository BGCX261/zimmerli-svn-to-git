<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet SYSTEM "ulang://common">
<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:php="http://php.net/xsl">

	<xsl:template match="/result[@method = 'cache' or @method = 'mails' or @method = 'watermark']/data">
		<script type="text/javascript"> 
			function doOptimizeDB() {
				openDialog({
					'title': getLabel('js-config-optimize-db-header'),
					'text': getLabel('js-config-optimize-db-content') + '<ul id="optimize-errors" />',
					'stdButtons': false
				});
				jQuery.getScript('/admin/config/reviewDatabase/', function () {
					window.location.reload();
				});
				return false;
			}
		</script>
		
		<form id="{../@module}_{../@method}_form" action="do/" method="post">
			<xsl:apply-templates mode="settings.modify" />
			<xsl:call-template name="std-save-button" />
		</form>
		
		<xsl:apply-templates select="../@demo" mode="stopdoItInDemo" />
	</xsl:template>


	<xsl:template match="/result[@method = 'main']//group" mode="settings.modify">
		<table class="hide">
			<tbody>
				<xsl:apply-templates select="option" mode="settings.modify" />
			</tbody>
		</table>
		<xsl:apply-templates select="/result/@demo" mode="stopdoItInDemo" />
		<xsl:call-template name="std-save-button" />
	</xsl:template>

	<xsl:template match="/result[@method = 'cache']//group" mode="settings.modify">
	<xsl:if test="position() = 1">
            <script type="text/javascript" language="javascript" src="/js/jquery/jquery.cookie.js"></script>
            <script type="text/javascript">
                <![CDATA[
                    function setConfigCookie(){
					    var date = new Date();
					    date.setTime(date.getTime() + (60 * 60 * 1000));
                        jQuery.cookie("umi_config_cookie", "Y",  { expires: date });
                    }
                    jQuery(document).ready(function(){
                        var confirmId    = Math.round( Math.random() * 100000 );
                        var skin =
                            "<div class=\"eip_win_head popupHeader\" onmousedown=\"jQuery('.eip_win').draggable(c)\">\n\
                                <div class=\"eip_win_close popupClose\" onclick=\"javascript:jQuery.closePopupLayer('macConfirm"+confirmId+"'); setConfigCookie(); return false;\">&#160;</div>\n\
								<div class=\"eip_win_title\">" + getLabel('js-index-speedmark-message') + "</div>\n\
                            </div>\n\
                            <div class=\"eip_win_body popupBody\" onmousedown=\"jQuery('.eip_win').draggable('destroy')\">\n\
								<div class=\"popupText\" style=\"zoom:1;\">" + getLabel('js-index-speedmark-popup') + "</div>\n\
                                <div class=\"eip_buttons\">\n\
                                    <input type=\"button\" class=\"back\" value=\"Закрыть\" onclick=\"confirmButtonCancelClick('macConfirm" + confirmId+"', "+confirmId+"); setConfigCookie(); return false;\" />\n\
                                    <div style=\"clear: both;\"/>\
                                </div>\n\
                            </div>";
                        var param = {
                            name : 'macConfirm' + confirmId,
                            width : 300,
                            data : skin,
                            closeable : true
                        };

                        if (!jQuery.cookie("umi_config_cookie")) {
                            jQuery.openPopupLayer(param);
                        }
                    });
                    
                    function SpeedMark(c) {
						this.iterations = c || 20;
						
						this.error = false;
						
						this.blank_url = "/admin/config/speedtest/";
						
						this.started = null;
						
						var self = this;
						$(document).ajaxError(function(event, request, settings){
							if(settings.url.indexOf(self.blank_url) == 0) {
								self.error = true;

								self.end();
							}
						});						
                    }
                    
                    SpeedMark.prototype.start = function() {
						var self = this;
						
						if(this.started) {
							return false;
						}
						
						jQuery(".speedmark").show();
						jQuery("#speedmark_avg").html(getLabel('js-index-speedmark-wait'));
						
						this.time = 0;
						this.error = false;
						this.finished = 0;
						this.started = true;
						this.authorized = true;
						
						for(var i=0;i<this.iterations;i++) {
							jQuery.ajax({
								url: this.blank_url + '?random=' + Math.random(),
								async: false,
								dataType: 'text',
								success: function(data){
									if(!(time = parseFloat(data))) {
											self.authorized = false;
										}
									self.time += time;
								}
							});
							if(!this.authorized) {
								location.reload();
								return false;
							}
						}
						this.end();
						return false;
                    }
                    
                    SpeedMark.prototype.end = function() {
						this.started = false;
						
						this.time = parseFloat(this.time);

						var avg_time = this.time / this.iterations;
						
						var mark = Math.round(1 / avg_time *100)/100;
						var rate;
						if(mark < 10) {
							rate = getLabel('js-index-speedmark-less-10');
						} else if (mark < 20) {
							rate = getLabel('js-index-speedmark-less-20');
						} else if (mark < 30) {
							rate = getLabel('js-index-speedmark-less-30');
						} else if (mark < 40) {
							rate = getLabel('js-index-speedmark-less-40');
						} else if (mark >= 40) {
							rate = getLabel('js-index-speedmark-more-40');
						}
						
						var result = '<b>' + mark + '</b> - ' + rate;
						jQuery("#speedmark_avg").removeClass("error");
						
						if(!this.error) {
							jQuery("#speedmark_avg").html(result);
						}
						else{
							jQuery("#speedmark_avg").addClass("error").html(getLabel('js-index-speedmark-error'));
						}
                    }

                    var speedmark = new SpeedMark();
                ]]>
            </script>       
        </xsl:if>
		<table class="tableContent">
			<thead>
				<th colspan="2">
					<xsl:value-of select="@label" />
				</th>
			</thead>
			<tbody>
				<xsl:apply-templates select="option" mode="settings.modify" />
				<xsl:if test="@name = 'test'">
					<tr>
						<td>
							<div class="speedmark-link">
						<a href="#" onclick="return speedmark.start()">&js-check-speedmark;</a>
							</div>
						<div class="speedmark">
							&js-system-speedmark;: <span id="speedmark_avg"></span>
								<p>&js-index-speedmark;</p>
						</div>	
				</td>
				</tr>
					<tr>
						<td>
							<div class="server_load"><xsl:value-of select="php:function('get_server_load','')" /></div>
						</td>
					</tr>
				</xsl:if>
			</tbody>
		</table>
	</xsl:template>

	<xsl:template match="/result[@method = 'security']//group" mode="settings.modify">
		<xsl:if test="position() = 1">
			<script type="text/javascript">
				<![CDATA[
					function SecurityTest() {
						var self = this;
						this.error = false;
						this.blank_url = "/admin/config/securityRunTest/";
						$(document).ajaxError(function(event, request, settings){
							if(settings.url.indexOf(self.blank_url) == 0) {
								self.error = true;
							}
						});
						
						this.run = function() {
							jQuery(".testResult").remove();
							this.authorized = true;
							if(!this.authorized) {
								location.reload();
								return false;
							}
							self.test(0);
							return false;
						};
						
						this.test = function(testNumber) {
							testNumber = testNumber || 0;
							jQuery.ajax({
								url: this.blank_url + testNumber + '/?random=' + Math.random(),
								async: false,
								dataType: 'json',
								success: function(data){
									self.showResult(data);
									if(data.next) {
										self.test(data.next);
									}
								}
							});
							return false;
						};
						
						this.showResult = function(response) {
							var result = '<tr class="testResult"><td>' + getLabel('js-security-' + response.test) + '</td><td id="security_result_' + response.test + '">';
							var rate = response.result ? getLabel('js-index-security-fine') : getLabel('js-index-security-problem');
							result += rate + '</td></tr>';
							jQuery(".tableContent").append(result);
							if (!response.result) {
								jQuery("#security_result_" + response.test).addClass("error");
							} else {
								jQuery("#security_result_" + response.test).addClass("ok");
							}
						};
					};

					var security = new SecurityTest();
				]]>
			</script>
		</xsl:if>
		<table class="tableContent">
			<thead>
				<th colspan="2">
					<xsl:value-of select="@label" />
				</th>
			</thead>
			<tbody>
				<xsl:apply-templates select="option" mode="settings.modify" />
				<xsl:if test="@name = 'test'">
					<tr>
						<td colspan="2">
							<a class="speedmark-link" href="#" onclick="return security.run()">&js-check-security;</a>
						</td>
					</tr>
				</xsl:if>
			</tbody>
		</table>
	</xsl:template>

	<xsl:template match="/result[@method = 'mails' or @method = 'watermark']//group" mode="settings.modify">
		<table class="tableContent">
			<tbody>
				<xsl:apply-templates select="option" mode="settings.modify" />
			</tbody>
		</table>
	</xsl:template>

	<xsl:template match="option[@type = 'status' and @name = 'reset']" mode="settings.modify">
		<tr>
			<td />
			<td>
				<input type="button" value="{@label}" id="cache_reset" />
			</td>
		</tr>
		
		<xsl:if test="not($demo)">
			<script>
			jQuery('#cache_reset').click(function(){
				location.pathname = '<xsl:value-of select="$lang-prefix" />/admin/config/cache/reset/';
				return false;
			});
			</script>
		 </xsl:if>
		 <xsl:if test="$demo">
			<script>
			jQuery('#cache_reset').click(function(){
				jQuery.jGrowl('<p>В демонстрационном режиме эта функция недоступна</p>', {
					'header': 'UMI.CMS',
					'life': 10000
				});
				return false;
			});
			</script>
		 </xsl:if>
	</xsl:template>
	
	<xsl:template match="option[@type = 'status' and @name = 'branch']" mode="settings.modify">
		<tr>
			<td class="eq-col">
				<xsl:value-of select="@label" />
			</td>
			
			<td>
				<input type="button" value="&option-branch; {value}%" onclick="doOptimizeDB()" />
			</td>
		</tr>
	</xsl:template>

</xsl:stylesheet>