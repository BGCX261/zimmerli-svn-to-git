<?php
 class templatesCollection extends singleton implements iSingleton, iTemplatesCollection {private $templates = Array(), $def_template;protected function __construct() {$this->loadTemplates();}public static function getInstance($v4a8a08f09d37b73795649038408b5f33 = NULL) {return parent::getInstance(__CLASS__);}public function addTemplate($v435ed7e9f07f740abf511a62c00eef6e, $vd5d3db1765287eef77d7927cc956f50a, $v662cbf1253ac7d8750ed9190c52163e5 = false, $v78e6dd7a49f5b0cb2106a3a434dd5c86 = false, $vf62baf4c4ead98d50d516eca0ac5a746 = false) {$this->disableCache();cacheFrontend::getInstance()->flush();$ve4e46deb7f9cc58c7abfb32e5570b6f3 = domainsCollection::getInstance();$v5a05866850c28651fe234659f6c92ada = langsCollection::getInstance();if(!$ve4e46deb7f9cc58c7abfb32e5570b6f3->isExists($v662cbf1253ac7d8750ed9190c52163e5)) {if($ve4e46deb7f9cc58c7abfb32e5570b6f3->getDefaultDomain()) {$v662cbf1253ac7d8750ed9190c52163e5 = $ve4e46deb7f9cc58c7abfb32e5570b6f3->getDefaultDomain()->getId();}else {return false;}}if(!$v5a05866850c28651fe234659f6c92ada->isExists($v78e6dd7a49f5b0cb2106a3a434dd5c86)) {if($v5a05866850c28651fe234659f6c92ada->getDefaultLang()) {$v78e6dd7a49f5b0cb2106a3a434dd5c86 = $v5a05866850c28651fe234659f6c92ada->getDefaultLang()->getId();}else {return false;}}$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_templates VALUES()";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$v74f5356453a69e438e0f58ef93103cc0 = l_mysql_insert_id();$v66f6181bcb4cff4cd38fbc804a036db6 = new template($v74f5356453a69e438e0f58ef93103cc0);$v66f6181bcb4cff4cd38fbc804a036db6->setFilename($v435ed7e9f07f740abf511a62c00eef6e);$v66f6181bcb4cff4cd38fbc804a036db6->setTitle($vd5d3db1765287eef77d7927cc956f50a);$v66f6181bcb4cff4cd38fbc804a036db6->setDomainId($v662cbf1253ac7d8750ed9190c52163e5);$v66f6181bcb4cff4cd38fbc804a036db6->setLangId($v78e6dd7a49f5b0cb2106a3a434dd5c86);$v66f6181bcb4cff4cd38fbc804a036db6->setIsDefault($vf62baf4c4ead98d50d516eca0ac5a746);if($vf62baf4c4ead98d50d516eca0ac5a746) {$this->setDefaultTemplate($v74f5356453a69e438e0f58ef93103cc0);}$v66f6181bcb4cff4cd38fbc804a036db6->commit();$v66f6181bcb4cff4cd38fbc804a036db6->update();$this->templates[$v74f5356453a69e438e0f58ef93103cc0] = $v66f6181bcb4cff4cd38fbc804a036db6;return $v74f5356453a69e438e0f58ef93103cc0;}public function setDefaultTemplate($v74f5356453a69e438e0f58ef93103cc0, $v662cbf1253ac7d8750ed9190c52163e5 = false, $v78e6dd7a49f5b0cb2106a3a434dd5c86 = false) {if($v662cbf1253ac7d8750ed9190c52163e5 == false) $v662cbf1253ac7d8750ed9190c52163e5 = domainsCollection::getInstance()->getDefaultDomain()->getId();if($v78e6dd7a49f5b0cb2106a3a434dd5c86 ==false) $v78e6dd7a49f5b0cb2106a3a434dd5c86 = cmsController::getInstance()->getCurrentLang()->getId();if(!$this->isExists($v74f5356453a69e438e0f58ef93103cc0)) {return false;}$vfed36e93a0509e20f2dc96cbbd85b678 = $this->getTemplatesList($v662cbf1253ac7d8750ed9190c52163e5,$v78e6dd7a49f5b0cb2106a3a434dd5c86);foreach ($vfed36e93a0509e20f2dc96cbbd85b678 as $v66f6181bcb4cff4cd38fbc804a036db6) {if($v74f5356453a69e438e0f58ef93103cc0 == $v66f6181bcb4cff4cd38fbc804a036db6->getId()) {$v66f6181bcb4cff4cd38fbc804a036db6->setIsDefault(true);}else {$v66f6181bcb4cff4cd38fbc804a036db6->setIsDefault(false);}$v66f6181bcb4cff4cd38fbc804a036db6->commit();}return true;if(!($v66f6181bcb4cff4cd38fbc804a036db6 = $this->getTemplate($v3200a31fc05da4e9d5a0465c36822e2f))) {return false;}if($this->def_template) {$this->def_template->setIsDefault(false);$this->def_template->commit();}$this->def_template = $v66f6181bcb4cff4cd38fbc804a036db6;$this->def_template->setIsDefault(true);$this->def_template->commit();return true;}public function delTemplate($v74f5356453a69e438e0f58ef93103cc0) {$v74f5356453a69e438e0f58ef93103cc0 = (int) $v74f5356453a69e438e0f58ef93103cc0;$this->disableCache();cacheFrontend::getInstance()->flush();if($this->isExists($v74f5356453a69e438e0f58ef93103cc0)) {if($this->templates[$v74f5356453a69e438e0f58ef93103cc0]->getIsDefault()) {unset($this->def_template);}unset($this->templates[$v74f5356453a69e438e0f58ef93103cc0]);$vb3f91ed738222a77e3713df926f55fd7 = $this->getDefaultTemplate();if (!$vb3f91ed738222a77e3713df926f55fd7 || $vb3f91ed738222a77e3713df926f55fd7->getId() == $v74f5356453a69e438e0f58ef93103cc0) return false;$v9f59b21a53f60f6a67487a5896c52d7f = "UPDATE cms3_hierarchy SET tpl_id = '".$vb3f91ed738222a77e3713df926f55fd7->getId()."' WHERE tpl_id='{$v74f5356453a69e438e0f58ef93103cc0}'";l_mysql_query($v9f59b21a53f60f6a67487a5896c52d7f);$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_templates WHERE id = '{$v74f5356453a69e438e0f58ef93103cc0}'";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);return true;}else return false;}public function getTemplatesList($v662cbf1253ac7d8750ed9190c52163e5, $v78e6dd7a49f5b0cb2106a3a434dd5c86) {$v9b207167e5381c47682c6b4f58a623fb = array();foreach($this->templates as $v66f6181bcb4cff4cd38fbc804a036db6) {if($v66f6181bcb4cff4cd38fbc804a036db6->getDomainId() == $v662cbf1253ac7d8750ed9190c52163e5 && $v66f6181bcb4cff4cd38fbc804a036db6->getLangId() == $v78e6dd7a49f5b0cb2106a3a434dd5c86) {$v9b207167e5381c47682c6b4f58a623fb[] = $v66f6181bcb4cff4cd38fbc804a036db6;}}return $v9b207167e5381c47682c6b4f58a623fb;}public function getDefaultTemplate($v662cbf1253ac7d8750ed9190c52163e5 = false, $v78e6dd7a49f5b0cb2106a3a434dd5c86 = false) {if($v662cbf1253ac7d8750ed9190c52163e5 == false) $v662cbf1253ac7d8750ed9190c52163e5 = cmsController::getInstance()->getCurrentDomain()->getId();if($v78e6dd7a49f5b0cb2106a3a434dd5c86 == false) $v78e6dd7a49f5b0cb2106a3a434dd5c86 = cmsController::getInstance()->getCurrentLang()->getId();$vfed36e93a0509e20f2dc96cbbd85b678 = $this->getTemplatesList($v662cbf1253ac7d8750ed9190c52163e5, $v78e6dd7a49f5b0cb2106a3a434dd5c86);foreach($vfed36e93a0509e20f2dc96cbbd85b678 as $v66f6181bcb4cff4cd38fbc804a036db6) {if($v66f6181bcb4cff4cd38fbc804a036db6->getIsDefault() == true) {return $v66f6181bcb4cff4cd38fbc804a036db6;}}if(sizeof($vfed36e93a0509e20f2dc96cbbd85b678)) {$v8e62a507ba5e75a37beefceaad9fe22c = $vfed36e93a0509e20f2dc96cbbd85b678[0];$this->setDefaultTemplate($v8e62a507ba5e75a37beefceaad9fe22c->getId(), $v662cbf1253ac7d8750ed9190c52163e5, $v78e6dd7a49f5b0cb2106a3a434dd5c86);return $v8e62a507ba5e75a37beefceaad9fe22c;}return false;}public function getCurrentTemplate() {$v594c103f2c6e04c3d8ab059f031e0c1a = cmsController::getInstance();if ($v8e2dcfd7e7e24b1ca76c1193f645902b = umiHierarchy::getInstance()->getElement($v594c103f2c6e04c3d8ab059f031e0c1a->getCurrentElementId(), true)) {$v66f6181bcb4cff4cd38fbc804a036db6 = $this->getTemplate($v8e2dcfd7e7e24b1ca76c1193f645902b->getTplId());}elseif ($vcfb14cbbb0da97c5d6fc00de2231984b = $this->getHierarchyTypeTemplate($v594c103f2c6e04c3d8ab059f031e0c1a->getCurrentModule(), $v594c103f2c6e04c3d8ab059f031e0c1a->getCurrentMethod())) {$v66f6181bcb4cff4cd38fbc804a036db6 = $this->getTemplate($vcfb14cbbb0da97c5d6fc00de2231984b);}else $v66f6181bcb4cff4cd38fbc804a036db6 = $this->getDefaultTemplate();return $v66f6181bcb4cff4cd38fbc804a036db6;}public function getHierarchyTypeTemplate($v22884db148f0ffb0d830ba431102b0b5, $vea9f6aca279138c58f705c8d4cb4b8ce) {$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();$vb80bb7740288fda1f201890375a60c8f = $v2245023265ae4cf87d02c8b6ba991139->get("templates", "{$v22884db148f0ffb0d830ba431102b0b5}.{$vea9f6aca279138c58f705c8d4cb4b8ce}");return $this->isExists($vb80bb7740288fda1f201890375a60c8f) ? $vb80bb7740288fda1f201890375a60c8f : false;}public function getTemplate($v74f5356453a69e438e0f58ef93103cc0) {return ($this->isExists($v74f5356453a69e438e0f58ef93103cc0)) ? $this->templates[$v74f5356453a69e438e0f58ef93103cc0] : false;}public function isExists($v74f5356453a69e438e0f58ef93103cc0) {return (bool) @array_key_exists($v74f5356453a69e438e0f58ef93103cc0, $this->templates);}private function loadTemplates() {$vb99eb979e6f6efabc396f777b503f7e7 = cacheFrontend::getInstance();$vf6238d8f90007df1c6f2fe05ac4fb868 = $vb99eb979e6f6efabc396f777b503f7e7->loadData('templates_list');if(!is_array($vf6238d8f90007df1c6f2fe05ac4fb868)) {$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT id, name, filename, type, title, domain_id, lang_id, is_default FROM cms3_templates";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$vf6238d8f90007df1c6f2fe05ac4fb868 = array();while(list($v74f5356453a69e438e0f58ef93103cc0) = $vf1965a857bc285d26fe22023aa5ab50d = mysql_fetch_row($result)) {$vf6238d8f90007df1c6f2fe05ac4fb868[$v74f5356453a69e438e0f58ef93103cc0] = $vf1965a857bc285d26fe22023aa5ab50d;}$vb99eb979e6f6efabc396f777b503f7e7->saveData('templates_list', $vf6238d8f90007df1c6f2fe05ac4fb868, 3600);}else $vf1965a857bc285d26fe22023aa5ab50d = false;foreach($vf6238d8f90007df1c6f2fe05ac4fb868 as $v74f5356453a69e438e0f58ef93103cc0 => $vf1965a857bc285d26fe22023aa5ab50d) {try {$v66f6181bcb4cff4cd38fbc804a036db6 = new template($v74f5356453a69e438e0f58ef93103cc0, $vf1965a857bc285d26fe22023aa5ab50d);}catch (privateException $ve1671797c52e15f763380b45e841ec32) {continue;}$this->templates[$v74f5356453a69e438e0f58ef93103cc0] = $v66f6181bcb4cff4cd38fbc804a036db6;if($v66f6181bcb4cff4cd38fbc804a036db6->getIsDefault()) {$this->def_template = $v66f6181bcb4cff4cd38fbc804a036db6;}}return true;}public function clearCache() {$v14f802e1fba977727845e8872c1743a7 = array_keys($this->templates);foreach($v14f802e1fba977727845e8872c1743a7 as $v3c6e0b8a9c15224a8228b9a98ca1531d) unset($this->templates[$v3c6e0b8a9c15224a8228b9a98ca1531d]);$this->templates = array();$this->loadTemplates();}}?>
