uAdmin('.panel', function (extend) {
	function uPanel() {
		var self = this;
		jQuery('html').addClass('u-eip');
		var panel_holder = jQuery('<div id="u-panel-holder" />').appendTo('body');

		var show_hide_btn = jQuery('<div id="u-show_hide_btn" />').appendTo(panel_holder);

		show_hide_btn.click(function () {
			self.swap(this);
		});

		var quickpanel = jQuery('<div id="u-quickpanel" />').appendTo(panel_holder);

		jQuery('\n\
			<div id="exit" title="' + getLabel('js-panel-exit') + '">&#160;</div>\n\
		').appendTo(quickpanel).click(function () {
			window.location = '/users/logout/';
			return false;
		});

		jQuery('\n\
			<div id="help" title="' + getLabel('js-panel-documentation') + '">&#160;</div>\n\
		').appendTo(quickpanel).click(function () {
			window.open("http://help.umi-cms.ru/admin_panel.htm");
			return false;
		});

		var butterfly = jQuery('\n\
			<div id="butterfly">\n\
				<span class="in_ico_bg">&#160;</span>' + getLabel('js-panel-modules') + '\n\
				<div class="bg">\n\
					<ul id="u-mods-cont-left" />\n\
					<ul id="u-mods-cont-right" />\n\
					<div class="clear separate" />\n\
					<ul id="u-mods-utils" />\n\
					<ul id="u-mods-admin" />\n\
					<div class="clear" />\n\
				</div>\n\
			</div>\n\
		').appendTo(quickpanel);

		var edit_menu = jQuery('\n\
			<div id="edit_menu" title="' + getLabel('js-panel-edit-menu') + '">\n\
				<span class="in_ico_bg">&#160;</span>\n\
				<div>\n\
					<ul id="u-docs-edit"/>\n\
					<span class="clear" />\n\
				</div>\n\
			</div>\n\
		').appendTo(quickpanel);

		var last_doc = jQuery('\n\
			<div id="last_doc">\n\
				<span class="in_ico_bg" />\n\
				' + getLabel('js-panel-last-documents') + '\n\
				<div>\n\
					<ul id="u-docs-recent" />\n\
					<span class="clear" />\n\
				</div>\n\
			</div>\n\
		').appendTo(quickpanel);

		last_doc.click(function () {
			self.changeAct(this);
		});

		var changelog_dd = jQuery('\n\
			<div id="changelog_dd" style="display:none;">\n\
				<span class="in_ico_bg">&#160;</span>\n\
				' + getLabel('js-panel-history-changes') + '\n\
				<div>\n\
					<ul id="u-changelog" />\n\
					<span class="clear" />\n\
				</div>\n\
			</div>\n\
		').appendTo(quickpanel);

		changelog_dd.click(function () {
			self.changeAct(this);
		});

		var note = jQuery('\n\
			<div id="note">\n\
				<span class="in_ico_bg">&#160;</span>\n\
				' + getLabel('js-panel-note') + '\n\
			</div>\n\
		').appendTo(quickpanel);

		jQuery('\n\
			<div id="seo">\
				<span class="in_ico_bg">&#160;</span>\n\
				' + getLabel('module-seo') + '\n\
			</div>\n\
		').appendTo(quickpanel).click(function () {
			window.location = '/admin/seo/';
		});

		jQuery(document).bind('click', function (event) {
			if (!jQuery(event.target).parents('#u-quickpanel').size()) {
				self.changeAct();
			}
		});

		if (!jQuery.cookie('eip-panel-state-first')) {
			quickpanel.css({'overflow':'hidden', 'height':'0'});
			show_hide_btn.addClass('collapse');
			quickpanel.delay(500).animate({
				height: "25px"
			}, 500, function(){
				jQuery(this).css('overflow', 'visible');
				show_hide_btn.removeClass('collapse');
			});
			quickpanel.fadeTo(300, 0.3);
			quickpanel.fadeTo(300, 1);
			jQuery.cookie('eip-panel-state', '', {
				path: '/',
				expires: 0
			});
			var date = new Date();
			date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
			jQuery.cookie('eip-panel-state-first', 'Y', {
				path: '/',
				expires: date
			});
		}

		var onLoadData = function (data) {
			jQuery('<link type="text/css" rel="stylesheet" href="/styles/skins/_eip/css/theme.css" />').appendTo('head');
			var page, module;
			for (page in data.documents.recent.page) {
				page = data.documents.recent.page[page];
				jQuery('ul#u-docs-recent', last_doc).append('<li><a href="' + page.link + '">' + page.name + '</a></li>');
			}

			var i = 0;
			for (page in data.documents.editable.page) {
				page = data.documents.editable.page[page];
				for (module in data.modules.module) {
					module = data.modules.module[module];
					if (module.name == page.basetype.module) continue;
				}
				jQuery('ul#u-docs-edit', quickpanel).append('<li><a href="' + (uAdmin.lang_prefix ? '/' + uAdmin.lang_prefix : '') + page['edit-link'] + '">' + page.name + '</a></li>');
				i++;
			}

			if (i) {
				edit_menu.click(function(){
					self.changeAct(this);
				});
			}
			else edit_menu.hide(0);

			i = 0;
			for (module in data.modules.module) {
				module = data.modules.module[module];
				var selector;
				switch (module.type) {
					case "system":
						selector = 'ul#u-mods-utils';
						break;
					case "util":
						selector = 'ul#u-mods-admin';
						break;
					default:
						selector = (++i % 2) ? 'ul#u-mods-cont-left' : 'ul#u-mods-cont-right';
				}
				jQuery(selector, butterfly).append('<li><a href="' + (uAdmin.lang_prefix ? '/' + uAdmin.lang_prefix : '') + '/admin/' + module.name + '/' + '">' + module.label + '</a></li>');
			}

			if (i) {
				butterfly.click(function(){
					self.changeAct(this);
				}).addClass("butterfly_hover");
			}

			if (typeof data.changelog != 'undefined') {
				for (var revision in data.changelog.revision) {
					revision = data.changelog.revision[revision];
					var label = revision.date.std + (revision.author.name ? ' - ' + revision.author.name : '') + (revision.active == 'active' ? '&nbsp;&nbsp;&nbsp;&larr;' : '');
					var link = revision.link + '?force-redirect=' + window.location.pathname;
					jQuery('#u-changelog', changelog_dd).append('<li><a href="' + link + '">' + label + '</a></li>');
				}
				changelog_dd.css('display', '');
			}
			else changelog_dd.css('display', 'none');

			if (typeof data.tickets != 'undefined' && typeof uAdmin.tickets == 'object') {
				uAdmin.tickets.draw(data);
			}
			else {
				note.remove();
			}
		};

		var url = '/admin/content/frontendPanel/.json?links';
		url += '&ts=' + Math.round(Math.random() * 1000);

		jQuery.ajax({
			url:url,
			dataType:'json',
			success:onLoadData
		});
	}

	uPanel.prototype.swap = function (el) {
		var quickpanel_height = jQuery("#u-quickpanel").css("height");
		if (quickpanel_height == "0px") {
			return this.expand(el);

		}
		else {
			if (uAdmin.eip.meta.enabled) {
				jQuery('#u-quickpanel #meta').trigger("click");
			}
			return this.collapse(el);
		}
	};

	uPanel.prototype.expand = function (el) {
		var quickpanel = jQuery("#u-quickpanel");
		quickpanel.css('overflow', 'visible');
		quickpanel.animate({height:"25px"}, 700);
		jQuery(el).removeClass('collapse');

		jQuery.cookie('eip-panel-state', '', { path: '/', expires: 0});
	};

	uPanel.prototype.collapse = function (el) {
		var quickpanel = jQuery("#u-quickpanel");
		quickpanel.css('overflow', 'hidden');
		quickpanel.animate({height:"0"}, 700);
		jQuery(el).addClass('collapse');

		var date = new Date();
		date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
		jQuery.cookie('eip-panel-state', 'collapsed', { path: '/', expires: date});
	};

	uPanel.prototype.loadRes = function (type, src, callback) {
		var node;
		switch(type) {
			case 'js': case 'text/javascript':
				node = document.createElement('script');
				node.src = src;
				node.charset = 'utf-8';
				break;

			case 'css': case 'text/css':
				node = document.createElement('link');
				node.href = src;
				node.rel = 'stylesheet';
				break;
			default: return;
		}

		document.body.parentNode.firstChild.appendChild(node);
		if(typeof callback == 'function') jQuery(document).one('ready', callback);
	};

	uPanel.prototype.changeAct = function(el) {
		var eCond = (uAdmin.eip && uAdmin.eip.enabled) ? '[id != \'edit\']' : '',
			save_edit = jQuery("#save_edit");

		if (!el) {
			jQuery('#u-quickpanel .act div:first').hide();
			jQuery('#u-quickpanel .act' + eCond).removeClass('act');
		}
		else if (jQuery(el).hasClass('act')) {
			jQuery('#u-quickpanel .act div:first').hide();
			jQuery('#u-quickpanel .act' + eCond).removeClass('act');
			if (el.id == 'edit') save_edit.css('display', 'none');
		}
		else {
			var act_arr = jQuery('#u-quickpanel .act'), opera_width = false;
			if (act_arr.size()) {
				jQuery('#u-quickpanel .act div:first').hide();
				jQuery('#u-quickpanel .act' + eCond).removeClass('act');
				if (el.id == 'edit' && !eCond) save_edit.css('display', 'none');
			}
			if (jQuery.browser.opera) opera_width = jQuery(el).width();
			jQuery(el).addClass('act');
			if (opera_width) jQuery(el).width(opera_width);
			jQuery('#u-quickpanel .act div:first').show();
			if (el.id == 'edit') save_edit.css('display', 'block');
		}

		if (jQuery(el).attr("id")!="meta" && uAdmin.eip && uAdmin.eip.meta.enabled) {
			jQuery('#u-quickpanel #meta').addClass('act');
		}

	};

	uPanel.prototype.editInAdmin = function(type) {
		if (type == 'enable') {
			jQuery(document).bind('keypress', this.editInAdmin.bindEvents);
		};
		if (type == 'disable') {
			jQuery(document).unbind('keypress', this.editInAdmin.bindEvents);
		};
	};

	uPanel.prototype.editInAdmin.bindEvents = function(e) {
		if (e.shiftKey) {
			switch(e.charCode || e.keyCode) {
				case 68:// latin - D
				case 100:// latin - d
				case 1042:// russian - В
				case 1074:// russian - в
					jQuery('#u-quickpanel #edit_menu').each(function (i, node) {
						uAdmin.panel.changeAct(node);
					});
					break;
			}
		}
	};

	return extend(uPanel, this);
});