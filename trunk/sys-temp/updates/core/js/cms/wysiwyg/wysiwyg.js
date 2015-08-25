uAdmin('.wysiwyg', function (extend) {
	function WYSIWYG() {
		this.settings = jQuery.extend(this[this.type].settings, this.settings);
		this[this.type]();
		this.init = this[this.type].init;
	}

	WYSIWYG.prototype.init = function() {
		return false;
	};

	WYSIWYG.prototype.settings = function() {
		return false;
	};

	WYSIWYG.prototype.inline = function() {
		jQuery('<script src="/js/cms/wysiwyg/inline/inlineWYSIWYG.js" type="text/javascript" charset="utf-8"></script>').appendTo('head');
	};

	WYSIWYG.prototype.inline.init = function(node) {
		return new inlineWYSIWYG(node);
	};

	WYSIWYG.prototype.tinymce = function() {
		window.tinyMCEPreInit = {
			suffix : '_src',
			base : '/js/cms/wysiwyg/tinymce/jscripts/tiny_mce'
		};

		jQuery('<script src="/js/cms/wysiwyg/tinymce/jscripts/tiny_mce/tiny_mce_src.js" type="text/javascript" charset="utf-8"></script>').appendTo('head');
	};

	WYSIWYG.prototype.tinymce.init = function(node) {
		var editor, selector = "textarea.wysiwyg", settings = {};
		if (uAdmin.eip && uAdmin.eip.editor) {
			settings.toolbar_standart = this.settings.toolbar_standart.replace(/^imagemanager,/, '');
			editor = {
				id : 'mceEditor-' + new Date().getTime(),
				destroy : function() {
					var oldNode = jQuery('#' + editor.id),
						newNode = jQuery('#' + editor.id + '_parent'),
						frame = jQuery('iframe', newNode)[0],
						content;
					if (jQuery.browser.msie && (typeof document.documentMode == 'undefined' || document.documentMode < 7)) {
						content = window.frames[window.frames.length-1].document.body.innerHTML;
					}
					else content = frame.contentDocument.body.innerHTML;
					oldNode.html(content);
					newNode.remove();
					oldNode.css('display','');
					oldNode[0].id = '';
				}
			};
			node.id = editor.id;
			selector = '#' + editor.id;
		}

		settings.language = uAdmin.data["interface-lang"] || uAdmin.data["lang"];
		settings = jQuery.extend(this.settings, settings);
		tinyMCE.init(settings);

		jQuery(selector).each(function (i, n) {
			tinyMCE.execCommand('mceAddControl', false, n.id);
		});
		return editor;
	};

	WYSIWYG.prototype.tinymce.settings = {
		// General options
		mode : "none",
		theme : "umi",
		width : "100%",
		language : '',
		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,"
		+"advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,"
		+"preview,media,searchreplace,print,contextmenu,paste,directionality,"
		+"fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager",

		inlinepopups_skin : 'butterfly',

		toolbar_standart : "imagemanager,fontsettings,tablesettings,|,"
		+"cut,copy,paste,|,pastetext,pasteword,|,selectall,cleanup,|,"
		+ "undo,redo,|,link,unlink,anchor,image,media,|,charmap,code",

		toolbar_tables : "table,delete_table,|,col_after,col_before,"
		+"row_after,row_before,|,delete_col,delete_row,|,"
		+"split_cells,merge_cells,|,row_props,cell_props",

		toolbar_fonts: "formatselect,fontselect,fontsizeselect,|,"
		+ "bold,italic,underline,|,"
		+ "justifyleft,justifycenter,justifyright,justifyfull,|,"
		+ "bullist,numlist,outdent,indent,|,"
		+ "forecolor,backcolor,|,sub,sup",

		theme_umi_toolbar_location : "top",
		theme_umi_toolbar_align : "left",
		theme_umi_statusbar_location : "bottom",
		theme_umi_resize_horizontal : false,
		theme_umi_resizing : true,

		convert_urls : false,
		relative_urls : false,

		file_browser_callback : function(field_name, url, type, win) {
			if (type == 'file') {
				var sTreeLinkUrl = "/js/cms/wysiwyg/tinymce/jscripts/tiny_mce/themes/umi/treelink.html" + (window.lang_id ? "?lang_id=" + window.lang_id : '');
				tinyMCE.activeEditor.windowManager.open({
					url    : sTreeLinkUrl,
					width  : 525,
					height : 308,
					inline         : true,
					scrollbars	   : false,
					resizable      : false,
					maximizable    : false,
					close_previous : false
				}, {
					window    : win,
					input     : field_name,
					editor_id : tinyMCE.selectedInstance.editorId
				});
				return false;
			}
			else {
				var input = win.document.getElementById(field_name),
					params = {}, qs = [];
				if (!input) return false;
				if (input.value.length) {
					params.folder = input.value.substr(0, input.value.lastIndexOf('/'));
					params.file = input.value;
				}
				qs.push("id=" + field_name);
				switch(type) {
					case "image" : qs.push("image=1"); break;
					case "media" : qs.push("media=1"); break;
				}
				jQuery.ajax({
					url: "/admin/data/get_filemanager_info/",
					data: params,
					dataType: 'json',
					success: function(data){
						if (data.filemanager == 'flash') {
							if (input.value.length) {
								qs.push("folder=." + params.folder);
								qs.push("file=" + input.value);
							}
						}
						else {
							qs.push("folder_hash=" + data.folder_hash);
							qs.push("file_hash=" + data.file_hash);
							qs.push("lang=" + data.lang);
						}

						var fm = {
							flash :  {
								height : 460,
								url    : "/styles/common/other/filebrowser/umifilebrowser.html?" + qs.join("&")
							},
							elfinder : {
								height : 530,
								url    : "/styles/common/other/elfinder/umifilebrowser.html?" + qs.join("&")
							}
						};

						jQuery.openPopupLayer({
							name   : "Filemanager",
							title  : getLabel('js-file-manager'),
							width  : 660,
							height : fm[data.filemanager].height,
							url    : fm[data.filemanager].url
						});

						if (data.filemanager == 'elfinder') {
							window.parent.jQuery('#popupLayer_Filemanager .popupBody').append('\n\
								<div id="watermark_wrapper">\n\
									<label for="add_watermark">' + getLabel('js-water-mark') + '</label>\n\
									<input type="checkbox" name="add_watermark" id="add_watermark">\n\
								</div>\n\
							');
						}
						return false;
					}
				});
			}
			return false;
		},// Callbacks

		extended_valid_elements : "script[type=text/javascript|src|languge|lang],map[*],area[*],umi:*[*],input[*],noindex[*],nofollow[*],iframe[frameborder|src|width|height|name|align]", // extend tags and atributes

		content_css : "/css/cms/style.css" // enable custom CSS
	};

	return extend(WYSIWYG, this);
});