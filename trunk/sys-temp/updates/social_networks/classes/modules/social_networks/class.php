<?php
	class social_networks extends def_module {
		public $current_network = false;

		public function __construct() {
			parent::__construct();
			if (cmsController::getInstance()->getCurrentModule() == __CLASS__ && cmsController::getInstance()->getCurrentMode() == "admin") {
				$this->__loadLib("__admin.php");
				$this->__implement("__social_networks");
				$networks = social_network::getList();

				$tabs = $this->getCommonTabs();
				foreach ($networks as $id) {
					$network = social_network::get($id);
					$tabs->add($network->getCodeName());
				}
			}
		}

		protected function display_social_frame($network) {
			$cmsController = cmsController::getInstance();

			$path = getRequest('path');
			$path = trim($path, "/");
			$path = explode("/", $path);

			if ($cmsController->getCurrentLang()->getPrefix() == $path[0]) {
				array_shift($path);
			}

			$path = array_slice($path, 2);

			$_REQUEST['path'] = $path = '/'.implode('/',$path);

			if(!$network || !$network->isIframeEnabled()) {
				$buffer = outputBuffer::current();
				$buffer->push("<script type='text/javascript'>parent.location.href = '".$path."';</script>");
				$buffer->end();
			}

			// find element again
			$cmsController->analyzePath(true);

			$current_element_id = $cmsController->getCurrentElementId();

			$cmsController->setUrlPrefix(''. __CLASS__ .'/'.$network->getCodeName());

			if ($cmsController->getCurrentMode() == "admin" || !$network->isHierarchyAllowed($current_element_id)) {
				$buffer = outputBuffer::current();
				$buffer->push("<script type='text/javascript'>parent.location.href = '".$path."';</script>");
				$buffer->end();
			}

			$this->current_network = $network;

			$currentModule = $cmsController->getCurrentModule();
			$cmsController->getModule($currentModule);

			return $cmsController->getGlobalVariables(true);
		}

		public function includeApi($network_code) {
			$network = social_network::getByCodeName($network_code);
			if (!$network) {
				return;
			}
			$sJS = '';
			if ($network->isIframeEnabled()) {
				$sJS .= '<script src="http://vkontakte.ru/js/api/xd_connection.js?2" type="text/javascript"></script>';
			}
			return $sJS;
		}

		public function getCurrentSocial() {
			return $this->current_network;
		}

		public function getCurrentSocialParams($param = '') {
			if (!$this->current_network) {
				return;
			}
			return $this->current_network->getValue($param);
		}

		public function vkontakte() {
			$network = social_network::getByCodeName('vkontakte');
			if ($network) {
				if (cmsController::getInstance()->getCurrentMode() == "admin") {
					return $this->_network_settings($network);
				} else {
					return $this->display_social_frame($network);
				}
			}
			return false;
		}

	};
?>
