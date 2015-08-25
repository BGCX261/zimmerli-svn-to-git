<?php
	abstract class __social_networks extends baseModuleAdmin {

		public function _network_settings($network) {
			$this->setHeaderLabel(getLabel("header-social_networks-settings") . $network->getName());

			$mode = getRequest("param0");
			$cmsController = cmsController::getInstance();

			$type = $network->getCodeName();

			$module = $cmsController->getCurrentModule();
			$method = $cmsController->getCurrentMethod();
			$config = mainConfiguration::getInstance();
			$templateId = $config->get("templates", "{$module}.{$method}");

			$inputData = array(
				'object' => $network->getObject(),
				'type' => $type
			);

			if($mode == "do") {
				$config->set("templates", "{$module}.{$method}", getRequest('template-id'));
				$object = $this->saveEditedObjectData($inputData);
				$this->chooseRedirect($this->pre_lang . '/admin/social_networks/' . $type . '/');
			}

			$this->setDataType("form");
			$this->setActionType("modify");

			$data = $this->prepareData($inputData, "object");
			$data['template-id'] = array('@id' => $templateId);

			$this->setData($data);
			return $this->doData();
		}

	};
?>