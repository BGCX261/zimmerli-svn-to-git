<?php

abstract class __custom_users
{

	//TODO: Write here your own macroses

	public function checkLogged($template = "default")
	{
		if (!$template)
			$template = "default";

		if (!$this->is_auth())
		{
			list($template_reg_form) = def_module::loadTemplates("users/" . $template, "login_registration_form");

			$from_page = getRequest('from_page');

			if (!$from_page)
			{
				$from_page = getServer('REQUEST_URI');
			}
			$block_arr = Array();
			$block_arr['from_page'] = def_module::protectStringVariable($from_page);

			return def_module::parseTemplate($template_reg_form, $block_arr, false);
		} else
		{
			return;
		}
	}
	
	public function json_check_fields ()
	{
	    $this->flush();
	}

}

?>