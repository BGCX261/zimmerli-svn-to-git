<?php
 class events extends def_module {public function __construct() {parent::__construct();if(cmsController::getInstance()->getCurrentMode() == "admin") {$this->__loadLib("__admin.php");$this->__implement("__events");$v7513817107edd8b1833da90a2411cb3e = $this->getConfigTabs();if ($v7513817107edd8b1833da90a2411cb3e) {$v7513817107edd8b1833da90a2411cb3e->add("config");}$v38d1e18b54816e157dda5426c36970e3 = $this->getCommonTabs();if($v38d1e18b54816e157dda5426c36970e3) {$v38d1e18b54816e157dda5426c36970e3->add('last');$v38d1e18b54816e157dda5426c36970e3->add('feed');}}$this->__loadLib("__custom.php");$this->__implement("__custom_events");$this->__loadLib("__events_handlers.php");$this->__implement("__eventsHandlersEvents");}public function registerEvent($v803e96ab2d19ace0f4af5786a470117e, $v21ffce5b8a6cc8cc6a41448dd69623c9 = array(), $v7552cd149af7495ee7d8225974e50f80 = null, $v16b2b26000987faccb260b9d39df1269 = null) {$vb10a8c0bede9eb4ea771b04db3149f28 = ConnectionPool::getInstance();$v4717d53ebfdfea8477f780ec66151dcb = $vb10a8c0bede9eb4ea771b04db3149f28->getConnection();umiEventFeed::setConnection($v4717d53ebfdfea8477f780ec66151dcb);umiEventFeedType::setConnection($v4717d53ebfdfea8477f780ec66151dcb);try {$v2f264034c73acbd6baae70dd7edb3d3f = umiEventFeedType::get($v803e96ab2d19ace0f4af5786a470117e);}catch (Exception $ve1671797c52e15f763380b45e841ec32) {$v2f264034c73acbd6baae70dd7edb3d3f = umiEventFeedType::create($v803e96ab2d19ace0f4af5786a470117e);}$v8e44f0089b076e18a718eb9ca3d94674 = permissionsCollection::getInstance()->getUserId();$vee11cbb19052e40b07aac0ca060c23ee = umiObjectsCollection::getInstance()->getObject($v8e44f0089b076e18a718eb9ca3d94674)->getName();$v22884db148f0ffb0d830ba431102b0b5 = cmsController::getInstance()->getModule('users');$v2a304a1348456ccd2234cd71a81bd338 = $v22884db148f0ffb0d830ba431102b0b5->getObjectEditLink($v8e44f0089b076e18a718eb9ca3d94674);array_unshift($v21ffce5b8a6cc8cc6a41448dd69623c9, $vee11cbb19052e40b07aac0ca060c23ee);array_unshift($v21ffce5b8a6cc8cc6a41448dd69623c9, $v2a304a1348456ccd2234cd71a81bd338);umiEventFeed::create($v2f264034c73acbd6baae70dd7edb3d3f, $v21ffce5b8a6cc8cc6a41448dd69623c9, $v7552cd149af7495ee7d8225974e50f80, $v16b2b26000987faccb260b9d39df1269);$v5a0eeddea3917f781ddb458441cc2a3e = (int) regedit::getInstance()->getVal("//modules/events/max-days-storing-events");if ($v5a0eeddea3917f781ddb458441cc2a3e > 0) {$v636843b5194c655771a1f62d6690ced4 = time() - ($v5a0eeddea3917f781ddb458441cc2a3e * 24 * 60 * 60);umiEventFeed::deleteList(array(), $v636843b5194c655771a1f62d6690ced4);}}public function getUserSettings() {$vb10a8c0bede9eb4ea771b04db3149f28 = ConnectionPool::getInstance();$v4717d53ebfdfea8477f780ec66151dcb = $vb10a8c0bede9eb4ea771b04db3149f28->getConnection();umiEventFeedType::setConnection($v4717d53ebfdfea8477f780ec66151dcb);umiEventFeedUser::setConnection($v4717d53ebfdfea8477f780ec66151dcb);$vee11cbb19052e40b07aac0ca060c23ee = $this->getUser();$v2e5d8aa3dfa8ef34ca5131d20f9dad51 = umiEventFeedType::getAllowedList($vee11cbb19052e40b07aac0ca060c23ee->getSettings());$vd14a8022b085f9ef19d479cbdd581127 = umiEventFeedType::getList();$result = array('nodes:type' => array());foreach ($vd14a8022b085f9ef19d479cbdd581127 as $v599dcce2998a6b40b1e38e8c6006cb0a) {$v5f694956811487225d15e973ca38fbab = $v599dcce2998a6b40b1e38e8c6006cb0a->getId();$result['nodes:type'][$v5f694956811487225d15e973ca38fbab]['attribute:id'] = $v5f694956811487225d15e973ca38fbab;$result['nodes:type'][$v5f694956811487225d15e973ca38fbab]['attribute:name'] = getLabel($v5f694956811487225d15e973ca38fbab);$result['nodes:type'][$v5f694956811487225d15e973ca38fbab]['attribute:checked'] = in_array($v5f694956811487225d15e973ca38fbab, $v2e5d8aa3dfa8ef34ca5131d20f9dad51) ? 1 : 0;}return def_module::parseTemplate('', $result);}public static function getUser() {static $vee11cbb19052e40b07aac0ca060c23ee = null;if ($vee11cbb19052e40b07aac0ca060c23ee) return $vee11cbb19052e40b07aac0ca060c23ee;$vb10a8c0bede9eb4ea771b04db3149f28 = ConnectionPool::getInstance();$v4717d53ebfdfea8477f780ec66151dcb = $vb10a8c0bede9eb4ea771b04db3149f28->getConnection();umiEventFeedUser::setConnection($v4717d53ebfdfea8477f780ec66151dcb);umiEventFeedType::setConnection($v4717d53ebfdfea8477f780ec66151dcb);$v8e44f0089b076e18a718eb9ca3d94674 = permissionsCollection::getInstance()->getUserId();try {$vee11cbb19052e40b07aac0ca060c23ee = umiEventFeedUser::get($v8e44f0089b076e18a718eb9ca3d94674);}catch (Exception $ve1671797c52e15f763380b45e841ec32) {$vee11cbb19052e40b07aac0ca060c23ee = umiEventFeedUser::create($v8e44f0089b076e18a718eb9ca3d94674);$v2e5d8aa3dfa8ef34ca5131d20f9dad51 = array();$vee11cbb19052e40b07aac0ca060c23ee->setSettings($v2e5d8aa3dfa8ef34ca5131d20f9dad51);$vee11cbb19052e40b07aac0ca060c23ee->save();}return $vee11cbb19052e40b07aac0ca060c23ee;}};?>