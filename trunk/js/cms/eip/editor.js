uAdmin('.editor', function (extend) {
	function uEditor() {}

	uEditor.prototype.get = function(node, files) {
		var info = uAdmin.eip.searchAttr(node);

		if (info) {
			this.info = info;
			this.files = files;
			return this.load();
		}
		return false;
	}

	/**
		* Получить текущее значение поля
	*/
	uEditor.prototype.load = function () {
		var self = this, data, params, i, group, field,
			revision = uAdmin.eip.queue.search(self.info);

		if (revision) {
			if (revision.add) {
				if (self.info.field_name == 'name') {
					self.info.field_type = 'string';
				}
				else {
					data = jQuery.ajax({
						url : '/utype/' + revision.type_id + '.json',
						async : false,
						dataType : 'json'
					});
					data = JSON.parse(data.responseText);

					for (group in data.type.fieldgroups.group) {
						group = data.type.fieldgroups.group[group];
						for (field in group.field) {
							field = group.field[field];
							if (field.name == self.info.field_name) {
								self.info.field_type = field.type['data-type'];
								break;
							}
						}
						if (self.info.field_type) break;
					}
				}
				self.info.old_value = jQuery(self.info.node).attr('umi:empty');
				return self.draw(self.info.field_type);
			};

			self.info.old_value  = revision.new_value;
			self.info.field_type = revision.field_type;
			self.info.params     = revision.params;
			self.info.node       = revision.node;
			if (self.info.field_type == 'relation') {
				self.info.guide_id  = revision.guide_id;
				self.info.multiple  = revision.multiple;
				self.info['public'] = revision['public'];
			}
			return self.draw(revision.field_type);
		}

		params = {};
		params[self.info.type + '-id'] = self.info.id;
		params['field-name'] = self.info.field_name;
		params.qt = new Date().getTime();

		data = jQuery.ajax({
			url : '/admin/content/editValue/load.json',
			async : false,
			data : params,
			type : 'POST',
			dataType : 'json'
		});

		data = JSON.parse(data.responseText);
		if (data.error) {
			uAdmin.eip.message(data.error);
			return false;
		}

		if (data.user && data.user.type == 'guest') {
			uAdmin.eip.message(getLabel('error-auth-required'));
			uAdmin.eip.closeMessages();
			uAdmin.session.sessionCloseMessage(true);
			return false;
		}

		self.info.old_value = {};

		switch(data.property.type) {
			case 'relation':
				for(i in data.property.item) {
					self.info.old_value[data.property.item[i].id] = data.property.item[i].name;
				}
				self.info.guide_id  = data.property['guide-id'];
				self.info.multiple  = (data.property.multiple == 'multiple');
				self.info['public'] = (data.property['public'] == 'public');
				break;
			case 'symlink':
				for(i in data.property.page) {
					self.info.old_value[data.property.page[i].id] = data.property.page[i].name;
				}
				break;
			default:
				self.info.old_value = data.property.value;
		}

		self.info.field_type = data.property.type;

		return self.draw(data.property.type);
	};

	uEditor.prototype.bindFinishEvent = function() {
		var self = this;
		jQuery(document).bind('click', function(e) {
			if (!uAdmin.eip.enabled) return;
			if(jQuery(e.target).attr('contentEditable') == 'true') return;
			if(jQuery(e.target).attr('class') == 'eip-ui-element') return;
			if(jQuery(e.target).attr('class') == 'ui-datepicker') return;
			if(jQuery(e.target).attr('class') == 'symlink-item-delete') return;
			if(jQuery(e.target).parents('.eip-ui-element, .ui-datepicker, .ui-datepicker-title, .ui-datepicker-header, .ui-datepicker-calendar').size()) return;
			var parents = jQuery(e.target).parents();
			for(var i = 0; i < parents.size(); i++) {
				var pNode = parents[i];
				if(pNode.tagName == 'TABLE') continue;
				if(pNode.tagName == 'BODY') break;
				if(jQuery(pNode).attr('class') == 'symlink-item-delete') return;
				if(jQuery(pNode).attr('contentEditable') == 'true') return;
				if(jQuery(pNode).attr('class') && jQuery(pNode).attr('class').indexOf('mceEditor') != -1) return;
			}

			self.finish(true);
		});
	};

	uEditor.prototype.draw = function(type) {
		var self = this;

		if (typeof self.draw[type] == 'function') {
			return self.draw[type](self);
		}
		uAdmin.eip.message('Unkown field type "' + type + '"');
		return false;
	};

	uEditor.prototype.draw['boolean'] = function(self) {
		var position = uAdmin.eip.nodePositionInfo(self.info.node);
		if (typeof self.info.old_value != 'boolean') {
			self.info.old_value = !!self.info.old_value;
		}

		if (self.info.node.tagName == 'INPUT' && self.info.node.type == 'checkbox') {
			setTimeout(function () {
				self.info.new_value = !self.info.old_value;
				self.info.node.checked = self.info.new_value;
				self.commit();
				self.cleanup();
			}, 300);
			return self;
		}

		var checkboxNode = document.createElement('input');
		checkboxNode.type = 'checkbox';
		document.body.appendChild(checkboxNode);

		self.finish = function (apply) {
			if (apply) {
				self.info.new_value = !self.info.old_value;
				jQuery(self.info.node).text(self.info.new_value ? 'Да' : 'Нет');
				self.commit();
			}

			jQuery(checkboxNode).remove();
			self.info.node.style.visibility = 'visible';
			self.cleanup();
		};

		checkboxNode.checked = !!self.info.old_value;
		jQuery(checkboxNode).attr('class', 'eip-ui-element eip-ui-boolean');
		jQuery(checkboxNode).css({
			'position' : 'absolute',
			'left'     : position.x,
			'top'      : position.y,
			'z-index'  : 1100
		});
		uAdmin.eip.applyStyles(self.info.node, checkboxNode);
		self.info.node.style.visibility = 'hidden';

		jQuery(checkboxNode).click(function () {
			self.finish(true);
		});
		return self;
	};

	uEditor.prototype.draw['int'] = function(self) {
		return self.draw.text(self);
	};

	uEditor.prototype.draw['float'] = function(self) {
		return self.draw.text(self);
	};

	uEditor.prototype.draw.counter = function(self) {
		return self.draw.text(self);
	};

	uEditor.prototype.draw.price = function(self) {
		return self.draw.text(self);
	};

	uEditor.prototype.draw.string = function(self) {
		return self.draw.text(self);
	};

	uEditor.prototype.draw.tags = function(self) {
		return self.draw.text(self);
	};

	uEditor.prototype.draw.text = function(self, allowHTMLTags) {
		var node = jQuery(self.info.node), source = node.html();

		if (allowHTMLTags) self.info.old_value = self.info.old_value.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
		node.html(self.info.old_value || '&nbsp;');
		node.attr('contentEditable', true);
		node.blur().focus();

		self.finish = function (apply) {
			self.finish = function () {};
			jQuery(document).unbind('keyup');
			//jQuery(document).unbind('keydown');
			jQuery(document).unbind('click');

			node.attr('contentEditable', false);
			jQuery('.u-eip-sortable').sortable('enable');

			if (apply) {
				if (!allowHTMLTags && self.info.field_type != 'wysiwyg') {
					var html = node.html();
					if (html.match(/\s<br>$/g)) html = html.replace(/<br>$/g, '');
					var originalHtml = html;
					html = html.replace(/<!--[\w\W\n]*?-->/mig, '');
					html = html.replace(/<style[^>]*>[\w\W\n]*?<\/style>/mig, '');
					html = html.replace(/<([^>]+)>/mg, '');
					html = html.replace(/(\t|\n)/gi, " ");
					html = html.replace(/[\s]{2,}/gi, " ");
					if (jQuery.browser.safari) {
						html = html.replace(/\bVersion:\d+\.\d+\s+StartHTML:\d+\s+EndHTML:\d+\s+StartFragment:\d+\s+EndFragment:\d+\s*\b/gi, "");
					}
					if (html != originalHtml) node.html(html);
				}
				self.info.new_value = node.html();

				if (self.info.new_value == ' ' || self.info.new_value == '&nbsp;' || self.info.new_value == '<p>&nbsp;</p>') {
					self.info.new_value = '';
					node.html(self.info.new_value);
				}

				if (self.info.field_type != 'wysiwyg' && self.info.field_type != 'text') {
					self.info.new_value = jQuery.trim(self.info.new_value);
					if (self.info.new_value.substr(-4, 4) == '<br>') {
						self.info.new_value = self.info.new_value.substr(0, self.info.new_value.length -4);
					}
				}
				else {
					self.info.new_value = self.info.new_value.replace(/%[A-z0-9_]+(?:%20)+[A-z0-9_]+%28[A-z0-9%]*%29%/gi, unescape);
				}

				switch(self.info.field_type) {
					case "int":
					case "float":
					case "price":
					case "counter":
						self.info.new_value = parseFloat(self.info.new_value);
						break;
				}

				self.commit();
			}
			else node.html(source);
			self.cleanup();
		};

		self.bindFinishEvent();

		var prevWidth = node.width(),
			prevHeight = node.height(),
			timeoutId = null;

		jQuery('.u-eip-sortable').sortable('disable');
		node.focus();

		var prevLength = null;

		jQuery(document).bind('keyup', function (e) {
			if (prevWidth != node.width() || prevHeight != node.height()) {
				prevWidth = node.width();
				prevHeight = node.height();

				if (timeoutId) clearTimeout(timeoutId);
				timeoutId = setTimeout(function () {
					uAdmin.eip.normalizeBoxes();
					timeoutId = null;
				}, 1000);
			}

			if (e.keyCode == 46) {
				if (prevLength == node.html().length) {
					if (prevLength == 1) {
						node.html('');
					}
				}
			}
		}).bind('keydown', function (e) {
			if (e.keyCode == 46) {
				prevLength = node.html().length;
			}

			//Enter key - save content
			if (e.keyCode == 13 && self.info.field_type != 'wysiwyg' && self.info.field_type != 'text') {
				self.finish(true);
				return false;
			}

			//Esc key - cancel and revert original value
			if (e.keyCode == 27) {
				self.finish(false);
				return false;
			}

			return true;
		});
		return self;
	};

	uEditor.prototype.draw.wysiwyg = function(self) {
		var node = jQuery(self.info.node),
			ctrl = false, shift = false, vkey = false, ins = false,
			cleanupHTML = function (html) {
				html = html.replace(/<![\s\S]*?--[ \t\n\r]*>/ig, ' ');
				html = html.replace(/<!--.*?-->/ig, ' ');

				if (jQuery.browser.mozilla) {
					html = html.replace(/<\/?(style|font|title).*[^>]*>/ig, "");
				}

				html = html.replace(/<\/?(title|style|font|meta)\s*[^>]*>/ig, '');
				html = html.replace(/\s*mso-[^:]+:[^;""]+;?/ig, '');
				html = html.replace(/<\/?o:[^>]*\/?>/ig, '');
				html = html.replace(/ style=['"]?[^'"]*['"]?/ig, '');
				html = html.replace(/ class=['"]?[^'">]*['"]?/ig, '');
				html = html.replace(/<span\s*[^>]*>\s*&nbsp;\s*<\/span>/ig, " ");
				html = html.replace(/<span\s*[^>]*>/ig, '');
				html = html.replace(/<\/span\s*[^>]*>/ig, '');
				// Glue
				html = html.replace(/<\/(b|i|s|u|strong|center)>[\t\n]*<\1[^>]*>/gi, "");
				html = html.replace(/<\/(b|i|s|u|strong|center)>\s*<\1[^>]*>/gi, " ");
				// Cut epmty
				html = html.replace(/<(b|i|s|u|strong|center)[^>]*>[\s\t\n\xC2\xA0]*<\/\1>/gi, "");
				// Cut trash symbols
				html = html.replace(/(\t|\n)/gi, " ");
				html = html.replace(/[\s]{2,}/gi, " ");

				if (jQuery.browser.safari) {
					html = html.replace(/\bVersion:\d+\.\d+\s+StartHTML:\d+\s+EndHTML:\d+\s+StartFragment:\d+\s+EndFragment:\d+\s*\b/gi, "");
				}

				return html;
			};

		self.draw.text(self, true);

		jQuery(document).bind('keyup', function (e) {
			if ((e.keyCode == 86 || ctrl) || (e.keyCode == 45 && shift)) {
				var html = cleanupHTML(node.html());
				if (html != node.html()) {
					node.html(html);
				}
				if (ctrl && !e.ctrlKey) ctrl = false
				if (shift && !e.shiftKey) shift = false
			}
			switch(e.keyCode) {
				case 16: if (!ins) shift = false; break;
				case 17: if (!vkey) ctrl = false; break;
				case 45: ins  = false; break;
				case 86: vkey = false; break;
			}
		}).bind('keydown', function(e) {
			switch(e.keyCode) {
				case 16: shift = true; break;
				case 17: ctrl  = true; break;
				case 45: ins   = true; break;
				case 86: vkey  = true; break;
			}
		});

		var wysiwyg = uAdmin.wysiwyg.init(self.info.node);

		var finish = self.finish;
		self.finish = function (apply) {
			wysiwyg.destroy();
			finish(apply);
			uAdmin.eip.bindEvents();
		};
		return self;
	};

	uEditor.prototype.draw.file = function(self, image) {
		var folder = './images/cms/data/',
			fileName = '', file, data, params;

		self.finish = function (apply) {
			if (apply) {
				if (self.info.node.tagName == 'IMG') {
					self.info.node.src = self.info.new_value.src;
				}
				else self.info.node.style.backgroundImage = 'url(' + self.info.new_value.src + ')';
				self.commit();
			}
			self.cleanup();
		};

		if (self.info.old_value) {
			fileName = self.info.old_value.src.split(/\//g).pop();
			folder = '.' + self.info.old_value.src.substr(0, self.info.old_value.src.length - fileName.length - 1);
		}

		if (self.files && self.files.length) {
			file = self.files[0];

			file.folder = folder;
			if (self.info.old_value) {
				file.file = self.info.old_value.src;
			}
			if (image) {
				file.image = 1;
			}

			data = jQuery.ajax({
				url: "/admin/data/uploadfile/",
				async : false,
				data : file,
				type : 'POST',
				dataType : 'json'
			});

			data = JSON.parse(data.responseText);

			if (data.file.path) {
				self.new_value = data.file.path;
				self.finish(true);
			}
			else self.finish();
		}
		else {
			params = {
				folder : folder,
				file   : self.info.old_value.src
			};
			data = jQuery.ajax({
				url: "/admin/data/get_filemanager_info/",
				async : false,
				data : params,
				type : 'POST',
				dataType : 'json'
			});
			data = JSON.parse(data.responseText);

			var qs = 'folder=' + folder;
			if (self.info.old_value) qs += '&file=' + self.info.old_value.src;
			if (image) qs += '&image=1';

			var fm = {
				flash :  {
					height : 460,
					url    : "/styles/common/other/filebrowser/umifilebrowser.html?" + qs
				},
				elfinder : {
					height : 530,
					url    : "/styles/common/other/elfinder/umifilebrowser.html?" + qs + '&lang=' + data.lang + '&file_hash=' + data.file_hash + '&folder_hash=' + data.folder_hash
				}
			};

			jQuery.openPopupLayer({
				name   : "Filemanager",
				title  : getLabel('js-file-manager'),
				width  : 660,
				height : fm[data.filemanager].height,
				url    : fm[data.filemanager].url,
				afterClose : function (value) {
					if (value) {
						if (typeof value == 'object') value = value[0];
						self.info.new_value = value ? {src:value.toString()} : '';
						self.finish(true);
					}
					else self.finish();
				}
			});

			if (data.filemanager == 'elfinder') {
				jQuery('#popupLayer_Filemanager .popupBody').append('\n\
					<div id="watermark_wrapper">\n\
						<label for="add_watermark">' + getLabel('js-water-mark') + '</label>\n\
						<input type="checkbox" name="add_watermark" id="add_watermark">\n\
					</div>\n\
				');
			}
		}
		return self;
	};

	uEditor.prototype.draw.img_file = function(self) {
		return self.draw.file(self, true);
	};

	uEditor.prototype.draw.video_file = function(self) {
		return self.draw.file(self);
	};

	uEditor.prototype.draw.date = function(self) {
		var date = self.info.old_value;

		Date.prototype.getFormattedDate = function (full) {
			var format = function (num) { return (num >= 10) ? num : '0' + num; };

			var year = this.getFullYear();
			var month = format(this.getMonth() + 1);
			var day = format(this.getDate());
			var hours = format(this.getHours());
			var minutes = format(this.getMinutes());

			var reg = /NaN/;

			if(full) {
				if((reg.exec(year) != null) || (reg.exec(month) != null) || (reg.exec(day) != null) || (reg.exec(hours) != null) || (reg.exec(minutes) != null)) {
					var today = new Date();
					return format(today.getDate()) + '.' + format(today.getMonth() + 1) + '.' + today.getFullYear()  + ' ' + format(today.getHours()) + ':' + format(today.getMinutes());
				}
				return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes;
			} else {
				if((reg.exec(hours) != null) || (reg.exec(minutes) != null)) {
					var today = new Date();
					return format(today.getHours()) + ':' + format(today.getMinutes());
				}

				return hours + ':' + minutes;
			}
		};

		if (date) {
			if (date.match(/\d{4}-/g)) {
				date = new Date(date.replace(/(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2})/g, '$2 $3 $1 $4:$5'));
			}
			else {
				date = new Date(date.replace(/(\d{2})\.(\d{2})\.(\d{4})\s(\d{2}):(\d{2})/g, '$2 $1 $3 $4:$5'));
			}
		}
		if (!date) date = new Date;
		if (self.info.old_value) self.info.old_value = date.getFormattedDate(true);

		self.draw.text(self);

		var position = uAdmin.eip.nodePositionInfo(self.info.node);
		var node = jQuery('#u-datepicker-input');
		if (!node.size()) {
			node = document.createElement('input');
			node.id = 'u-datepicker-input';
			document.body.appendChild(node);
		}

		self.finish = function (apply) {
			jQuery(node).datepicker('destroy');
			jQuery('.ui-datepicker-trigger').remove();
			if (!self.info.new_value) {
				self.info.new_value = jQuery(self.info.node).html();
			}
			self.cleanup();
			self.commit();
		};

		jQuery(node).css({
			'position':		'absolute',
			'left':			(position.x + position.width + 5),
			'top':			(position.y),
			'width':		'1',
			'height':		'1',
			'visibility':	'hidden',
			'font-size':	'62.5%',
			'z-index':		560
		});

		jQuery(node).datepicker(jQuery.extend({
			showOn: 'button',
			buttonImage: '/styles/common/other/calendar/icons_calendar_buttrefly_eip.png',
			buttonImageOnly: true,
			'dateFormat':	'yy-mm-dd',
			'defaultDate':	date,
			'onSelect': function (dateText) {
				self.info.new_value = dateText + ' ' + date.getFormattedDate(false);
				jQuery(self.info.node).html(self.info.new_value);
				jQuery(self.info.node).focus();
			}
		}, jQuery.datepicker.regional[uAdmin.data.lang]));

		jQuery(self.info.node).html(self.info.old_value || date.getFormattedDate(true));

		uAdmin.eip.placeWith(self.info.node, jQuery('.ui-datepicker-trigger'), 'right', 'middle');
		if (self.id == '') self.info.old_value = '';
		return self;
	};

	uEditor.prototype.draw.relation = function(self) {
		jQuery(document).one('mouseup', function () {
			setTimeout(function () {
				self.bindFinishEvent();
			}, 100);
		});
		setTimeout(function () {
			jQuery(document).die('mouseup');
			self.bindFinishEvent();
		}, 1000);

		var position = uAdmin.eip.nodePositionInfo(self.info.node);
		var selectBox = document.createElement('select');
		var searchBox = document.createElement('input');
		document.body.appendChild(selectBox);

		if (self.info.guide_id && self.info['public']) {
			var relationButton = document.createElement('input');
			relationButton.type = 'button';
			relationButton.value = ' ';
			relationButton.id = 'relationButton' + self.info.guide_id;
			relationButton.className = 'relationAddButton';
			document.body.appendChild(relationButton);
		}

		jQuery(selectBox).attr('class', 'eip-ui-element');
		jQuery(selectBox).css({
			'position':		'absolute',
			'left':			position.x,
			'top':			position.y,
			'z-index':		1100
		});

		uAdmin.eip.applyStyles(self.info.node, selectBox);
		jQuery(self.info.node).css('visibility', 'hidden');

		if (self.info.multiple) {
			jQuery(selectBox).attr('multiple', 'multiple');
			jQuery(selectBox).attr('size', 3);
		}

		var i;
		for(i in self.info.old_value) {
			var option = document.createElement('option');
			jQuery(option).attr('value', i);
			jQuery(option).attr('selected', 'selected');
			jQuery(option).html(self.info.old_value[i]);
			selectBox.appendChild(option);
		}

		jQuery(selectBox).focus();
		jQuery(selectBox).attr('name', 'rel_input');
		jQuery(selectBox).attr('id', 'relationSelect' + self.info.guide_id);

		document.body.appendChild(searchBox);

		uAdmin.eip.applyStyles(self.info.node, searchBox);
		jQuery(searchBox).attr({
			'id'    : 'relationInput' + self.info.guide_id,
			'class' : 'eip-ui-element',
			'name'  : 'rel_input_new'
		});

		if (typeof relationControl == 'undefined') {
			jQuery('<script src="/styles/common/js/relation.control.js" type="text/javascript" charset="utf-8"></script>').appendTo('head');
		}

		var control = new relationControl(self.info.guide_id, null, true, '/admin/data/guide_items_all/');

		self.finish = function () {
			var value = [];
			self.info.new_value = control.getValue();
			self.commit();

			for (var i in self.info.new_value) {
				value.push(self.info.new_value[i]);
			}
			self.info.node.innerHTML = value.join(', ');;
			self.info.node.style.visibility = 'visible';

			jQuery(selectBox).resizable('destroy');
			jQuery(selectBox).remove();
			jQuery(searchBox).remove();
			jQuery(relationButton).remove();
			jQuery('#u-ep-search-trigger').remove();

			self.cleanup();
		};

		control.loadItemsAll();

		if (self.info.multiple) {
			var minHeight = jQuery(selectBox).height(), maxHeight = 350;
			if (minHeight < 150) {
				minHeight = 75;
				jQuery(selectBox).css('height', minHeight);
			}

			jQuery(selectBox).resizable({
				'minWidth' : jQuery(selectBox).width(),
				'maxWidth' : jQuery(selectBox).width(),
				'minHeight': minHeight,
				'maxHeight': maxHeight
			});

			jQuery('.ui-wrapper').css('z-index', '1100');
		}
		jQuery(searchBox).css({
			'position' : 'absolute',
			'width'    : jQuery(selectBox).width(),
			'left'     : position.x,
			'top'      : (position.y + jQuery(selectBox).height()+5),
			'z-index'  : 1111
		});
		jQuery(relationButton).css({
			'position' : 'absolute',
			'left'     : (position.x + jQuery(searchBox).width() + 5),
			'top'      : (position.y + jQuery(selectBox).height() + Math.round((jQuery(searchBox).height() - jQuery(relationButton).height()) / 2)),
			'z-index'  : 1112
		});
		return self;
	};

	uEditor.prototype.draw.symlink = function(self) {
		jQuery(document).one('mouseup', function () {
			setTimeout(function () {
				self.bindFinishEvent();
			}, 100);
		});
		setTimeout(function () {
			jQuery(document).die('mouseup');
			self.bindFinishEvent();
		}, 1000);

		var h_type = jQuery(self.info.node).attr('umi:type') ? jQuery(self.info.node).attr('umi:type').split('::') : [];
		var position = uAdmin.eip.nodePositionInfo(self.info.node);
		var searchBox = jQuery('<div><div id="symlinkInput' + self.info.id + '" /></div>').attr({
			"class":'eip-ui-element'
		}).css({
			'position':'absolute',
			'left': position.x,
			'top': position.y,
			'z-index':1100
		}).appendTo('body');

		if (typeof symlinkControl == 'undefined') {
			jQuery('<script src="/styles/common/js/symlink.control.js" type="text/javascript" charset="utf-8"></script>').appendTo('head');
		}

		var control = new symlinkControl(self.info.id, (h_type[0] || null), h_type, {
			inputName      : self.info.field_name + '[]',
			fadeColorStart : [255, 255, 225],
			fadeColorEnd   : [255, 255, 255]
		});

		for (var i in self.info.old_value) {
			control.addItem(i, self.info.old_value[i], h_type, '');
		}

		uAdmin.eip.applyStyles(self.info.node, searchBox[0]);
		jQuery('div input:text', searchBox).css({'width':searchBox.width() - 20});
		jQuery('div img.treeButton', searchBox).css({'bottom': '-4px', 'margin-left': '2px', 'position': 'relative', 'background-color': 'white', 'cursor': 'pointer'});
		jQuery(self.info.node).css('visibility', 'hidden');

		self.finish = function () {
			var inputs = jQuery('input[name="' + self.info.field_name + '[]"]'), value = [];
			jQuery(self.info.node).css('visibility', 'visible');

			self.info.new_value = {};
			for (i = 0; i < inputs.length; i++) {
				if (inputs[i].value) {
					self.info.new_value[inputs[i].value] = jQuery('ul li span', searchBox)[i - 1].innerHTML;
					value.push(self.info.new_value[inputs[i].value]);
				}
			}
			self.info.node.innerHTML = value.join(', ');;
			self.commit();

			searchBox.resizable('destroy');
			searchBox.remove();
			jQuery('div.symlinkAutosuggest').remove();
			jQuery('#u-ep-search-trigger').remove();

			self.cleanup();
		};

		control.loadItems();
		return self;
	};

	uEditor.prototype.replace = function (info, new_value, old_value) {
		return info ? this.replace[info.field_type](info, new_value, old_value) : false;
	};

	uEditor.prototype.replace.img_file = function(info, new_value, old_value) {
		var isModified = false, node = jQuery(info.node), childs, subNode, i;

		var compare = function (left, right) {
			return left == right;
		};

		var checkIsThumb = function (src) {
			if(src.indexOf('/images/cms/thumbs/') >= 0) return true;
			if(src.indexOf('/images/autothumbs/') >= 0) return true;
			return false;
		};

		var makeNewThumb = function (src, width, height) {
			src = src.toString();
			var tempArr = src.split(/\./g);
			if(tempArr.length < 2) return false;

			var ext = tempArr[tempArr.length - 1].toString();
			tempArr = tempArr[tempArr.length - 2].toString().split(/\//g);

			var filename = tempArr[tempArr.length - 1].toString();
			var dirname = src.substr(0, src.length - filename.length - ext.length - 1);

			return '/images/autothumbs' + dirname + filename + '_' + width + '_' + height + '.' + ext;
		};

		//If image tag
		if (info.node.tagName == 'IMG') {
			//If image set by src
			if (compare(node.attr('src'), old_value.src || '')) {
				info.node.src = new_value.src || '';
				isModified = true;
			}
			else if(checkIsThumb(info.node.src)) {
				var width = node.width();
				var height = node.height();
				var tSrc = info.node.src;
				if(tSrc.indexOf(width) != -1 && tSrc.indexOf(height) == -1) height = 'auto';
				if(tSrc.indexOf(width) == -1 && tSrc.indexOf(height) != -1) width = 'auto';

				info.node.src = makeNewThumb(new_value.src, width, height);
				isModified = true;
			}

			node.one('load', function () {
				uAdmin.eip.normalizeBoxes();
			});
		}

		//If image set by css background
		var bg_image = info.node.style.backgroundImage.replace(/"/g, '');
		if (bg_image.substr(0, 4) != 'url(') {
			if (!isModified && node.attr('childNodes')) {
				childs = node.attr('childNodes');

				for(i = 0; i < childs.length; i++) {
					subNode = childs.item(i);
					if (subNode && jQuery(subNode).attr('tagName')) {
						replaceImage(jQuery(subNode), new_value.src, old_value.src);
					}
				}
			}
			return isModified;
		}

		bg_image = bg_image.substring(4, bg_image.length - 1);
		var httpHost = window.location.protocol + '//' + window.location.host;
		if (bg_image.substr(0, httpHost.length) == httpHost) {
			bg_image = bg_image.substr(httpHost.length);
		}
		if (!bg_image) return isModified;

		if (compare(bg_image, old_value.src)) {
			info.node.style.backgroundImage = 'url(' + new_value.src + ')';
			isModified = true;
		}

		if (!isModified && node.attr('childNodes')) {
			childs = node.attr('childNodes');
			for(i = 0; i < childs.length; i++) {
				subNode = childs.item(i);
				if (subNode && jQuery(subNode).attr('tagName')) {
					replaceImage(jQuery(subNode), new_value.src, old_value.src);
				}
			}
		}
		return isModified;
	};

	uEditor.prototype.replace.video_file = function (info, new_value, old_value) {
		var getFlexApp = function (appName) {
			return (navigator.appName.indexOf ("Microsoft") != -1) ? window[appName] : document[appName];
		};

		getFlexApp('UmiVideoPlayer').setVideoFile(new_value);
		return true;
	};

	uEditor.prototype.replace['boolean'] = function(info, new_value, old_value) {
		if (info.node.tagName == 'INPUT' && info.node.type == 'checkbox') {
			info.node.checked = new_value ? true : false;
		}
		else {
			jQuery(info.node).html(new_value ? 'Да' : 'Нет');
		}
		return true;
	};

	uEditor.prototype.replace.relation = function(info, new_value, old_value) {
		var html = [], i;
		for (i in new_value) {
			html.push(new_value[i]);
		}
		jQuery(info.node).html(html.join(', '));
		return true;
	};

	uEditor.prototype.replace.symlink = function(info, new_value, old_value) {
		var html = '', i;

		for(i in new_value) {
			html += '<span>' + new_value[i] + '</span><br />';
		}

		jQuery(info.node).html(html);
		return true;
	};

	uEditor.prototype.replace['int'] = function(info, new_value, old_value) {
		return this.text(info, new_value, old_value);
	};

	uEditor.prototype.replace['float'] = function(info, new_value, old_value) {
		return this.text(info, new_value, old_value);
	};

	uEditor.prototype.replace.counter = function(info, new_value, old_value) {
		return this.text(info, new_value, old_value);
	};

	uEditor.prototype.replace.price = function(info, new_value, old_value) {
		return this.text(info, new_value, old_value);
	};

	uEditor.prototype.replace.string = function(info, new_value, old_value) {
		return jQuery(info.node).html(new_value);
	};

	uEditor.prototype.replace.tags = function(info, new_value, old_value) {
		return this.text(info, new_value, old_value);
	};

	uEditor.prototype.replace.text = function(info, new_value, old_value) {
		return jQuery(info.node).html(new_value);
	};

	uEditor.prototype.replace.wysiwyg = function(info, new_value, old_value) {
		return jQuery(info.node).html(new_value||'&nbsp;');
	};

	uEditor.prototype.replace.file = function(info, new_value, old_value) {
		return this.text(info, new_value, old_value);
	};

	uEditor.prototype.replace.date = function(info, new_value, old_value) {
		return this.text(info, new_value, old_value);
	};

	uEditor.prototype.commit = function() {
		var new_value = this.info.new_value,
			old_value = this.info.old_value;
		if (this.info.field_type.match(/file/)) {
			new_value = this.info.new_value.src;
			old_value = this.info.old_value.src;
		}
		if (!this.equals(new_value, old_value)) {
			jQuery(this.info.node).addClass('u-eip-modified');
			uAdmin.eip.queue.add(this.info);
		}
		else {
			if (uAdmin.eip.queue.search(this.info)) {
				jQuery(this.info.node).addClass('u-eip-modified');
			}
		}
	};

	uEditor.prototype.cleanup = function () {
		uAdmin.eip.bindEvents();

		this.finish = function() {
			this.cleanup();
		};

		uAdmin.eip.highlightNode(this.info.node);
		jQuery('.u-eip-add-button').css('display', 'block');
		uAdmin.eip.normalizeBoxes();

		this.info.node.blur();
		jQuery(this.info.node).removeClass('u-eip-editing');
	};

	uEditor.prototype.finish = function() {
		this.cleanup();
	};

	uEditor.prototype.equals = function() {
		var result = false, arg = arguments,
			os = Object.prototype.toString, i, temp = {length:0};

		switch(true) {
			case (arg.length !== 2):break;
			case (typeof arg[0] !== typeof arg[1]):break;
			case (os.call(arg[0]) !== os.call(arg[1])):break;
			default:
				switch(typeof arg[0]) {
					case "undefined":break;
					case "object":
						if (os.call(arg[0]) == '[object Array]') {
							result = (arg[0].length === arg[1].length);
							if (result) {
								for (i = 0; i < arg[0].length; i++) {
									temp[arg[0][i]] = i;
									++temp.length;
								}
								for (i = 0; i < arg[1].length; i++) {
									if (delete temp[arg[0][i]]) {
										--temp.length;
									}
								}
								if (temp.length === 0) result = true;
							}
						}
						else {
							for (i in arg[0]) {
								temp[i] = i;
								++temp.length;
							}
							for (i in arg[1]) {
								if (delete temp[i]) {
									--temp.length;
								}
							}
							if (temp.length === 0) result = true;
							if (result) {
								for (i in arg[0]) {
									result = this.equals(arg[0][i], arg[1][i]);
									if (!result) break;
								}
							}
						}
						break;
					default:
						result = (arg[0] === arg[1]);
				}
		}

		return result;
	};

	return extend(uEditor, this);
}, 'eip');