uAdmin('.session', function (extend) {
	function uSession() {
		var self = this;
		self.lifetime = parseInt(self.lifetime) || 10;
		self.access = !!self.access;

		self.setLastAction();
		self.setCurrentPeriod();

		self.last_pinged_success   = true;
		self.window_warning_closed = false;
		self.window_session_closed = false;

		(function init() {
			jQuery(document).bind('click keydown mousedown', function() {
				self.setLastAction();
			});

			setTimeout(function() {
				jQuery( 'iframe' ).each( function() {
					try {
						var d = this.contentWindow || this.contentDocument;
						if ( d.document ) {
							d = d.document;
							jQuery(d).bind('click keydown mousedown', function() {
								self.setLastAction()
							});
						}
					} catch (e) { }
				});
			}, 30 * 1000);

			self.timerAutoPing = setInterval(function() {
				self.checkAutoPing();
			}, 60 * 1000);
		})();
	}

	uSession.prototype.showWarningMessage = function(clear_interval) {
		var self = this;

		if (clear_interval) {
			clearInterval(self.timer);
			self.timer = null;
		}

		if (self.timer) return;

		self.session_close_time = new Date();
		self.session_close_time.setMinutes (self.session_close_time.getMinutes() + 1);

		self.timer = setInterval(function() {
			var time = new Date();
			var totalRemains=(self.session_close_time.getTime() - time.getTime());

			// отображается таймер
			if (totalRemains > 1) {
				var RemainsSec = (parseInt(totalRemains / 1000));

				var RemainsMinutes = (parseInt(RemainsSec / 60));

				var lastSec = RemainsSec - RemainsMinutes * 60;//осталось секунд
				if (lastSec < 10) lastSec = "0" + lastSec;

				var msg = RemainsMinutes + ":" + lastSec;

				var timeNoUserHereMin = parseInt((new Date().getTime() - self.last_action_time.getTime()) / 60 / 1000);

				self.message("Вы отсутствуете " + timeNoUserHereMin + " мин. " + "Сессия скоро закончится <br>" + msg);
			}
			else {
				clearInterval(self.timer);
				self.timer = null;

				jQuery.get("/session.php", function(data) {
					switch(data) {
						case 'closed' : {
							self.sessionCloseMessage(true);
							break;
						}
						case 'warning' : {
							self.showWarningMessage(true);
							break;
						}
						case 'ok' : {
							self.closeMessage();
							self.setCurrentPeriod();
							break;
						}
					}
				});
			}
		}, 1000);
	};

	uSession.prototype.sessionCloseMessage = function(clear_interval) {
		var self = this;

		if (clear_interval) {
			clearInterval(self.timer);
			self.timer = null;
		}

		if (self.timer) return;

		self.last_pinged_success  = false;

		var msg = jQuery('<div><br />Вы отсутствовали более ' + self.lifetime + ' мин, поэтому Ваша сессия была закончена.<br/><br/></div>');

		var form = jQuery('\n\
			<form>\n\
				<table cellspacing="5" width="100%" style="font-size:12px;">\n\
					<tr>\n\
						<td>Логин: </td>\n\
						<td><input type="text" name="session_contorl_login" /></td>\n\
					</tr>\n\
					<tr>\n\
						<td>Пароль:</td>\n\
						<td><input type="password" name="session_contorl_passsword" /></td>\n\
					</tr>\n\
				</table>\n\
				<br/>\n\
				<input type="submit" value="Хочу продлить сессию">\n\
			</form>\n\
		').appendTo(msg);

		if (self.access) {
			jQuery("<br/> <br/><a href='/admin/config/main/' target='_blank'>Настроить таймаут неактивности</a>").appendTo(form);
		}

		form.submit(function() {
			var login  = jQuery.trim(this.session_contorl_login.value),
				passwd = jQuery.trim(this.session_contorl_passsword.value);

			if (login && passwd) {
				self.ping(login, passwd, function(d) {
					if (d == 'ok') {
						self.closeMessage();
						clearInterval(self.timer);
						self.timer = null;
						jQuery.jGrowl('Сессия успешно восстановлена!', {
							'header': 'UMI.CMS',
							'life': 5000
						});
					}
					else {
						jQuery.jGrowl('Ошибка! Неправильный логин или пароль', {
							'header': 'UMI.CMS',
							'life': 5000
						});
					}
					self.setCurrentPeriod();
				});
			}
			else {
				jQuery.jGrowl('Укажите логин и пароль для восстановления сессии!', {
					'header': 'UMI.CMS',
					'life': 5000
				});
			}
			return false;
		});

		self.message(msg);

		self.timer = 1;

		self.setCurrentPeriod();
	};

	uSession.prototype.message = function(msg) {
		var self = this;

		if (typeof msg == 'string') {
			msg = '<br/><p> ' + msg + ' </p>';
		}

		if (!self.jgrowl) {
			self.jgrowl = jQuery('<div id="SessionjGrowl"></div>').addClass( 'top-right' ).appendTo('body');

			self.jgrowl.jGrowl(msg, {
				header     : 'UMI.CMS',
				dont_close : true,
				close      : function() {
					self.jgrowl = false;
				}
			});

			return;
		}

		var o = self.jgrowl.find('.jGrowl-notification .jGrowl-message');

		if (typeof msg == 'string') o.html(msg);
		else {
			o.html("");
			o.append(msg);
		}
	};

	uSession.prototype.closeMessage = function() {
		var o = this.jgrowl;

		if (o && o.length) {
			o.data('jGrowl.instance').shutdown();
			o.remove();
		}
		this.jgrowl = false;
	};

	uSession.prototype.destroy = function() {
		if (this.timerAutoPing) {
			clearInterval(this.timerAutoPing);
		}

		if (this.timer) {
			clearInterval(this.timer);
			this.timer = 0;
		}

		return true;
	};

	uSession.prototype.ping = function(login, password, handler) {
		var self = this, params = {};

		if (login) {
			params = {'u-login':login, 'u-password':password};
		}

		jQuery.post('/users/ping/', params, function(data) {
			self.last_pinged_success = (data == 'ok') ? true : false;

			if (self.timerAutoPing) {
				clearInterval(self.timerAutoPing);
			}

			self.timerAutoPing = setInterval(function() {
				self.checkAutoPing();
			}, 60 * 1000);

			if (typeof handler == 'function') handler(data);
		});
	};

	uSession.prototype.setCurrentPeriod = function() {
		this.current_period_start_time = new Date();
		this.current_period_end_time   = new Date();

		var time = this.current_period_start_time.getMinutes() + this.lifetime;
		this.current_period_end_time.setMinutes(time);
	};

	uSession.prototype.setLastAction = function() {
		this.last_action_time  = new Date;

		if (this.last_pinged_success) {
			this.closeMessage();
			clearInterval(this.timer);
			this.timer = null;
		}
	};

	uSession.prototype.startAutoActions = function() {
		var self = this;
		self.timerAutoAction = setInterval(function() {
			self.setLastAction();
		}, 60000)
	};

	uSession.prototype.stopAutoActions = function() {
		if (this.timerAutoAction) {
			clearInterval(this.timerAutoAction);
		}
	};

	uSession.prototype.getLastAction = function() {
		return this.last_action_time;
	};

	uSession.prototype.isUserhere = function() {
		var time_left_min = (new Date().getTime() - this.last_action_time.getTime()) / 60000;

		var f = false;
		if (time_left_min < this.lifetime - 0.2) {
			f = true;
		}

		return f;
	};

	uSession.prototype.checkAutoPing = function() {
		// сессия была закрыта
		// окно восстановления
		if (!this.last_pinged_success) {
			this.sessionCloseMessage();
			return false;
		}

		// отображается окно
		if (this.timer) return false;

		var self = this, it_is_time = false,
			time_left_min = (self.current_period_end_time.getTime() - new Date().getTime()) / 60000;

		if (time_left_min < 1.2) it_is_time = 1;

		if (!it_is_time) return false;

		var is_user_here = self.isUserhere();

		// прошлые сессии были продлены
		// осталось примерно минута, пользователя нет
		if (is_user_here === false) {
			// возможно пользователь открывал другими вкладками
			// узнаем это на сервере
			jQuery.get("/session.php", function(data) {
				this.settings_link = false;
				switch(data) {
					case 'ok': {
						return;
					}
					case 'closed': {
						self.sessionCloseMessage();
						break;
					}
					case 'warning': {
						self.showWarningMessage();
						break;
					}
					case 'warning_settings': {
						this.settings_link = true;
						self.showWarningMessage();
					}
				}
			});
		}
		else {
			// пользователь нажимал кнопки, последний период был продлен, пингуем снова
			self.closeMessage();
			self.ping();
			self.setCurrentPeriod();
		}
		return false;
	};

	return extend(uSession, this);
});