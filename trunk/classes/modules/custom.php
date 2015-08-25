<?php
	class custom extends def_module {
		public function cms_callMethod($method_name, $args) {
			return call_user_func_array(Array($this, $method_name), $args);
		}
		
		public function __call($method, $args) {
			throw new publicException("Method " . get_class($this) . "::" . $method . " doesn't exists");
		}
		//TODO: Write your own macroses here
		public function get_header_phone_number()
		{
		    return regedit::getInstance()->getVal('//modules/emarket/header-phone-number');
		}
	};
?>