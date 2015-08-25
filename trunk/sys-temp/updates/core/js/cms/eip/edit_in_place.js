uAdmin('.eip', function (extend) {
	function uEditInPlace() {
		var self = this;

		jQuery(document).bind('keydown', function(e) {
			if (e.keyCode == 113) {
				self.swapEditor();
			}
		});

		var isMac = (navigator.userAgent.indexOf('Mac OS') != -1);

		var save = jQuery('\n\
			<div id="save_edit">\n\
				<div id="save" title="' + getLabel('js-panel-save') + ' (' + (isMac ? 'Cmd' : 'Ctrl') + '+S)">&#160;</div>\n\
				<div id="edit_back" title="' + getLabel('js-panel-cancel') + ' (' + (isMac ? 'Cmd' : 'Ctrl') + '+Z)">&#160;</div>\n\
				<div id="edit_next" title="' + getLabel('js-panel-repeat') + ' (' + (isMac ? 'Cmd+Shift+Z' : 'Ctrl+Y') + ')">&#160;</div>\n\
			</div>\n\
		').insertAfter('div#u-panel-holder div#u-quickpanel div#butterfly');

		var edit = jQuery('\n\
			<div id="edit">\n\
				<span class="in_ico_bg">&#160;</span>\n\
				' + getLabel('js-panel-edit') + ' (F2)' + '\
			</div>\n\
		').insertAfter('div#u-panel-holder div#u-quickpanel div#butterfly');

		edit.click(function() {
			self.swapEditor();
			return false;
		});

		var meta = jQuery('\n\
			<div id="meta">\n\
				<span class="in_ico_bg">&#160;</span>\n\
				' + getLabel('js-panel-meta') + '\n\
			</div>\n\
		').insertAfter('div#u-panel-holder div#u-quickpanel div#note');

		if (uAdmin.data && uAdmin.data.pageId) {
			self.meta.element_id  = uAdmin.data.pageId;
			self.meta.old = {
				alt_name     : uAdmin.data.page['alt-name'],
				title        : uAdmin.data.title,
				keywords     : uAdmin.data.meta.keywords,
				descriptions : uAdmin.data.meta.description
			};
			self.meta['new'] = {};

			var quickpanel_meta = jQuery('\n\
				<div id="u-quickpanel-meta">\n\
					<table>\n\
						<tr>\n\
							<td width="100px">' + getLabel('js-panel-meta-altname') + ': </td>\n\
							<td>\n\
								<input type="text" name="alt_name" id="u-quickpanel-metaaltname" value="' + self.meta.old.alt_name + '"/>\n\
								<div class="meta_count" id="u-quickpanel-metaaltname-count"/>\n\
							</td>\n\
						</tr>\n\
						<tr>\n\
							<td width="100px">' + getLabel('js-panel-meta-title') + ': </td>\n\
							<td>\n\
								<input type="text" name="title" id="u-quickpanel-metatitle" value="' + self.meta.old.title + '"/>\n\
								<div class="meta_count" id="u-quickpanel-metatitle-count"/>\n\
							</td>\n\
						</tr>\n\
						<tr>\n\
							<td>' + getLabel('js-panel-meta-keywords') + ': </td>\n\
							<td>\n\
								<input type="text" name="meta_keywords" id="u-quickpanel-metakeywords" value="' + self.meta.old.keywords + '"/>\n\
								<div class="meta_count" id="u-quickpanel-metakeywords-count"/>\n\
								<div class="meta_buttons"><a href="/admin/seo/" style="color:white;">' + getLabel('js-panel-meta-analysis') + '</a></div>\n\
							</td>\n\
						</tr>\n\
						<tr>\n\
							<td>' + getLabel('js-panel-meta-descriptions') + ':</td>\n\
							<td>\n\
								<input type="text" name="meta_descriptions" id="u-quickpanel-metadescription" value="' + self.meta.old.descriptions + '"/>\n\
								<div class="meta_count" id="u-quickpanel-metadescription-count"/>\n\
								<div class="meta_buttons">\n\
									<input type="submit" id="save_meta_button" value="' + getLabel('js-panel-save') + '">\n\
								</div>\n\
							</td>\n\
						</tr>\n\
					</table>\n\
				</div>\n\
			').appendTo('div#u-panel-holder');

			meta.click(function () {
				uAdmin.panel.changeAct(this);
				quickpanel_meta.toggle();
				self.meta.enabled = quickpanel_meta.css("display") != "none";
				return false;
			});

			jQuery('#save_meta_button', quickpanel_meta).click(function() {
				var params = {}, i;
				for (i in self.meta['new']) {
					if (self.meta['new'][i] != self.meta.old[i]) {
						params['field-name'] = ((i == 'keywords' || i == 'descriptions') ? 'meta_' + i : i);
						params['element-id'] = self.meta.element_id;
						params.value = self.meta['new'][i];
						jQuery.post('/admin/content/editValue/save.json', params, function (data) {
							if (data.error) {
								self.message(data.error);
								return;
							}
						}, 'json');
					}
					delete self.meta['new'][i];
				}
				return false;
			});
			jQuery('input[type!="submit"]', quickpanel_meta).bind("blur", function (e) {
				var name = this.name.replace(/^meta_/g, '');
				self.meta['new'][name] = this.value;
			}).bind("keyup mousedown blur", function() {
				var l = this.value.length;
				if (l > 255) this.value = this.value.substring(0, 255);
				else {
					var id = this.id + '-count';
					jQuery('#' + id).html(l);
				}
			}).trigger('keyup');
		}
		else meta.remove();

		jQuery('#save', save).click(function() {
			self.queue.save();
			return false;
		});

		jQuery('#edit_back', save).click(function () {
			self.queue.back();
			return false;
		});

		jQuery('#edit_next', save).click(function () {
			self.queue.forward();
			return false;
		});

		self.bind('enable', function (type) {
			if (type == 'after') {
				uAdmin.panel.changeAct(edit[0]);
			}
		});

		self.bind('disable', function (type) {
			if (type == 'after') {
				uAdmin.panel.changeAct(edit[0]);
			}
		});

		self.bind('repaint', function (type) {});
		self.bind('save', function(type){});

		jQuery(document).ready(function(){
			if (jQuery.cookie('eip-editor-state')) {
				uAdmin.eip.swapEditor();
			}
			else {
				uAdmin.tickets.enable();
				uAdmin.panel.editInAdmin('enable');
			}
		});

		(function init() {
			var timeoutId = null;
			var dropDeleteButtons = function () {
				jQuery('.eip-del-button').remove();
			};

			jQuery('.u-eip-edit-box').live('mouseover', function () {
				jQuery(this).addClass('u-eip-edit-box-hover');
				var info = self.searchAttr(this);
				if (jQuery(this).attr('umi:delete') && info.id) {
					if (timeoutId) clearInterval(timeoutId);
					dropDeleteButtons();

					var deleteButton = document.createElement('div');
					jQuery(deleteButton).attr('class', 'eip-del-button');
					document.body.appendChild(deleteButton);
					self.placeWith(this, deleteButton, 'right', 'middle');

					jQuery(deleteButton).bind('mouseover', function () {
						if (timeoutId) clearInterval(timeoutId);
					});

					jQuery(deleteButton).bind('mouseout', function () {
						timeoutId = setTimeout(dropDeleteButtons, 500);
					});

					jQuery(deleteButton).bind('click', function () {
						info['delete'] = true;
						self.queue.add(info);
						uAdmin.eip.normalizeBoxes();
					});
				}
				else dropDeleteButtons();

				this.onclick = function (e) {
					this.onclick = function () { return true; };
					if (window.event) {
						return window.event.ctrlKey;
					} else {
						return e.ctrlKey;
					}
				};
			});

			jQuery('.u-eip-edit-box-hover').live('mouseout', function (e) {
				var node = jQuery(this);
				jQuery(this).removeClass('u-eip-edit-box-hover');

				if (node.attr('umi:delete')) {
					timeoutId = setTimeout(dropDeleteButtons, 500);
				}

				node.click(function() {
					return true;
				});
			});

			window.onresize = function () {
				self.normalizeBoxes();
			};
		})();
	}

	uEditInPlace.prototype.swapEditor = function () {
		if (this.enabled) {
			this.disable();
			jQuery('#u-quickpanel #edit').html('<span class="in_ico_bg">&#160;</span>' + getLabel('js-panel-edit') + ' (F2)');
			jQuery('#on_edit_in_place').html(getLabel('js-on-eip'));
			uAdmin.tickets.enable();
			uAdmin.panel.editInAdmin('enable');
		}
		else {
			this.enable();
			jQuery('#u-quickpanel #edit').html('<span class="in_ico_bg">&#160;</span>' + getLabel('js-panel-view') + ' (F2)');
			jQuery('#on_edit_in_place').html(getLabel('js-off-eip'));
			uAdmin.tickets.disable();
			uAdmin.panel.editInAdmin('disable');
		}
		this.bindEvents();
	};

	uEditInPlace.prototype.enable = function () {
		var self = this;
		self.onenable('before');
		self.finishLast();
		self.inspectDocument();
		self.highlight();
		self.normalizeBoxes();

		jQuery(window).load(function(){
			setTimeout(function () {
				self.normalizeBoxes();
			}, 250);
		});

		self.enabled = true;

		if (self.queue.current >=0) {
			jQuery('#save').addClass('save_me');
		}

		var date = new Date();
		date.setTime(date.getTime() + (3 * 24 * 60 * 60 * 1000));
		jQuery.cookie('eip-editor-state', 'enabled', { path: '/', expires: date});

		self.message(getLabel('js-panel-message-edit-on'));
		jQuery(document).bind('keydown', self.bindHotkeys);
		self.onenable('after');
	};

	uEditInPlace.prototype.disable = function () {
		this.ondisable('before');
		this.finishLast();
		this.unhighlight();

		this.enabled = false;

		jQuery.cookie('eip-editor-state', '', { path: '/', expires: 0});
		jQuery('#save').removeClass('save_me');
		this.message(getLabel('js-panel-message-edit-off'));

		if (this.queue.current >= 0) {
			if (confirm(getLabel('js-panel-message-save-confirm'))) {
				this.queue.save();
			}
		}
		jQuery(document).unbind('keydown', this.bindHotkeys);
		this.ondisable('after');
	};

	uEditInPlace.prototype.bind = function(event, callback) {
		var self = this,
			f = (typeof self['on' + event] == 'function') ? self['on' + event] : function () {};

		self['on' + event] = function(type) {
			f(type);
			callback(type);
		};
	};

	uEditInPlace.prototype.bindHotkeys = function(e) {
		var self = uAdmin.eip.queue;
		if (navigator.userAgent.indexOf('Mac OS') != -1) {
			if (e.metaKey) {
				switch(e.keyCode) {
					case 83: self.save(); break; // Cmd + S
					case 90:
						if (e.shiftKey) self.forward(); // Cmd + Z
						else self.back(); // Cmd + Shift + Z
						break;
					default: return true;
				}
				return false;
			}
		}
		else {
			if (e.ctrlKey) {
				switch(e.keyCode) {
					case 83: self.save(); break; // Ctrl + S
					case 90: self.back(); break; // Ctrl + Z
					case 89: self.forward(); break; // Ctrl + Y
					default: return true;
				}
				return false;
			}
		}
		return true;
	};

	uEditInPlace.prototype.finishLast = function () {
		if (this.previousEditBox) {
			this.previousEditBox.finish(true);
			this.previousEditBox = null;
		}
	};

	uEditInPlace.prototype.normalizeBoxes = function () {
		var self = this;
		jQuery(self.listNodes).each(function (index, node) {
			if(!node.boxNode) return;

			var position = self.nodePositionInfo(node);
			jQuery(node.boxNode).css({
				'width':		position.width,
				'height':		position.height,
				'left':			position.x,
				'top':			position.y
			});

			var button = node.addButtonNode;
			var fDim = 'bottom', sDim = 'left';
			if(button) {
				var userPos;
				if((userPos = jQuery(node).attr('umi:button-position'))) {
					var arr = userPos.split(/ /);
					if(arr.length == 2) {
						fDim = arr[0];
						sDim = arr[1];
					}
				}
				self.placeWith(node, button, fDim, sDim);
			}
		});
		self.onrepaint('after');
	};

	uEditInPlace.prototype.bindEvents = function () {
		var self = this,
			nodes = jQuery('.u-eip-edit-box');

		nodes.die('click');
		nodes.die('drop');
		nodes.die('dragexit');
		nodes.die('dragover');
		nodes.unbind('click');
		nodes.unbind('drop');
		nodes.unbind('dragexit');
		nodes.unbind('dragover');

		var eventString = 'click';
		if(navigator.userAgent.toLowerCase().indexOf("firefox") || navigator.userAgent.toLowerCase().indexOf("chrome")) {
			eventString = eventString + ' drop';
			nodes.live ('dragexit', function (e) {
				e.stopPropagation();
				e.preventDefault();
			});
			nodes.live ('dragover', function (e) {
				e.stopPropagation();
				e.preventDefault();
			});
		}

		nodes.live(eventString, function (e) {
			var node = e.target;
			if (e.ctrlKey || (navigator.userAgent.indexOf('Mac OS') != -1 && e.metaKey)) {
				if (this.tagName == 'A') {
					location.href = this.href;
				}
				return true;
			}

			var handler = (typeof node.onclick == 'function') ? node.onclick : function () {};
			var nullHandler = function () { return false; };
			node.onclick = nullHandler;
			setTimeout(function () {
				if(node && handler != nullHandler) {
					node.onclick = handler;
				}
			}, 100);

			for(var i = 0; i < 25; i++) {
				if(!node) return false;
				if(node.tagName != 'TABLE' && jQuery(node).attr('umi:field-name')) break;
				node = node.parentNode;
			}
			if(!node) return false;
			e.stopPropagation();
			e.stopImmediatePropagation();
			e.preventDefault();
			self.edit(node, e.originalEvent.dataTransfer ? e.originalEvent.dataTransfer.files : null);
			e.stopPropagation();
			e.stopImmediatePropagation();
			e.preventDefault();
			return false;
		});

		window.onbeforeunload = function () {
			if (uAdmin.eip.queue.current >= 0 || uAdmin.eip.queue.save.count > 0) {
				return getLabel('js-panel-message-save-before-exit');
			}
		};
	};

	/**
		* Найти все помеченные области, пригодные для редактирования
	*/
	uEditInPlace.prototype.inspectDocument = function () {
		var self = this;

		self.editNodes = [];
		self.listNodes = [];

		var regions = self.getRegions();
		regions.each(function (index, node) {
			if (jQuery(node).css('display') == 'none') return;
			self.inspectNode(node);
		});
	};

	/**
		* Проверить и при необходимости занести в редактируемый список html-элемент
	*/
	uEditInPlace.prototype.inspectNode = function(node) {
		if (node.tagName == 'TABLE') return;
		if (jQuery(node).attr('umi:field-name')) this.editNodes.push(node);
		if (jQuery(node).attr('umi:module')) this.listNodes.push(node);
		// Fix editing behaviour for links child elements in ie
		if (jQuery.browser.msie) {
			jQuery(node).parents("a:first").each(function() {
				var href = this.href;
				jQuery(this).click(function(e) {
					if(e.ctrlKey) window.location.href = href;
				});
				this.removeAttribute("href");
			});
		}
	};

	uEditInPlace.prototype.getRegions = function () {
		return jQuery('*[umi\\:field-name], *[umi\\:module]');
	};

	uEditInPlace.prototype.isParentOf = function(seekNode, excludeNode) {
		if(!excludeNode || !seekNode) return false;
		if(excludeNode == seekNode) return true;
		if(seekNode.parentNode) {
			return isParentOf(seekNode.parentNode, excludeNode);
		}
		return false;
	};

	/**
		* Подсветить все редактируемые области
	*/
	uEditInPlace.prototype.highlight = function (excludeNode, skipListNodes) {
		var self = this;
		if (self.highlighted) self.unhighlight();
		self.highlighted = true;

		jQuery(self.editNodes).each(function (index, node) {
			if(self.isParentOf(node, excludeNode) == false) self.highlightNode(node);
		});

		if(!skipListNodes) {
			jQuery(self.listNodes).each(function (index, node) {
				if(self.isParentOf(node, excludeNode) == false) {
					self.highlightListNode(node);
				}
			});
		}

		self.onrepaint('after');
		self.markInversedBoxes();
	};

	/**
		* Снять подсветку с редактируемых блоков
	*/
	uEditInPlace.prototype.unhighlight = function () {
		jQuery('.u-eip-edit-box').each(function (index, node) {
			node = jQuery(node);
			var empty = node.attr('umi:empty');
			if(empty && (node.attr('tagName') != 'IMG') && (node.html() == empty)) {
				node.html('');
			}

			node.attr('title', '');
		});


		var n = jQuery('.u-eip-edit-box');
		n.removeClass('u-eip-edit-box u-eip-edit-box-hover u-eip-modified u-eip-deleted u-eip-edit-box-inversed');

		n.unbind('click');
		n.unbind('mouseover');
		n.unbind('mouseout');
		n.unbind('mousedown');
		n.unbind('mouseup');

		jQuery('.u-eip-add-box, .u-eip-add-button, .u-eip-del-button').remove();

		jQuery('.u-eip-sortable').sortable('destroy');
		jQuery('.u-eip-sortable').removeClass('u-eip-sortable');
	};

	/**
		* Подсветить редактируемый html-элемент
	*/
	uEditInPlace.prototype.highlightNode = function (node) {
		if (!jQuery(node).attr('umi:field-name')) return;
		var info = this.searchAttr(node);
		if (!info) return;

		var empty = this.htmlTrim(jQuery(node).attr('umi:empty'));

		if(empty && this.htmlTrim(jQuery(node).html()) == '' && (jQuery(node).attr('tagName') != 'IMG')) {
			try{
				jQuery(node).html(empty);
			} catch(e) {}
			jQuery(node).addClass('u-eip-empty-field');
		}

		jQuery(node).addClass('u-eip-edit-box');

		if (this.queue.search(info)) {
			jQuery(node).addClass('u-eip-modified');
		}

		if (node.tagName == 'A' || node.parentNode.tagName == 'A' || jQuery('a', node).size() > 0) {
			var label = getLabel('js-panel-link-to-go');
			if (navigator.userAgent.indexOf('Mac OS') != -1) {
				label = label.replace(/Ctrl/g, 'Cmd');
			}
			jQuery(node).attr('title', label);
			jQuery(node).bind('dblclick', function () {
				return false;
			});
		}
		else jQuery(node).attr('title', '');

		this.markInversedBoxes(jQuery(node));
	};

	uEditInPlace.prototype.searchAttr = function (node, callback, deep) {
		if (!node) return false;
		var info;
		deep = deep || 20;
		if (node.tagName == 'BODY' || node.tagName == 'TABLE') return false;

		if (!this.searchAttr.info.node) {
			this.searchAttr.info.node = node;
			var fieldName = jQuery(node).attr('umi:field-name');
			if (!fieldName && typeof callback != 'function') {
				this.message("You should specify umi:field-name attribute");
				return false;
			}
			if (!this.searchAttr.info.field_name) {
				this.searchAttr.info.field_name = fieldName;
			}
		}

		var region = jQuery(node);
		if (typeof callback != 'function' || callback(node)) {
			if (region.attr('umi:element-id')) {
				this.searchAttr.info.id = region.attr('umi:element-id');
				this.searchAttr.info.type = 'element';
				info = this.searchAttr.info;
				this.searchAttr.info = {};
				return info;
			}
			else if (region.attr('umi:object-id')) {
				this.searchAttr.info.id = region.attr('umi:object-id');
				this.searchAttr.info.type = 'object';
				info = this.searchAttr.info;
				this.searchAttr.info = {};
				return info;
			}
		}
		if (node.parentNode) {
			return this.searchAttr(node.parentNode, callback, --deep);
		}
		this.message("You should specify umi:element-id or umi:object attribute");
		return false;
	};

	uEditInPlace.prototype.searchAttr.info = {};

	uEditInPlace.prototype.searchRow = function(node, parent) {
		if (parent) {
			if (node.tagName == 'BODY' || node.tagName == 'TABLE') return false;
			if (jQuery(node.parentNode).attr('umi:region')) {
				return node.parentNode;
			}
			else return this.searchRow(node.parentNode, true);
		}
		else return jQuery('*[umi\\:region]', node).get(0);
	};

	uEditInPlace.prototype.searchRowId = function (node) {
		var elementId = jQuery(node).attr('umi:element-id');
		return elementId || (jQuery('*[umi\\:element-id]', node).length ? jQuery('*[umi\\:element-id]', node).attr('umi:element-id') : null);
	};

	uEditInPlace.prototype.inlineAddPage = function (node) {
		var self = this, originalRow = self.searchRow(node);
		if (!originalRow) {
			self.message("Error, umi:region=row is not defined");
			return false;
		}
		node = jQuery(node);
		var parentId = {
				element : node.attr('umi:element-id'),
				object  : node.attr('umi:object-id')
			},
			typeId = node.attr('umi:type-id');

		var parentDel = false;
		jQuery('.u-eip-deleted').each(function(i, n){
			if (self.searchAttr(n).id == (parentId.element || parentId.object)) {
				parentDel = true;
				return;
			}
		});
		if (parentDel) {
			self.message(getLabel('js-panel-message-cant-add'));
			return false;
		}

		if (!typeId && parentId.element) {
			if (parentId.element.match(/^new/g)) {
				var parent = self.queue.search({id:parentId.element});
				typeId = parent.type_id;
			}
			else {
				var data = jQuery.ajax({
					url : '/admin/content/getTypeAdding/' + parentId.element + '/.json',
					async : false,
					dataType : 'json'
				});
				data = JSON.parse(data.responseText);
				typeId = data.result;
			}
		}
		if (!typeId) {
			self.message("Error, umi:type-id is not defined");
			return false;
		}

		var prepend = (node.attr('umi:method') == 'lastlist'),
			rowNode = jQuery(originalRow).clone(),
			newRowNode = (prepend) ? rowNode.prependTo(originalRow.parentNode) : rowNode.appendTo(originalRow.parentNode);

		var searchFieldName = function(node) {
			var item, i;
			if (jQuery(node).attr('umi:field-name')) {
				return node;
			}
			else if (node.children) {
				for (i = 0; i < node.children.length; i++) {
					item = searchFieldName(node.children[i]);
					if (item) return item;
				}
			}
			return false;
		};
		rowNode = searchFieldName(newRowNode.get(0));
		if (!rowNode) {
			self.message("Error, umi:field-name is not defined");
			return false;
		}
		var info = self.searchAttr(rowNode);

		info.id      = 'new_' + new Date().getTime();
		info.type_id = typeId;
		info.add     = true;
		info.node    = newRowNode.get(0);
		if (parentId.object) {
			info.parent = parentId.object;
			info.type   = 'object';
		}
		if (parentId.element) {
			info.parent = parentId.element;
			info.type   = 'element';
		}
		delete info.field_name;

		if (jQuery(originalRow).attr('umi:' + info.type + '-id') == '') {
			jQuery(originalRow).remove();
			jQuery(newRowNode).attr('umi:' + info.type + '-id', info.id);
			jQuery('*', newRowNode).each(function(i, n) {
				if (!n.children.length) {
					n.style.display = '';
				}
			});
		}

		var cleanTags = function (node) {
			var _attr = 'umi:' + info.type + '-id';
			if (jQuery(node).attr('tagName') == 'TABLE') return;

			if (jQuery(node).attr('umi:field-name')) {
				var empty = jQuery(node).attr('umi:empty');
				if (jQuery(node).attr('tagName') == 'IMG' && empty) {
					jQuery(node).attr('src', empty);
				}
				else jQuery(node).html(empty ? empty : '');

				jQuery(node).addClass('u-eip-empty-field');
				self.editNodes[self.editNodes.length] = node;
			}

			if (jQuery(node).attr(_attr)) {
				jQuery(node).attr(_attr, info.id);
			}
		};

		//Delete subregions
		var childRowNode = jQuery('*[umi\\:region="row"]', newRowNode).get(0);
		jQuery('*[umi\\:region="row"]', newRowNode).remove();

		cleanTags(newRowNode);
		newRowNode.addClass('u-eip-newitem');
		var subnodes = jQuery('*', newRowNode);
		subnodes.each(function (index, node) {
			self.inspectNode(node);
			self.highlightListNode(node);
			if (jQuery(node).attr('umi:region')) {
				jQuery(node).html(childRowNode);
				jQuery('*', node).each(function(i, n) {
					n = jQuery(n);
					if (!n.children().length) {
						n.text('');
						n.css('display', 'none');
					}
					if (n.attr('href')) {
						n.attr('href', '');
					}
					if (n.attr('umi:' + info.type + '-id')) {
						n.attr('umi:' + info.type + '-id', '');
					}
				});
			}
			cleanTags(node);
		});

		//self.onAfterInlineAdd(newRowNode);

		self.queue.add(info);
		self.normalizeBoxes();
		return true;
	};

	uEditInPlace.prototype.htmlTrim = function (html) {
		html = jQuery.trim(html);
		return html.replace(/<br ?\/?>/g, '').replace(/<p><\/p>/g, '');
	};

	uEditInPlace.prototype.markInversedBoxes = function (nodes) {
		setTimeout(function () {
			if (!nodes) nodes = jQuery('.u-eip-edit-box');
			nodes.each(function (i, node) {
				var color = new RGBColor(jQuery(node).css('color'));
				var colorHash = color.toHash();
				var alpha = (colorHash['red'] / 255 + colorHash['green'] / 255 + colorHash['blue'] / 224) / 3;
				if (alpha >= 0.9) jQuery(node).addClass('u-eip-edit-box-inversed');
			});
		}, 500);
	};

	uEditInPlace.prototype.highlightListNode = function (node) {
		var self = this;
		if(!jQuery(node).attr('umi:module')) return false;

		var box = document.createElement('div');
		document.body.appendChild(box);
		node.boxNode = box;

		var position = self.nodePositionInfo(node);
		if(!position.x && !position.y) return false;

		jQuery(box).attr('class', 'u-eip-add-box');


		jQuery(box).css({
			'position':		'absolute',
			'width':		position.width,
			'height':		position.height,
			'left':			position.x,
			'top':			position.y
		});

		//Add button
		var button = document.createElement('a');
		node.addButtonNode = button;
		jQuery(button).attr({
			'class':		'u-eip-add-button'
		}).html(getLabel('js-panel-add'));
		jQuery(button).hover(function () {
			jQuery(this).addClass('u-eip-add-button-hover');
		}, function () {
			jQuery(this).removeClass('u-eip-add-button-hover');
		});

		var fDim = 'bottom';
		var sDim = 'left';
		var userPos;
		if (userPos = jQuery(node).attr('umi:button-position')) {
			var arr = userPos.split(/ /);
			if(arr.length == 2) {
				fDim = arr[0];
				sDim = arr[1];
			}
		}

		if (jQuery(node).attr('umi:add-method') != 'none') {
			self.placeWith(node, button, fDim, sDim);

			var elementId = jQuery(node).attr('umi:element-id');
			var module = jQuery(node).attr('umi:module');
			var method = jQuery(node).attr('umi:method');
			jQuery(button).bind('mouseup', function () {
				var regionType = jQuery(node).attr('umi:region');
				var addMethod = jQuery(node).attr('umi:add-method');
				var rowNode = self.searchRow(node);

				if (rowNode && (regionType == 'list') && (addMethod != 'popup')) {
					self.inlineAddPage(node);
				}
				else {
					if (self.queue.current >= 0) {
						self.message(getLabel('js-panel-message-save-first'));
						return;
					}

					var url = '/admin/content/eip_add_page/choose/' + parseInt(elementId) + '/' + module + '/' + method + '/';
					jQuery.ajax({
						url : url + '.json',
						dataType : 'json',
						success  : function(data) {
							if (data.data.error) {
								uAdmin.eip.message(data.data.error);
								return;
							}
							jQuery.openPopupLayer({
								'name'   : "CreatePage",
								'title'  : getLabel('js-eip-create-page'),
								'url'    : url
							});
						},
						error : function() {
							uAdmin.eip.message(getLabel('error-require-more-permissions'));
							return;
						}
					});
					jQuery.getJSON(url + '.json', function(data) {
						if (data.data.error) {
							uAdmin.eip.message(data.data.error);
							return;
						}
						jQuery.openPopupLayer({
							'name'   : "CreatePage",
							'title'  : getLabel('js-eip-create-page'),
							'url'    : url
						});
					});
				}
			});


			jQuery(button).hover(function () {
				jQuery(box).addClass('u-eip-add-box-hover');
			}, function () {
				jQuery(box).removeClass('u-eip-add-box-hover');
			});

			document.body.appendChild(button);
		}

		if (jQuery(node).attr('umi:sortable') == 'sortable') {
			jQuery(node).addClass('u-eip-sortable');

			var oldNextItem = null, oldParent = null, movingItem,
				parentInfo, isSorting = false, connectedLists = [];
			jQuery('*').each(function (i, n) {
				if(n.tagName == 'TABLE') return;
				if(jQuery(n).attr('umi:sortable') != 'sortable') return;
				if(jQuery(n).attr('umi:module') != module) return;


				// Filter parent nodes
				var isParent = false;
				jQuery(n).parents().each(function (_i, _n) {
					if(_n == node) {
						isParent = true;
					}
				});
				if(isParent) return;

				// Filter child nodes
				var isChild = false;
				jQuery('*', n).each(function (_i, _n) {
					if(_n == node) {
						isChild = true;
					}
				});
				if(isChild) return;

				connectedLists.push(n);
			});

			jQuery(node).sortable({
				'items': '> *[umi\\:region="row"]',
				'tolerance': 'pointer',
				'cursor': 'move',
				'dropOnEmpty': true,
				'forcePlaceholderSize': true,
				'placeholder': 'u-eip-sortable-placeholder',
				'connectWith': connectedLists,

				'start': function (event, ui) {
					movingItem = ui.item[0];
					jQuery.getJSON('/admin/content/eip_move_page/' + jQuery(movingItem).attr('umi:element-id') + '/.json?check', function(data){
						if (data.error) {
							jQuery(node).sortable('cancel');
							uAdmin.eip.message(data.error);
							return;
						}
						else {
							var nextItem = movingItem.nextSibling;

							do {
								if(!nextItem) break;
								if(nextItem.nodeType != 1) continue;
								if(self.searchRowId(nextItem)) break;
							}
							while(nextItem = nextItem.nextSibling);

							oldNextItem = nextItem;

							parentInfo = self.searchAttr(movingItem.parentNode, function (node) {
								return jQuery(node).attr('umi:sortable') == 'sortable';
							});

							oldParent = movingItem.parentNode;

							isSorting = true;
						}
					});
				},

				'update': function (event, ui) {
					if(!isSorting) {
						return;
					}
					else isSorting = false;

					var movedItem = ui.item[0];
					var nextItem = movedItem.nextSibling;

					do {
						if (!nextItem) break;
						if (nextItem.nodeType != 1) continue;
						if (self.searchRowId(nextItem)) break;
					}
					while(nextItem = nextItem.nextSibling);

					var info = self.searchAttr(movedItem.parentNode, function (node) {
						return jQuery(node).attr('umi:sortable') == 'sortable';
					});
					var parentId = parseInt(info ? info.id : null);

					if(parentId == 0 || parentInfo.id == 0) {
						if(parentId != parentInfo.id) {
							return;
						}
					}
					info.node       = movingItem;
					info.move       = true;
					info.moved      = self.searchRowId(movedItem);
					info.next       = nextItem;
					info.old_next   = oldNextItem;
					info.parent_id  = parentId;
					info.parent     = movedItem.parentNode;
					info.old_parent = oldParent;

					delete info.field_name;

					oldNextItem = null;
					oldParent = null;
					self.normalizeBoxes();
					self.queue.add(info);
				}
			});
		}

		return box;
	};

	/**
		* Получить позиционные параметры html-элемента
	*/
	uEditInPlace.prototype.nodePositionInfo = function (node) {
		node = jQuery(node);

		return {
			'width':	node.innerWidth(),
			'height':	node.innerHeight(),
			'x':		node.offset().left,
			'y':		node.offset().top
		};
	};

	uEditInPlace.prototype.placeWith = function (placer, node, fDim, sDim) {
		if(!placer || !node) return;
		var position = this.nodePositionInfo(placer);
		var region = jQuery(node);

		var x, y;
		switch(fDim) {
			case 'top':
				y = position.y - parseInt(region.css('height'));
				break;

			case 'right':
				x = position.x + position.width;
				break;

			case 'left':
				x = position.x - region.width();
				break;

			default:
				y = position.y + position.height;
		}

		if (fDim == 'top' || fDim == 'bottom') {
			switch(sDim) {
				case 'right':
					x = position.x + position.width - region.width();
					break;

				case 'middle':
				case 'center':
					if (position.width - parseInt(region.css('width')) > 0) {
						x = position.x + Math.ceil((position.width - region.width()) / 2);
					}
					else x = position.x;
					break;

				default: x = position.x;
				x += parseInt(jQuery(placer).css('padding-left'));
			}
		}
		else {
			switch(sDim) {
				case 'top':
					y = position.y;
					break;

				case 'bottom':
					y = position.y + position.height - parseInt(region.css('height'));
					break;

				default:
					if (position.height - parseInt(region.css('height')) > 0) {
						y = position.y + Math.ceil((position.height - parseInt(region.css('height'))) / 2);
					}
					else y = position.y;
			}
		}

		var rightBound = region.width() + x;
		var jWindow = jQuery(window);
		if (rightBound > jWindow.width()) {
			x = jWindow.width() - region.width() - 30;
		}

		try {
			region.css({
				'position':		'absolute',
				'left':			x + 'px',
				'top':			y + 'px',
				'z-index':		560
			});
		} catch(e) {};
	};

	uEditInPlace.prototype.applyStyles = function (originalNode, targetNode) {
		var styles = [
			'font-size', 'font-family', 'font-name',
			'margin-left', 'margin-right', 'margin-top', 'margin-bottom',
			'font-weight'
		], i;
		originalNode = jQuery(originalNode);
		targetNode = jQuery(targetNode);

		for(i in styles) {
			var ruleName = styles[i];
			targetNode.css(ruleName, originalNode.css(ruleName));
		}

		targetNode.width(originalNode.outerWidth());
		targetNode.height(originalNode.outerHeight());
	};

	uEditInPlace.prototype.message = function (msg) {
		jQuery.jGrowl('<p>' + msg + '</p>', {
			'header': 'UMI.CMS',
			'life': 10000
		});
	};

	/**
		* Редактировать элемент
	*/
	uEditInPlace.prototype.edit = function (node, files) {
		if (jQuery(node).hasClass('u-eip-deleted') || jQuery(node).parents().hasClass('u-eip-deleted')) {
			this.message(getLabel('js-panel-message-cant-edit'));
			return false;
		}

		this.finishLast();
		jQuery('.eip-del-button').remove();

		this.previousEditBox = this.editor.get(node, files);

		if (this.previousEditBox) {
			jQuery('.u-eip-add-button, .u-eip-add-box').css('display', 'none');
		}

		jQuery(node).removeClass('u-eip-edit-box u-eip-edit-box-hover u-eip-modified u-eip-deleted u-eip-empty-field u-eip-edit-box-inversed');

		if (this.previousEditBox) {
			jQuery(node).addClass('u-eip-editing');
		}
		var empty = this.trim(jQuery(node).attr('umi:empty'));
		if (empty && this.trim(jQuery(node).html()) == empty) {
			jQuery(node).html('&nbsp;');
			jQuery(node).removeClass('u-eip-empty-field');
		}
		return true;
	};

	uEditInPlace.prototype.trim = function (html) {
		html = jQuery.trim(html);
		return html.replace(/<br ?\/?>/g, '').replace(/<p><\/p>/g, '');
	};

	uEditInPlace.prototype.queue = [];

	uEditInPlace.prototype.queue.add = function(rev) {
		if (this.current == -1) {
			jQuery('#save').addClass('save_me');
		}
		if (this.current < this.length - 1) {
			for (var i = this.length - 1; i > this.current; i--) {
				this.pop();
			}
			this.current = (this.length);
		}
		else ++this.current;

		this.push(rev);
		this.step();
		if (rev.add) {
			uAdmin.eip.message(getLabel('js-panel-message-add-after-save'));
			jQuery(rev.node).css('display', '');
		}
		if (rev.move) {
			jQuery(rev.node.parentNode).addClass('u-eip-modified');
		}
		if (rev['delete']) {
			uAdmin.eip.message(getLabel('js-panel-message-delete-after-save'));
			jQuery(rev.node).addClass('u-eip-deleted');
		}
		jQuery(rev.node).addClass('u-eip-modified');
		return this.length;
	};

	uEditInPlace.prototype.queue.get = function(revision) {
		if (!parseInt(revision)) revision = this.current;
		return this[revision] || null;
	};

	uEditInPlace.prototype.queue.search = function(revision) {
		var i = this.current;
		while(i >= 0) {
			if (this[i].id == revision.id && (this[i].field_name == revision.field_name || this[i].add || this[i].move || this[i]['delete'])) {
				return this[i];
			}
			--i;
		}
		return false;
	};

	uEditInPlace.prototype.queue.back = function(steps) {
		steps = parseInt(steps) || 1;
		while(steps--) {
			if (this[this.current]) {
				this.cancel();
			}
		}
		uAdmin.eip.normalizeBoxes();
		this.step();
	};

	uEditInPlace.prototype.queue.forward = function(steps) {
		steps = parseInt(steps) || 1;
		while(steps--) {
			if (this[this.current + 1]) {
				this.apply();
			}
		}
		uAdmin.eip.normalizeBoxes();
		this.step();
	};

	uEditInPlace.prototype.queue.apply = function () {
		uAdmin.eip.finishLast();
		++this.current;
		var rev = this.get();
		if (!rev.add && !rev.move && !rev['delete'] && !uAdmin.eip.editor.replace(rev, rev.new_value, rev.old_value)) {
			--this.current;
		}
		else {
			switch(true) {
				case rev.add:
					uAdmin.eip.message(getLabel('js-panel-message-add-after-save'));
					jQuery(rev.node).css('display', '');
					break;
				case rev['delete']:
					uAdmin.eip.message(getLabel('js-panel-message-delete-after-save'));
					jQuery(rev.node).addClass('u-eip-deleted');
					break;
				case rev.move:
					if (rev.next) {
						jQuery(rev.node).insertBefore(rev.next);
					}
					else jQuery(rev.node).appendTo(rev.parent);
					jQuery(rev.node).addClass('u-eip-modified');
					jQuery(rev.parent).addClass('u-eip-modified');
					break;
				default:
					jQuery(rev.node).addClass('u-eip-modified');
			}
		}
		if (this.current == 0) {
			jQuery('#save').addClass('save_me');
		}
	};

	uEditInPlace.prototype.queue.cancel = function () {
		uAdmin.eip.finishLast();
		var rev = this.get();
		switch(true) {
			case rev.add:
				--this.current;
				jQuery(rev.node).css('display', 'none');
				break;
			case rev['delete']:
				--this.current;
				jQuery(rev.node).removeClass('u-eip-deleted');
				break;
			case rev.move:
				--this.current;
				if (rev.old_next) {
					jQuery(rev.node).insertBefore(rev.old_next);
				}
				else jQuery(rev.node).appendTo(rev.old_parent);
				jQuery(rev.node).removeClass('u-eip-modified');
				if (!this.search(rev)) {
					jQuery(rev.parent).removeClass('u-eip-modified');
				}
				break;
			default:
				if (uAdmin.eip.editor.replace(rev, rev.old_value, rev.new_value)) {
					--this.current;
					jQuery(rev.node).addClass('u-eip-modified');
				}
		}

		if (rev.add || rev.move || rev['delete'] || uAdmin.eip.editor.replace(rev, rev.old_value, rev.new_value)) {
			if (!this.search(rev)) {
				jQuery(rev.node).removeClass('u-eip-modified');
			}
			if (this.current == -1) {
				jQuery('#save').removeClass('save_me');
				uAdmin.eip.message(getLabel('js-panel-message-changes-revert'));
			}
		}
	};

	uEditInPlace.prototype.queue.step = function () {
		if (this.length) {
			jQuery('#u-quickpanel #save_edit #edit_back').attr('class', (this.current == -1) ? '' : 'ac');
			jQuery('#u-quickpanel #save_edit #edit_next').attr('class', ((this.length - this.current) == 1) ? '' : 'ac');
		}
	};

	uEditInPlace.prototype.queue.save = function (action) {
		uAdmin.eip.finishLast();
		if (this.current == -1 && !action) return false;
		var self = this, node = false, params = {},
			progress = jQuery('div.popupText span', self.progress);

		switch(action) {
			case "add":
				for (i in self.save.add) {
					node = self.save.add[i];
					delete self.save.add[i];
					break;
				}
				if (node) {
					for (i in self.save.added) {
						if (node.parent == i) {
							node.parent = self.save.added[i];
						}
					}
					var uri = '/admin/content/eip_quick_add/' + node.parent + '.json?type-id=' + node.type_id;

					if (jQuery(node.node).attr('umi:module') != 'data') {
						uri += '&force-hierarchy=1';
					}

					jQuery.get(uri, function (data) {
						if (data.error) {
							uAdmin.eip.message(data.error);
							return;
						}

						// Recieve new element id
						var elementId = parseInt(data.data['element-id']);
						var objectId = parseInt(data.data['object-id']);

						self.save.added[node.id] = elementId || objectId;
						jQuery(node.node).removeClass('u-eip-newitem u-eip-modified');
						jQuery(node.node).attr('umi:' + node.type + '-id', elementId || objectId);
						jQuery('*[umi\\:' + node.type + '-id="' + node.id + '"]', node.node).attr('umi:' + node.type + '-id', elementId || objectId);
						node = false;
						uAdmin.eip.normalizeBoxes();
						progress.text(parseInt(progress.text()) + 1);
						--self.save.count;
						self.save('add')
					}, 'json');
				}
				else self.save('move');
				break;
			case "move":
				for (i in self.save.move) {
					node = self.save.move[i];
					delete self.save.move[i];
					break;
				}
				if (node) {
					node.next = (node.next == null ? '' : uAdmin.eip.searchRowId(node.next));
					for (i in self.save.added) {
						if (node.parent_id == i) {
							node.parent_id = self.save.added[i];
						}
						if (node.moved == i) {
							node.moved = self.save.added[i];
						}
						if (node.next == i) {
							node.next = self.save.added[i];
						}
					}
					jQuery.post('/admin/content/eip_move_page/' + node.moved + '/' + node.next + '.json', {'parent-id':node.parent_id}, function (data) {
						if (data.error) {
							uAdmin.eip.message(data.error);
							return;
						}
						jQuery(node.node).removeClass('u-eip-modified');
						jQuery(node.node).parent().removeClass('u-eip-modified');
						uAdmin.eip.message(getLabel('js-panel-message-page-moved'));
						--self.save.count;
						progress.text(parseInt(progress.text()) + 1);
						self.save('move');
					}, 'json');
				}
				else self.save('edit');
				break;
			case "edit":
				for (i in self.save.edit) {
					node = self.save.edit[i];
					delete self.save.edit[i];
					break;
				}

				if (node) {
					for (i in self.save.added) {
						if (node.id == i) {
							node.id = self.save.added[i];
						}
					}
					if (uAdmin.eip.editor.equals(node.new_value, node.old_value)) {
						jQuery(node.node).removeClass('u-eip-modified');
						node = false;
						uAdmin.eip.normalizeBoxes();
						progress.text(parseInt(progress.text()) + 1);
						--self.save.count;
						self.save('edit');
					}
					else {
						params = {};
						params[node.type + '-id'] = node.id
						params.qt = new Date().getTime();
						params['field-name'] = node.field_name;
						var value, i;
						switch(typeof node.new_value) {
							case "object":
								if (node.new_value.src) {
									value = node.new_value.src;
								}
								else {
									value = [];
									for(i in node.new_value) value.push(i);
								}
								break;
							case "string":
								if (jQuery.browser.mozilla && node.new_value.match(/="\.\.\//g)) {
									node.new_value = node.new_value.replace(/="[\.\.\/]+/g, '="/');
								}
								value = node.new_value.replace(/\sumi:[-a-z]+="[^"]*"/g, '');
								break;
							default:
								value = node.new_value;
						}
						params.value = value;

						jQuery.post('/admin/content/editValue/save.json', params, function (data) {
							if (data.error) {
								uAdmin.eip.message(data.error);
								return;
							}

							var newLink = data.property['new-link'];
							if (data.property['old-link'] && newLink) {
								if (node.node.tagName == 'A') {
									node.node.href = newLink;
									jQuery(node.node).bind('click mouseup mousedown', function () {
										return true;
									});
								}
								jQuery('a', node).each(function (i, n) {
									n.href = newLink;
									jQuery(n).bind('click mouseup mousedown', function () {
										return true;
									});
								});
							}

							jQuery(node.node).removeClass('u-eip-modified');
							node = false;
							uAdmin.eip.normalizeBoxes();
							progress.text(parseInt(progress.text()) + 1);
							--self.save.count;
							self.save('edit');
						}, 'json');
					}
				}
				else self.save('del');
				break;
			case "del":
				for (i in self.save.del) {
					node = self.save.del[i];
					delete self.save.del[i];
					break;
				}
				if (node) {
					params = {};
					params[node.type + '-id'] = node.id
					params.qt = new Date().getTime();
					jQuery.post('/admin/content/eip_del_page.json', params, function (data) {
						if (data.error) {
							uAdmin.eip.message(data.error);
						}
						else {
							var rowNode = uAdmin.eip.searchRow(node.node, true);
							if (rowNode) {
								jQuery(rowNode).remove();
							}
							else jQuery(node.node).remove();
							node = false;
							uAdmin.eip.normalizeBoxes();
							progress.text(parseInt(progress.text()) + 1);
							--self.save.count;
							self.save('del');
						}
					}, 'json');
				}
				else {
					self.save.add   = {};
					self.save.added = {};
					self.save.move  = {};
					self.save.edit  = {};
					self.save.del   = {};
					jQuery('#u-quickpanel #save_edit div').attr('class', '');
					uAdmin.eip.message(getLabel('js-panel-message-changes-saved'));
					uAdmin.eip.onsave('after');
				}
				break;
			default:
				uAdmin.eip.onsave('before');
				while(0 <= this.current) {
					if (self[0].add) {
						self.save.add[self[0].id] = self[0];
						++self.save.count;
					}
					else if (this[0].move) {
						if (self.save.move[self[0].moved]) {
							delete self.save.move[self[0].moved];
							--self.save.count;
						}
						self.save.move[self[0].moved] = self[0];
						++self.save.count;
					}
					else if (this[0]['delete']) {
						self.save.del[self[0].id] = self[0];
						++self.save.count;
					}
					else {
						if (self.save.edit[self[0].id + '_' + self[0].field_name]) {
							self.save.edit[self[0].id + '_' + self[0].field_name].new_value = self[0].new_value;
						}
						else {
							self.save.edit[self[0].id + '_' + self[0].field_name] = self[0];
							++self.save.count;
						}
					}
					self.shift();
					--self.current;
				}

				self.progress = jQuery.openPopupLayer({
					name   : "SaveProgress",
					width  : 400,
					height : 200,
					data   : '\n\
						<div class="eip_win_head popupHeader">\n\
							<div class="eip_win_close popupClose">&#160;</div>\n\
							<div class="eip_win_title">Идёт сохранение</div>\n\
						</div>\n\
						<div class="eip_win_body popupBody">\n\
							<div class="popupText">Сохранено <span>0</span> изменений из ' + self.save.count + '.</div>\n\
							<div class="eip_buttons">\n\
								<input type="button" class="primary ok" value="OK" />\n\
								<div style="clear: both;" />\n\
							</div>\n\
						</div>\n\
					'
				}).find('#popupLayer_SaveProgress');

				jQuery('input:button', self.progress).click(function() {
					jQuery.closePopupLayer('SaveProgress');
				});

				self.save('add');
		}
		return false;
	};

	uEditInPlace.prototype.queue.save.add   = {};
	uEditInPlace.prototype.queue.save.added = {};
	uEditInPlace.prototype.queue.save.move  = {};
	uEditInPlace.prototype.queue.save.edit  = {};
	uEditInPlace.prototype.queue.save.del   = {};
	uEditInPlace.prototype.queue.save.count = 0;

	uEditInPlace.prototype.queue.current = -1;

	uEditInPlace.prototype.enabled = false;
	uEditInPlace.prototype.previousEditBox = null;
	uEditInPlace.prototype.editNodes = [];
	uEditInPlace.prototype.listNodes = [];
	uEditInPlace.prototype.meta = {};

	return extend(uEditInPlace, this);
});