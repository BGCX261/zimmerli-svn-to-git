<?php
 class cacheFrontend extends singleton implements iCacheFrontend, iSingleton {protected $cacheEngine, $cacheEngineName = "", $connected = false, $enabled = false, $is_sleep = false, $mode = "";public static $cacheMode, $currentDomainId = false, $currentlangId = false, $adminMode = false;public static function getInstance($v4a8a08f09d37b73795649038408b5f33 = NULL) {return parent::getInstance(__CLASS__);}public function getIsConnected() {return $this->connected;}public function save(umiEntinty $va8cfde6331bd59eb2ac96f8911c4b666, $v726e8e4809d4c1b28a6549d86436a124 = "unknown", $vcd91e7679d575a2c548bd2c889c23b9e = 86400) {if (!$this->enabled) {return false;}if (!self::$cacheMode) {return false;}if ($this->is_sleep) {return false;}if (!$vcd91e7679d575a2c548bd2c889c23b9e) {return false;}if ($vcd91e7679d575a2c548bd2c889c23b9e == 86400) {$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();if ($v2245023265ae4cf87d02c8b6ba991139->get('cache', 'streams.cache-enabled')) {$va8b17597e9b07c20163f2edf81585218 = (int) $v2245023265ae4cf87d02c8b6ba991139->get('cache', 'streams.cache-lifetime');if ($va8b17597e9b07c20163f2edf81585218 > 0) {$vcd91e7679d575a2c548bd2c889c23b9e = $va8b17597e9b07c20163f2edf81585218;}}}if ($this->cacheEngine instanceof iCacheEngine) {$v3c6e0b8a9c15224a8228b9a98ca1531d = $this->createObjectKey($va8cfde6331bd59eb2ac96f8911c4b666->getId(), $v726e8e4809d4c1b28a6549d86436a124);$this->clusterSync($v3c6e0b8a9c15224a8228b9a98ca1531d);$va8cfde6331bd59eb2ac96f8911c4b666->beforeSerialize();$result = $this->cacheEngine->saveObjectData($v3c6e0b8a9c15224a8228b9a98ca1531d, $va8cfde6331bd59eb2ac96f8911c4b666, $vcd91e7679d575a2c548bd2c889c23b9e);$va8cfde6331bd59eb2ac96f8911c4b666->afterSerialize();return $result;}else {return false;}}public function load($v16b2b26000987faccb260b9d39df1269, $v726e8e4809d4c1b28a6549d86436a124 = "unknown") {if (!$this->enabled) {return false;}if (!self::$cacheMode) {return false;}if ($this->is_sleep) {return false;}if (self::$adminMode) {return false;}if ($this->cacheEngine instanceof iCacheEngine) {$v3c6e0b8a9c15224a8228b9a98ca1531d = $this->createObjectKey($v16b2b26000987faccb260b9d39df1269, $v726e8e4809d4c1b28a6549d86436a124);$va8cfde6331bd59eb2ac96f8911c4b666 = $this->cacheEngine->loadObjectData($v3c6e0b8a9c15224a8228b9a98ca1531d);if ($va8cfde6331bd59eb2ac96f8911c4b666 instanceof umiEntinty) {$va8cfde6331bd59eb2ac96f8911c4b666->afterUnSerialize();}return $va8cfde6331bd59eb2ac96f8911c4b666;}else {return false;}}public function saveSql($vf048dbc650bb3c9b5fc7be35e6887ded, $vca7d9a5274cd551eeb40d8d97d8f9201, $vcd91e7679d575a2c548bd2c889c23b9e = 30) {if (!$this->enabled) {return false;}if (!self::$cacheMode) {return false;}if ($this->is_sleep) {return false;}if (!$vcd91e7679d575a2c548bd2c889c23b9e) {return false;}if ($this->cacheEngine instanceof iCacheEngine) {$v3c6e0b8a9c15224a8228b9a98ca1531d = $this->createObjectKey($this->convertSqlToHash($vf048dbc650bb3c9b5fc7be35e6887ded), "sql");$this->clusterSync($v3c6e0b8a9c15224a8228b9a98ca1531d);return $this->cacheEngine->saveRawData($v3c6e0b8a9c15224a8228b9a98ca1531d, $vca7d9a5274cd551eeb40d8d97d8f9201, $vcd91e7679d575a2c548bd2c889c23b9e);}else {return false;}}public function loadSql($vf048dbc650bb3c9b5fc7be35e6887ded) {if (!$this->enabled) {return false;}if (!self::$cacheMode) {return false;}if ($this->is_sleep) {return false;}if (self::$adminMode) {return false;}if ($this->cacheEngine instanceof iCacheEngine) {$v3c6e0b8a9c15224a8228b9a98ca1531d = $this->createObjectKey($this->convertSqlToHash($vf048dbc650bb3c9b5fc7be35e6887ded), "sql");return $this->cacheEngine->loadRawData($v3c6e0b8a9c15224a8228b9a98ca1531d);}else {return false;}}public function saveData($v3c6e0b8a9c15224a8228b9a98ca1531d, $v8d777f385d3dfec8815d20f7496026dc, $vcd91e7679d575a2c548bd2c889c23b9e = 5) {if (!$this->enabled) {return false;}if (!self::$cacheMode) {return false;}if ($this->is_sleep) {return false;}if (!$vcd91e7679d575a2c548bd2c889c23b9e) {return false;}if ($this->cacheEngine instanceof iCacheEngine) {$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();$va4f86f7bfc24194b276c22e0ef158197 = $v2245023265ae4cf87d02c8b6ba991139->get('cache', 'not-allowed-methods');if ($va4f86f7bfc24194b276c22e0ef158197) {foreach ($va4f86f7bfc24194b276c22e0ef158197 as $v981c1e7b3795da18687613fbd66d4954) {if ($v981c1e7b3795da18687613fbd66d4954 && strpos($v3c6e0b8a9c15224a8228b9a98ca1531d, $v981c1e7b3795da18687613fbd66d4954) !== false) {return false;}}}$va4f86f7bfc24194b276c22e0ef158197 = $v2245023265ae4cf87d02c8b6ba991139->get('cache', 'not-allowed-streams');if ($va4f86f7bfc24194b276c22e0ef158197) {foreach ($va4f86f7bfc24194b276c22e0ef158197 as $v981c1e7b3795da18687613fbd66d4954) {if ($v981c1e7b3795da18687613fbd66d4954 && strpos($v3c6e0b8a9c15224a8228b9a98ca1531d, $v981c1e7b3795da18687613fbd66d4954) !== false) {return false;}}}$v3c6e0b8a9c15224a8228b9a98ca1531d = $this->createKey($v3c6e0b8a9c15224a8228b9a98ca1531d);$this->clusterSync($v3c6e0b8a9c15224a8228b9a98ca1531d);return $this->cacheEngine->saveRawData($v3c6e0b8a9c15224a8228b9a98ca1531d, $v8d777f385d3dfec8815d20f7496026dc, $vcd91e7679d575a2c548bd2c889c23b9e);}else {return false;}}public function saveObject($v3c6e0b8a9c15224a8228b9a98ca1531d, $v8d777f385d3dfec8815d20f7496026dc, $vcd91e7679d575a2c548bd2c889c23b9e = 5) {if (!$this->enabled) {return false;}if (!self::$cacheMode) {return false;}if ($this->is_sleep) {return false;}if (!$vcd91e7679d575a2c548bd2c889c23b9e) {return false;}if ($this->cacheEngine instanceof iCacheEngine) {$v3c6e0b8a9c15224a8228b9a98ca1531d = $this->createKey($v3c6e0b8a9c15224a8228b9a98ca1531d);$this->clusterSync($v3c6e0b8a9c15224a8228b9a98ca1531d);return $this->cacheEngine->saveRawData($v3c6e0b8a9c15224a8228b9a98ca1531d, $v8d777f385d3dfec8815d20f7496026dc, $vcd91e7679d575a2c548bd2c889c23b9e);}else {return false;}}public function saveElement($v3c6e0b8a9c15224a8228b9a98ca1531d, $v8d777f385d3dfec8815d20f7496026dc, $vcd91e7679d575a2c548bd2c889c23b9e = 10) {if(!$this->enabled) return false;if(!self::$cacheMode) return false;if($this->is_sleep) return false;if(!$vcd91e7679d575a2c548bd2c889c23b9e) return false;if($this->cacheEngine instanceof iCacheEngine) {$v3c6e0b8a9c15224a8228b9a98ca1531d = $this->createKey($v3c6e0b8a9c15224a8228b9a98ca1531d);$this->clusterSync($v3c6e0b8a9c15224a8228b9a98ca1531d);return $this->cacheEngine->saveObjectData($v3c6e0b8a9c15224a8228b9a98ca1531d, $v8d777f385d3dfec8815d20f7496026dc, $vcd91e7679d575a2c548bd2c889c23b9e);}else {return false;}}public function loadData($v3c6e0b8a9c15224a8228b9a98ca1531d) {if(!$this->enabled) return false;if(!self::$cacheMode) return false;if($this->is_sleep) return false;if(self::$adminMode) return false;if($this->cacheEngine instanceof iCacheEngine) {$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();$va4f86f7bfc24194b276c22e0ef158197 = $v2245023265ae4cf87d02c8b6ba991139->get('cache', 'not-allowed-methods');if($va4f86f7bfc24194b276c22e0ef158197) {foreach($va4f86f7bfc24194b276c22e0ef158197 as $v981c1e7b3795da18687613fbd66d4954) {if ($v981c1e7b3795da18687613fbd66d4954 && strpos($v3c6e0b8a9c15224a8228b9a98ca1531d, $v981c1e7b3795da18687613fbd66d4954) !== false) return false;}}$va4f86f7bfc24194b276c22e0ef158197 = $v2245023265ae4cf87d02c8b6ba991139->get('cache', 'not-allowed-streams');if($va4f86f7bfc24194b276c22e0ef158197) {foreach($va4f86f7bfc24194b276c22e0ef158197 as $v981c1e7b3795da18687613fbd66d4954) {if ($v981c1e7b3795da18687613fbd66d4954 && strpos($v3c6e0b8a9c15224a8228b9a98ca1531d, $v981c1e7b3795da18687613fbd66d4954) !== false) return false;}}$v3c6e0b8a9c15224a8228b9a98ca1531d = $this->createKey($v3c6e0b8a9c15224a8228b9a98ca1531d);return $this->cacheEngine->loadRawData($v3c6e0b8a9c15224a8228b9a98ca1531d);}else {return false;}}public function makeSleep($vc9fab33e9458412c527c3fe8a13ee37d = false) {$this->is_sleep = $vc9fab33e9458412c527c3fe8a13ee37d;}public function del($vb80bb7740288fda1f201890375a60c8f, $v599dcce2998a6b40b1e38e8c6006cb0a = false) {if(!$this->enabled) return false;if(!self::$cacheMode) return false;if($this->is_sleep) return false;if($this->cacheEngine instanceof iCacheEngine) {$v3c6e0b8a9c15224a8228b9a98ca1531d = $this->createObjectKey($vb80bb7740288fda1f201890375a60c8f, $v599dcce2998a6b40b1e38e8c6006cb0a);$this->clusterSync($v3c6e0b8a9c15224a8228b9a98ca1531d);return $this->cacheEngine->delete($v3c6e0b8a9c15224a8228b9a98ca1531d);}else {return false;}}public function deleteKey($v3c6e0b8a9c15224a8228b9a98ca1531d, $v29befba2e437d0e266c0ee3240492277 = false) {if($this->cacheEngine instanceof iCacheEngine) {if($v29befba2e437d0e266c0ee3240492277) {$v3c6e0b8a9c15224a8228b9a98ca1531d .= $this->getKeySuffix();}return $this->cacheEngine->delete($v3c6e0b8a9c15224a8228b9a98ca1531d);}else {return false;}}public function flush() {if($this->cacheEngine instanceof iCacheEngine) {$this->cacheEngine->flush();}}public static function getPriorityEnginesList($v759a21c505c72b62a1823b053e65d391 = false) {$v10ae9fc7d453b0dd525d0edf2ede7961 = Array('apc', 'eaccelerator', 'xcache', 'memcache', 'fs');if($v759a21c505c72b62a1823b053e65d391) {foreach($v10ae9fc7d453b0dd525d0edf2ede7961 as $v865c0c0b4ab0e063e5caa3387c1a8741 => $v6257d4194dfc0a2e1468b01b77ca82b0) {if(self::checkEngine($v6257d4194dfc0a2e1468b01b77ca82b0) == false) {unset($v10ae9fc7d453b0dd525d0edf2ede7961[$v865c0c0b4ab0e063e5caa3387c1a8741]);}}}return $v10ae9fc7d453b0dd525d0edf2ede7961;}public static function chooseCacheEngine($va07f9b4b87b6b9701683ccfc93d20d60) {if (!is_array($va07f9b4b87b6b9701683ccfc93d20d60)) {return false;}$result = array_intersect(self::getPriorityEnginesList(), $va07f9b4b87b6b9701683ccfc93d20d60);if (sizeof($result)) {reset($result);return current($result);}else {return false;}}public function getCurrentCacheEngineName() {return $this->cacheEngineName;}public function switchCacheEngine($v7e96ab06eef9d73d30eafc3b5ae196a6) {if (!$v7e96ab06eef9d73d30eafc3b5ae196a6) {return $this->saveCacheEngineName("");}if ($this->checkEngine($v7e96ab06eef9d73d30eafc3b5ae196a6)) {$this->flush();return $this->saveCacheEngineName($v7e96ab06eef9d73d30eafc3b5ae196a6);}else {return true;}}protected function __construct() {$this->detectCacheEngine();$v2ae9e7e5c687d5c49e0e9a4740cc9ae5 = $this->loadEngine($this->cacheEngineName);if ($v2ae9e7e5c687d5c49e0e9a4740cc9ae5 instanceof iCacheEngine) {$this->connected = (bool) $v2ae9e7e5c687d5c49e0e9a4740cc9ae5->getIsConnected();if ($this->connected) {$this->enabled = true;self::$cacheMode = true;$this->cacheEngine = $v2ae9e7e5c687d5c49e0e9a4740cc9ae5;}}}protected function convertSqlToHash($vac5c74b64b4b8352ef2f181affb5ac2a) {return sha1($vac5c74b64b4b8352ef2f181affb5ac2a);}protected function createObjectKey($vb80bb7740288fda1f201890375a60c8f, $v599dcce2998a6b40b1e38e8c6006cb0a) {return $vb80bb7740288fda1f201890375a60c8f . "_" . $v599dcce2998a6b40b1e38e8c6006cb0a . $this->getKeySuffix();}protected function createKey($vb80bb7740288fda1f201890375a60c8f) {return $vb80bb7740288fda1f201890375a60c8f . $this->getKeySuffix();}protected function getKeySuffix() {static $v4ec1b477cd0232b832c1899905ec51a4 = false, $v3a90131ee153b18050a4ec5fc9b89dc8 = false, $v11e868acb4d0d3552993647c02ffc75f = false;if($v3a90131ee153b18050a4ec5fc9b89dc8 == false) {$v8ce4b16b22b58894aa86c421e8759df3 = CURRENT_WORKING_DIR;if(defined("DEMO_DB_NAME")) {$v8ce4b16b22b58894aa86c421e8759df3 = DEMO_DB_NAME;}$v3a90131ee153b18050a4ec5fc9b89dc8 = sha1($v8ce4b16b22b58894aa86c421e8759df3 . SYS_CACHE_SALT);}if($v4ec1b477cd0232b832c1899905ec51a4 && !$v11e868acb4d0d3552993647c02ffc75f) {if(self::$currentlangId && self::$currentDomainId) {$v11e868acb4d0d3552993647c02ffc75f = self::$currentlangId  . '_' . self::$currentDomainId;}$v4ec1b477cd0232b832c1899905ec51a4 =  $v4ec1b477cd0232b832c1899905ec51a4 . '_' . $v11e868acb4d0d3552993647c02ffc75f;}if($v4ec1b477cd0232b832c1899905ec51a4 == false) {$v4ec1b477cd0232b832c1899905ec51a4 = $this->mode . "_" . $v3a90131ee153b18050a4ec5fc9b89dc8;if(!$v11e868acb4d0d3552993647c02ffc75f && self::$currentlangId && self::$currentDomainId) {$v11e868acb4d0d3552993647c02ffc75f = self::$currentlangId  . '_' . self::$currentDomainId;$v4ec1b477cd0232b832c1899905ec51a4 =  $v4ec1b477cd0232b832c1899905ec51a4 . '_' . $v11e868acb4d0d3552993647c02ffc75f;}}return $v4ec1b477cd0232b832c1899905ec51a4;}protected function loadEngine($v6257d4194dfc0a2e1468b01b77ca82b0) {if(!$v6257d4194dfc0a2e1468b01b77ca82b0) {return NULL;}$v6a2a431fe8b621037ea949531c28551d = SYS_KERNEL_PATH . "subsystems/cache/engines/" . $v6257d4194dfc0a2e1468b01b77ca82b0 . ".php";if(file_exists($v6a2a431fe8b621037ea949531c28551d)) {$v26b2a720f7b8c9bd8d3999c52da409d0 = $v6257d4194dfc0a2e1468b01b77ca82b0 . "CacheEngine";if(!class_exists($v26b2a720f7b8c9bd8d3999c52da409d0)) {include $v6a2a431fe8b621037ea949531c28551d;}if(class_exists($v26b2a720f7b8c9bd8d3999c52da409d0)) {return new $v26b2a720f7b8c9bd8d3999c52da409d0;}else {throw new coreException("Failed to load cache engine: class \"{$v26b2a720f7b8c9bd8d3999c52da409d0}\" not found in \"{$v6a2a431fe8b621037ea949531c28551d}\"");}}else {return NULL;}}protected function detectCacheEngine() {if($v7e96ab06eef9d73d30eafc3b5ae196a6 = $this->loadCacheEngineName()) {if($this->checkEngine($v7e96ab06eef9d73d30eafc3b5ae196a6)) {$this->cacheEngineName = $v7e96ab06eef9d73d30eafc3b5ae196a6;return true;}}if($v7e96ab06eef9d73d30eafc3b5ae196a6 == "none") return false;if($v7e96ab06eef9d73d30eafc3b5ae196a6 == "auto") {$v7e96ab06eef9d73d30eafc3b5ae196a6 = $this->autoDetectCacheEngine();}if($v7e96ab06eef9d73d30eafc3b5ae196a6) {$this->cacheEngineName = $v7e96ab06eef9d73d30eafc3b5ae196a6;$this->saveCacheEngineName($v7e96ab06eef9d73d30eafc3b5ae196a6);return true;}else {return false;}}protected function autoDetectCacheEngine() {$v10ae9fc7d453b0dd525d0edf2ede7961 = $this->getPriorityEnginesList();foreach($v10ae9fc7d453b0dd525d0edf2ede7961 as $v7e96ab06eef9d73d30eafc3b5ae196a6) {if($v7e96ab06eef9d73d30eafc3b5ae196a6 == 'fs') continue;if($this->checkEngine($v7e96ab06eef9d73d30eafc3b5ae196a6)) {return $v7e96ab06eef9d73d30eafc3b5ae196a6;}}return false;}protected function checkEngine($v6257d4194dfc0a2e1468b01b77ca82b0) {switch($v6257d4194dfc0a2e1468b01b77ca82b0) {case "apc": {return function_exists("apc_store");}case "eaccelerator": {return function_exists("eaccelerator_put");}case "xcache": {return function_exists("xcache_set");}case "memcache": {return class_exists("Memcache");}case "shm": {return function_exists("shm_attach");}case "fs": {return true;}default: {return false;}}}protected function saveCacheEngineName($v7e96ab06eef9d73d30eafc3b5ae196a6) {$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();return $v2245023265ae4cf87d02c8b6ba991139->set('cache', 'engine', $v7e96ab06eef9d73d30eafc3b5ae196a6);}protected function loadCacheEngineName() {$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();return $v2245023265ae4cf87d02c8b6ba991139->get('cache', 'engine');}protected function clusterSync($v3c6e0b8a9c15224a8228b9a98ca1531d) {static $v183224d27b72b647391e179fa311b891;if(CLUSTER_CACHE_CORRECTION) {if(!$v183224d27b72b647391e179fa311b891) $v183224d27b72b647391e179fa311b891 = clusterCacheSync::getInstance();$v4ec1b477cd0232b832c1899905ec51a4 = $this->getKeySuffix();$v183224d27b72b647391e179fa311b891->notify(substr($v3c6e0b8a9c15224a8228b9a98ca1531d, 0, strlen($v3c6e0b8a9c15224a8228b9a98ca1531d) - strlen($v4ec1b477cd0232b832c1899905ec51a4)));}}};?>