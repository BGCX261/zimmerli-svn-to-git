var uAdmin = (function () {

	var register = function() {
		var checkClass = function(parent, parent_str) {
			for (var i in parent.reg) {
				if (parent.reg[parent_str]) {
					return parent.reg[parent_str];
				}
				else {
					return checkClass(parent.reg[i], parent_str);
				}
			}
			return false;
		};

		var name, value, parent, params = arguments[0];

		if (params.length) {
			if (typeof params[0] == 'object') {
				if (Object.prototype.toString.call(params[0]) == '[object Array]') {
					return false;
				}
				for (var i in params[0]) {
					register([i, params[0][i], params[1]||null]);
				}
				return true;
			}
			else if (typeof params[0] == 'string') {
				if (typeof params[1] == 'undefined') return false;
				name = params[0];
				value = params[1];
				parent = params[2]||null;
			}
			else return false;
		}
		else return false;

		if (!parent) parent = uAdmin;
		if (typeof parent == 'string') parent = checkClass(uAdmin, parent);
		if (typeof parent != 'function') return false;

		var isclass = false;
		name = name.split('.');
		if (name.length > 1) isclass = true;

		name = name.pop();

		var reg = function() {
			parent.reg[name] = value;
			if (isclass) parent.reg[name].isclass = true;
		};
		if (!parent.reg) parent.reg = reg;
		reg();

		return true;
	};

	function uAdmin() {
		if (uAdmin.prototype.instanse == null) {
			uAdmin.prototype.instanse = new uAdmin.prototype.get();
		}
		register(arguments);
		return uAdmin.prototype.instanse;
	}

	uAdmin.prototype.get = function() {
		return this;
	};

	uAdmin.prototype.get.prototype = uAdmin.prototype;

	uAdmin.prototype.init = function() {
		uAdmin.load(uAdmin);
		delete uAdmin.reg;
		delete uAdmin.load;
	};

	if (typeof JSON == 'undefined') {
		JSON = {parse:function(str){
			try {
				if (str.match(/^{/g)) {
					var val = eval('(' + str + ')');
					if (Object.prototype.toString.call(val) == '[object Object]') {
						return val;
					}
				}
				throw new SyntaxError('JSON.parse: unexpected end of data');
			}
			catch (e) {
				throw new SyntaxError('JSON.parse: unexpected end of data');
			}
		}};
	}

	var data = jQuery.ajax({
		url: location.pathname + '.json' + location.search,
		dataType: 'json',
		async : false
	});
	uAdmin('data', JSON.parse(data.responseText));

	uAdmin.load = function(parent) {
		for (var i in parent.reg) {
			if (parent.reg[i].reg) {
				uAdmin.load(parent.reg[i]);
			}
			if (parent.reg[i].isclass) {
				var extend = function(usedClass, extendClass) {
					for (var i in extendClass) usedClass.prototype[i] = extendClass[i];
					return new usedClass();
				}
				if (parent == uAdmin) {
					parent[i] = new parent.reg[i](extend);
				}
				else {
					parent.prototype[i] = new parent.reg[i](extend);
				}
			}
			else if (parent == uAdmin) {
				parent[i] = parent.reg[i];
			}
			else {
				parent.prototype[i] = parent.reg[i];
			}
		}
	};

	return uAdmin;
})();

jQuery(document).ready(function(){
	uAdmin().init();
});
