<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE xsl:stylesheet SYSTEM "ulang://common/exchange" [
	<!ENTITY sys-module        'exchange'>
	<!ENTITY sys-method-add        'add'>
	<!ENTITY sys-method-edit    'edit'>
	<!ENTITY sys-method-del        'del'>

]>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="result[@method = 'import']/data">
		<script type="text/javascript"><![CDATA[
			var exchangeDoImport = function() {
				for (var id in oTable.selectedList) {
					var h  = '<div class="exchange_container">';
							h += '<div id="process-header">' + getLabel('js-exchange-import-help') + '</div>';
							h += '<div><img id="process-bar" src="/images/cms/admin/mac/process.gif" class="progress" /></div>';
							h += '<div class="status">' + getLabel('js-exchange-created') + '<span id="created_counter">0</span></div>';
							h += '<div class="status">' + getLabel('js-exchange-updated') + '<span id="updated_counter">0</span></div>';
							h += '<div class="status">' + getLabel('js-exchange-deleted') + '<span id="deleted_counter">0</span></div>';
							h += '<div id="errors_message" class="status">' + getLabel('js-exchange-import-errors') + '<span id="errors_counter">0</span>' + '</div>';
							h += '<div><a href="#" onclick="$(\'#import_log\').toggle();return false;">' + getLabel('js-exchange-toggle-log') + '</a></div>';
							h += '<div id="import_log" style="display:none;"></div>';
						h += '</div>';
						h += '<div class="eip_buttons">';
							h += '<input id="ok_btn" type="button" value="' + getLabel('js-exchange-btn_ok') + '" class="ok" style="margin:0;" disabled="disabled" />';
							h += '<input id="repeat_btn" type="button" value="' + getLabel('js-exchange-btn_repeat') + '" class="repeat" disabled="disabled" />';
							h += '<input id="stop_btn" type="button" value="' + getLabel('js-exchange-btn_stop') + '" class="stop" />';
							h += '<div style="clear: both;"/>';
						h += '</div>';


					openDialog({
						stdButtons: false,
						title      : getLabel('js-exchange-import'),
						text       : h,
						width      : 390,
						OKCallback : function () {

						}
					});

					var i_created = 0;
					var i_updated = 0;
					var i_deleted = 0;
					var i_errors = 0;

					var b_canceled = false;

					var reportError = function(msg) {
						$('#errors_message').css('color', 'red');
						i_errors++;
						$('#errors_counter').html(i_errors);
						$('#import_log').append(msg + "<br />");
						$('#process-header').html(msg).css('color', 'red');
						$('#process-bar').css({'visibility' : 'hidden'});
						$('#repeat_btn').one("click", function() { b_canceled = false; processImport(); }).removeAttr('disabled');
						$('#ok_btn').one("click", function() { closeDialog(); }).removeAttr('disabled');
						$('#stop_btn').attr('disabled', 'disabled');

						if(window.session) {
							window.session.stopAutoActions();
						}

					}

					var processImport = function () {
						$('#process-bar').css({'visibility' : 'visible'});
						$('#process-header').html(getLabel('js-exchange-import-help')).css({'color' : ''});
						$('#repeat_btn').attr('disabled', 'disabled');
						$('#ok_btn').attr('disabled', 'disabled');
						$('#stop_btn').one("click", function() { b_canceled = true; $(this).attr('disabled', 'disabled'); }).removeAttr('disabled');

						if(window.session) {
							window.session.startAutoActions();
						}

						$.ajax({
							type: "GET",
							url: "/admin/exchange/import_do/" + id + ".xml"+"?r=" + Math.random(),
							dataType: "xml",

							success: function(doc){
								$('#process-bar').css({'visibility' : 'hidden'});
								var errors = doc.getElementsByTagName('error');
								if (errors.length) {
									reportError(errors[0].firstChild.nodeValue)
									return;
								}
								// write log
								var log =  doc.getElementsByTagName('log');
								for (var i = 0; i < log.length; i++) {
									$('#import_log').append(log[i].firstChild.nodeValue + "<br />");
								}
								// updated counts
								var data_nl = doc.getElementsByTagName('data');
								if (!data_nl.length) {
									reportError(getLabel('js-exchange-ajaxerror'));
									return false;
								}
								var data = data_nl[0];
								i_created += (parseInt(data.getAttribute('created')) || 0);
								i_updated += (parseInt(data.getAttribute('updated')) || 0);
								i_deleted += (parseInt(data.getAttribute('deleted')) || 0);
								i_errors += (parseInt(data.getAttribute('errors')) || 0);

								$('#created_counter').html(i_created);
								$('#updated_counter').html(i_updated);
								$('#deleted_counter').html(i_deleted);
								$('#errors_counter').html(i_errors);

								var complete = data.getAttribute('complete') || false;

								if (complete === false) {
									reportError(getLabel('Parse data error. Required attribute complete not found'));
									exit();
								}

								if (complete == 1) {
									$('#process-header').html(getLabel('js-exchange-import-done')).css({'color' : 'green'});
									$('#stop_btn').attr('disabled', 'disabled');
									$('#ok_btn').one("click", function() { closeDialog(); }).removeAttr('disabled');

									if(window.session) {
										window.session.stopAutoActions();
									}
								} else {
									if (b_canceled) {
										$('#repeat_btn').one("click", function() { b_canceled = false; processImport(); }).removeAttr('disabled');
										$('#ok_btn').one("click", function() { closeDialog(); }).removeAttr('disabled');
									} else {
										processImport();
									}
								}


							},

							error: function(event, XMLHttpRequest, ajaxOptions, thrownError) {
								if(window.session) {
									window.session.stopAutoActions();
								}

								reportError(getLabel('js-exchange-ajaxerror'));
							}

						});
					}

					processImport();


					break;
				}
			}
		]]></script>

		<div class="imgButtonWrapper">
			<a href="{$lang-prefix}/admin/&sys-module;/add/import/">
				<xsl:text>&label-add-import;</xsl:text>
			</a>
			<a href="#" id="doImport" onclick = "exchangeDoImport(); return false;" style="background: url(/images/cms/admin/mac/ico_exchange.png) no-repeat 0 0;">
				<xsl:text>&label-import-do;</xsl:text>
			</a>
		</div>

		<xsl:call-template name="ui-smc-table">
			<xsl:with-param name="control-params" select="$method" />
			<xsl:with-param name="content-type">objects</xsl:with-param>

			<xsl:with-param name="js-add-buttons">
				createAddButton(
					$('#doImport')[0],	oTable, '#', ['*']
				);
			</xsl:with-param>


		</xsl:call-template>
	</xsl:template>

	<xsl:template match="result[@method = 'export']/data">
		<script type="text/javascript"><![CDATA[
			var exchangeDoExport = function() {
				for (var id in oTable.selectedList) {
					var h = '<form target="_blank" action="/admin/exchange/get_export/' + id + '/" id="export_form" method="get">';
							h += '<div><input type="radio" name="as_file" checked="checked" id="export_link" value="0" /><label for="export_link">' + getLabel('js-exchange-export-getlink') + '</label></div>';
							h += '<div><input type="radio" name="as_file" id="export_file" value="1" /><label for="export_file">' + getLabel('js-exchange-export-getfile') + '</label></div>';
						h += '</form>';

					openDialog({
						title      : getLabel('js-exchange-export'),
						text       : h,
						OKCallback : function () {

							if ($('#export_form input[name=as_file]:checked').val() == 1) {

								var h  = '<div class="exchange_container">';
								h += '<div id="process-header">' + getLabel('js-exchange-export') + '</div>';
								h += '<div><img id="process-bar" src="/images/cms/admin/mac/process.gif" class="progress" /></div>';

								h += '</div>';
								h += '<div id="export_log"></div>';
								
								h += '<div class="eip_buttons">';
									h += '<input id="ok_btn" type="button" value="' + getLabel('js-exchange-btn_ok') + '" class="ok" style="margin:0;" disabled="disabled" />';
									h += '<input id="repeat_btn" type="button" value="' + getLabel('js-exchange-btn_repeat') + '" class="repeat" disabled="disabled" />';
									h += '<input id="stop_btn" type="button" value="' + getLabel('js-exchange-btn_stop') + '" class="stop" />';
									h += '<div style="clear: both;"/>';
								h += '</div>';

								openDialog({
									stdButtons: false,
									title      : getLabel('js-exchange-export'),
									text       : h,
									width      : 390,
									OKCallback : function () {

									}
								});

							}

							processExport($('#export_form input[name=as_file]:checked').val());
						}
					});

					break;
				}
				
				var b_canceled = false;

				var reportError = function(msg) {
					$('#export_log').html(msg);
					$('.exchange_container').hide();	
					$('#repeat_btn').one("click", function() { b_canceled = false; processExport(1); }).removeAttr('disabled');
					$('#ok_btn').one("click", function() { closeDialog(); }).removeAttr('disabled');
					$('#stop_btn').attr('disabled', 'disabled');
					
					if(window.session) {
						window.session.stopAutoActions();
					}

				}

				var processExport = function (as_file) {

					if (as_file == 0) {
						window.location.href = "/admin/exchange/get_export/" + id + "/?as_file="+ as_file;
						closeDialog();
						return false;
					}
					
					$('.exchange_container').show();
					$('#process-bar').show();
					$('#export_log').html('');	
					$('#repeat_btn').attr('disabled', 'disabled');
					$('#ok_btn').attr('disabled', 'disabled');
					$('#stop_btn').one("click", function() { b_canceled = true; $(this).attr('disabled', 'disabled'); }).removeAttr('disabled');

					if(window.session) {
						window.session.startAutoActions();
					}

					$.ajax({
						type: "GET",
						url: "/admin/exchange/get_export/" + id + ".xml" + "?r=" + Math.random(),
						dataType: "xml",

						success: function(doc){

							var data_nl = doc.getElementsByTagName('data');
							if (!data_nl.length) {
								reportError(getLabel('js-exchange-ajaxerror'));
								return false;
							}
							var data = data_nl[0];
							var complete = data.getAttribute('complete') || false;

							if (complete === false) {
								var errors = data.getElementsByTagName('error');
								var error = errors[0] || false;

								var errorMessage = '';
								if(error !== false) {
									errorMessage = jQuery.browser.msie ? error.text : error.textContent;
								} else {
									errorMessage = getLabel('Parse data error. Required attribute complete not found');
								}

								reportError(errorMessage);
								return false;
							}

							if (complete == 1) {
								window.location.href = "/admin/exchange/get_export/" + id + "/?as_file="+ as_file;
								closeDialog();
							} else {
								if (b_canceled) {
									$('#process-bar').hide();
									$('#repeat_btn').one("click", function() { b_canceled = false; processExport(1); }).removeAttr('disabled');
									$('#ok_btn').one("click", function() { closeDialog(); }).removeAttr('disabled');
								} else {
									processExport(as_file);
								}
							}



						},

						error: function(event, XMLHttpRequest, ajaxOptions, thrownError) {
							if(window.session) {
								window.session.stopAutoActions();
							}
							reportError(getLabel('js-exchange-ajaxerror'));
						}

					});
				}
			}

			var prepareExport  = function() {

				for (var id in oTable.selectedList) {

				openDialog({
						stdButtons: true,
						title      : getLabel('js-exchange-prepare-export'),
						text       : getLabel('js-exchange-prepare-export-submit'),
						width      : 390,
						OKCallback : function () {

							var h  = '<div class="exchange_container">';
							h += '<div id="process-header">' + getLabel('js-exchange-export') + '</div>';
							h += '<div><img id="process-bar" src="/images/cms/admin/mac/process.gif" class="progress" /></div>';

							h += '</div>';
							h += '<div id="prepare_log"></div>';
							h += '<div id="export_log"></div>';
							h += '<div class="eip_buttons">';
							h += '<input id="stop_btn" type="button" value="' + getLabel('js-exchange-btn_stop') + '" class="stop" />';
							h += '<div style="clear: both;"/>';
							h += '</div>';


							openDialog({
								stdButtons: false,
								title      : getLabel('js-exchange-export'),
								text       : h,
								width      : 390,
								OKCallback : function () {

								}
							});
							processPrepareExport(id);
						}

					});

					var reportError = function(msg) {
						$('#export_log').append(msg + "<br />");
						$('#process-bar').detach();
						$('#process-header').detach();
						$('#exchange-container').detach();
						$('.eip_buttons').html('<input id="ok_btn" type="button" value="' + getLabel('js-exchange-btn_ok') + '" class="ok" style="margin:0;" /><div style="clear: both;"/>')
						$('#ok_btn').one("click", function() { closeDialog(); });
						if(window.session) {
							window.session.stopAutoActions();
						}

					}

					var processPrepareExport = function (id) {

						$('#stop_btn').one("click", function() { closeDialog(); return false; });

						if(window.session) {
							window.session.startAutoActions();
						}

						$.ajax({
							type: "GET",
							url: "/admin/exchange/prepareElementsToExport/"+ id +".xml" + "?r=" + Math.random(),
							dataType: "xml",

							success: function(doc){
								var data_nl = doc.getElementsByTagName('data');
								if (!data_nl.length) {
									reportError(getLabel('js-exchange-ajaxerror'));
									return false;
								}
								var data = data_nl[0];
								var complete = data.getAttribute('complete') || false;

								var log =  doc.getElementsByTagName('log');
								for (var i = 0; i < log.length; i++) {
									$('#prepare_log').append(log[i].firstChild.nodeValue + "<br />");
								}

								if (complete === false) {
									var errors = data.getElementsByTagName('error');
									var error = errors[0] || false;

									var errorMessage = '';
									if(error !== false) {
										errorMessage = jQuery.browser.msie ? error.text : error.textContent;
									} else {
										errorMessage = getLabel('Parse data error. Required attribute complete not found');
									}

									reportError(errorMessage);
									return false;
								}

								if (complete == 1) {

									$('#export_log').html(getLabel('js-exchange-prepare-done')).css({'color' : 'green'});
									$('#process-bar').detach();
									$('#process-header').detach();
									$('#exchange-container').detach();
									$('.eip_buttons').html('<input id="ok_btn" type="button" value="' + getLabel('js-exchange-btn_ok') + '" class="ok" style="margin:0;" /><div style="clear: both;"/>')
									$('#ok_btn').one("click", function() { closeDialog(); });

									if(window.session) {
										window.session.stopAutoActions();
									}
								} else {
										var preparation = data.getAttribute('preparation') || false;
										if (preparation == 1) {
											reportError(getLabel('js-exchange-type-error'));
										} else {
											processPrepareExport(id);
										}
								}
							},

							error: function(event, XMLHttpRequest, ajaxOptions, thrownError) {
								if(window.session) {
									window.session.stopAutoActions();
								}
								reportError(getLabel('js-exchange-ajaxerror'));
							}

						});
					};
				break;
			}

		};


		]]></script>

		<div class="imgButtonWrapper">
			<a href="{$lang-prefix}/admin/&sys-module;/add/export/">
				<xsl:text>&label-add-export;</xsl:text>
			</a>
			<a href="#" id="doExport" onclick = "exchangeDoExport(); return false;" style="background: url(/images/cms/admin/mac/ico_exchange.png) no-repeat 0 0;">
				<xsl:text>&label-export-do;</xsl:text>
			</a>
			<a href="#" id="prepareExport" onclick = "prepareExport(); return false;" style="background: url(/images/cms/admin/mac/ico_exchange.png) no-repeat 0 0;">
				<xsl:text>&js-exchange-prepare-export;</xsl:text>
			</a>
		</div>

		<xsl:call-template name="ui-smc-table">
			<xsl:with-param name="control-params" select="$method" />
			<xsl:with-param name="content-type">objects</xsl:with-param>

			<xsl:with-param name="js-add-buttons">
				createAddButton(
					$('#doExport')[0],	oTable, '#', ['*']
				);
				createAddButton(
					$('#prepareExport')[0],	oTable, '#', ['*']
				);
			</xsl:with-param>

		</xsl:call-template>
	</xsl:template>


</xsl:stylesheet>