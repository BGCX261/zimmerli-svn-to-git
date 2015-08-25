<?php
 class matches implements iMatches {protected $sitemapFilePath, $uri, $dom, $matchNode;protected $buffer, $pattern, $params, $cache = false;protected $externalCall = true;public function __construct($vd369d72ce933bd68573823f8f34d010c = "sitemap.xml") {static $v90699891f4a29a432f7bd2cab9f54864;if (is_null($v90699891f4a29a432f7bd2cab9f54864)) {$v90699891f4a29a432f7bd2cab9f54864 = CURRENT_WORKING_DIR . "/umaps/" . $vd369d72ce933bd68573823f8f34d010c;if ($v6829cdfdefd69b947abedd8fa2c4bcc7 = cmsController::getInstance()->getResourcesDirectory()) {$v90699891f4a29a432f7bd2cab9f54864 = $v6829cdfdefd69b947abedd8fa2c4bcc7 . "/umaps/" . $vd369d72ce933bd68573823f8f34d010c;if (!is_file($v90699891f4a29a432f7bd2cab9f54864)) {$v90699891f4a29a432f7bd2cab9f54864 = CURRENT_WORKING_DIR . "/umaps/" . $vd369d72ce933bd68573823f8f34d010c;}}}if(file_exists($v90699891f4a29a432f7bd2cab9f54864)) {$this->sitemapFilePath = $v90699891f4a29a432f7bd2cab9f54864;}else {throw new publicException("Can't find sitemap file in \"./umaps/{$vd369d72ce933bd68573823f8f34d010c}\"");}}public function setCurrentURI($v9305b73d359bd06734fee0b3638079e1) {$this->uri = (string) $v9305b73d359bd06734fee0b3638079e1;}public function execute($v54592a38361fdcdc8dd250ac42a88c33 = true) {$this->externalCall = $v54592a38361fdcdc8dd250ac42a88c33;$this->loadXmlDOM();$vbb60f04b9e80a969b75911fa6dfc9b99 = $this->dom->firstChild;$v0fea6a13c52b4d4725368f24b045ca84 = ($vbb60f04b9e80a969b75911fa6dfc9b99->nodeName === "sitemap") ? (int) $vbb60f04b9e80a969b75911fa6dfc9b99->getAttribute("cache") : 0;$this->setCacheTimeout($v0fea6a13c52b4d4725368f24b045ca84);if ($v8d6652e544ac78162c4dfe3994130b01 = $this->searchPattern()) {return $this->beginProcessing($v8d6652e544ac78162c4dfe3994130b01);}else {return false;}}private function setCacheTimeout($v0fea6a13c52b4d4725368f24b045ca84) {if((int) $v0fea6a13c52b4d4725368f24b045ca84 > 0) {$this->cache = (int) $v0fea6a13c52b4d4725368f24b045ca84;}else {$this->cache = false;}}private function loadXmlDOM() {$this->dom = DOMDocument::load($this->sitemapFilePath);}private function searchPattern() {$v3d788fa62d7c185a1bee4c9147ee1091 = new DOMXPath($this->dom);$vc0f78cbf7f92f2045d9f5566fabf94c0 = $v3d788fa62d7c185a1bee4c9147ee1091->query("/sitemap/match");foreach($vc0f78cbf7f92f2045d9f5566fabf94c0 as $v8d6652e544ac78162c4dfe3994130b01) {$v240bf022e685b0ee30ad9fe9e1fb5d5b = $v8d6652e544ac78162c4dfe3994130b01->getAttribute("pattern");if($this->comparePattern($v240bf022e685b0ee30ad9fe9e1fb5d5b)) {return $v8d6652e544ac78162c4dfe3994130b01;}}return false;}private function comparePattern($v240bf022e685b0ee30ad9fe9e1fb5d5b) {if(preg_match("|" . $v240bf022e685b0ee30ad9fe9e1fb5d5b . "|", $this->uri, $v21ffce5b8a6cc8cc6a41448dd69623c9)) {$this->pattern = $v240bf022e685b0ee30ad9fe9e1fb5d5b;$this->params = $v21ffce5b8a6cc8cc6a41448dd69623c9;return true;}else {return false;}}private function beginProcessing(DOMElement $v8d6652e544ac78162c4dfe3994130b01) {def_module::isXSLTResultMode(true);$this->processRedirection();$v21ffce5b8a6cc8cc6a41448dd69623c9 = $this->extractParams($v8d6652e544ac78162c4dfe3994130b01);if(isset($v21ffce5b8a6cc8cc6a41448dd69623c9['cache'])) {$this->cache = $v21ffce5b8a6cc8cc6a41448dd69623c9['cache'];}$this->processGeneration();$this->processTransformation();$this->processValidation();if($this->externalCall) {$this->processSerialization();return true;}else {return $this->buffer;}}private function replaceParams($v341be97d9aff90c9978347f66f945b77) {$v21ffce5b8a6cc8cc6a41448dd69623c9 = $this->params;$v7dabf5c198b0bab2eaa42bb03a113e55 = sizeof($v21ffce5b8a6cc8cc6a41448dd69623c9);for($v865c0c0b4ab0e063e5caa3387c1a8741 = 0;$v865c0c0b4ab0e063e5caa3387c1a8741 < $v7dabf5c198b0bab2eaa42bb03a113e55;$v865c0c0b4ab0e063e5caa3387c1a8741++) {$v341be97d9aff90c9978347f66f945b77 = str_replace('{' . $v865c0c0b4ab0e063e5caa3387c1a8741 . '}', $v21ffce5b8a6cc8cc6a41448dd69623c9[$v865c0c0b4ab0e063e5caa3387c1a8741], $v341be97d9aff90c9978347f66f945b77);}foreach($_GET as $v865c0c0b4ab0e063e5caa3387c1a8741 => $v9e3669d19b675bd57058fd4664205d2a) {$v341be97d9aff90c9978347f66f945b77 = str_replace('{' . $v865c0c0b4ab0e063e5caa3387c1a8741 . '}', urlencode($v9e3669d19b675bd57058fd4664205d2a), $v341be97d9aff90c9978347f66f945b77);}foreach($_SERVER as $v865c0c0b4ab0e063e5caa3387c1a8741 => $v9e3669d19b675bd57058fd4664205d2a) {if(is_array($v9e3669d19b675bd57058fd4664205d2a)) continue;$v341be97d9aff90c9978347f66f945b77 = str_replace('{_' . strtolower($v865c0c0b4ab0e063e5caa3387c1a8741) . '}', $v9e3669d19b675bd57058fd4664205d2a, $v341be97d9aff90c9978347f66f945b77);}return $v341be97d9aff90c9978347f66f945b77;}private function processGeneration() {$v3d788fa62d7c185a1bee4c9147ee1091 = new DOMXPath($this->dom);$vca15fd43dfaeb80eb8c125735e0479b0 = $v3d788fa62d7c185a1bee4c9147ee1091->query("/sitemap/match[@pattern = '{$this->pattern}']/generate");$v865c0c0b4ab0e063e5caa3387c1a8741 = 0;foreach($vca15fd43dfaeb80eb8c125735e0479b0 as $v36c4536996ca5615dcf9911f068786dc) {if($v865c0c0b4ab0e063e5caa3387c1a8741++) throw new coreException("Only 1 generate tag allowed in match section.");$v25d902c24283ab8cfbac54dfa101ad31 = $this->replaceParams($v36c4536996ca5615dcf9911f068786dc->getAttribute("src"));$v2817f701d5e1a1181e657251363295fd = false;if($this->cache !== false) {$v8d777f385d3dfec8815d20f7496026dc = cacheFrontend::getInstance()->loadSql($v25d902c24283ab8cfbac54dfa101ad31);}else {$v8d777f385d3dfec8815d20f7496026dc = false;}if(!$v8d777f385d3dfec8815d20f7496026dc) {$v8d777f385d3dfec8815d20f7496026dc = file_get_contents($v25d902c24283ab8cfbac54dfa101ad31);if($this->cache !== false) {cacheFrontend::getInstance()->saveObject($v25d902c24283ab8cfbac54dfa101ad31, $v8d777f385d3dfec8815d20f7496026dc, $this->cache);}}$this->buffer = $v8d777f385d3dfec8815d20f7496026dc;}return (bool) $v865c0c0b4ab0e063e5caa3387c1a8741;}private function processTransformation() {$v3d788fa62d7c185a1bee4c9147ee1091 = new DOMXpath($this->dom);$vca15fd43dfaeb80eb8c125735e0479b0 = $v3d788fa62d7c185a1bee4c9147ee1091->query("/sitemap/match[@pattern = '{$this->pattern}']/transform");foreach($vca15fd43dfaeb80eb8c125735e0479b0 as $v36c4536996ca5615dcf9911f068786dc) {$v25d902c24283ab8cfbac54dfa101ad31 = $this->replaceParams($v36c4536996ca5615dcf9911f068786dc->getAttribute("src"));if(file_exists($v25d902c24283ab8cfbac54dfa101ad31)) {$vc3aaa7dd2c4cf0305f95e82438b46e82 = new DOMDocument('1.0', 'utf-8');$vc3aaa7dd2c4cf0305f95e82438b46e82->load($v25d902c24283ab8cfbac54dfa101ad31);$v801f7201346b43f8ee8390a1ef20ddcd = new xsltProcessor;$v801f7201346b43f8ee8390a1ef20ddcd->registerPHPFunctions();$v801f7201346b43f8ee8390a1ef20ddcd->importStyleSheet($vc3aaa7dd2c4cf0305f95e82438b46e82);$v21ffce5b8a6cc8cc6a41448dd69623c9 = $this->extractParams($v36c4536996ca5615dcf9911f068786dc);foreach($v21ffce5b8a6cc8cc6a41448dd69623c9 as $vb068931cc450442b63f5b3d276ea4297 => $v2063c1608d6e0baf80249c42e2be5804) {$v2063c1608d6e0baf80249c42e2be5804 = $this->replaceParams($v2063c1608d6e0baf80249c42e2be5804);$v801f7201346b43f8ee8390a1ef20ddcd->setParameter("", $vb068931cc450442b63f5b3d276ea4297, $v2063c1608d6e0baf80249c42e2be5804);}$this->buffer = $v801f7201346b43f8ee8390a1ef20ddcd->transformToXML($this->loadBufferDom());}else {throw new coreException("Transformation failed. File {$v25d902c24283ab8cfbac54dfa101ad31} doesn't exists.");}}}private function processSerialization() {$v3d788fa62d7c185a1bee4c9147ee1091 = new DOMXpath($this->dom);$vca15fd43dfaeb80eb8c125735e0479b0 = $v3d788fa62d7c185a1bee4c9147ee1091->query("/sitemap/match[@pattern = '{$this->pattern}']/serialize");if($vca15fd43dfaeb80eb8c125735e0479b0->length == 0) {throw new coreException("Serializer tag required, but not found in umap rule.");}$v865c0c0b4ab0e063e5caa3387c1a8741 = 0;foreach($vca15fd43dfaeb80eb8c125735e0479b0 as $v36c4536996ca5615dcf9911f068786dc) {if($v865c0c0b4ab0e063e5caa3387c1a8741++) throw new coreException("Only 1 serialize tag allowed in match section.");$v599dcce2998a6b40b1e38e8c6006cb0a = $v36c4536996ca5615dcf9911f068786dc->getAttribute("type");if(!$v599dcce2998a6b40b1e38e8c6006cb0a) $v599dcce2998a6b40b1e38e8c6006cb0a = "xml";$v21ffce5b8a6cc8cc6a41448dd69623c9 = $this->extractParams($v36c4536996ca5615dcf9911f068786dc);baseSerialize::serializeDocument($v599dcce2998a6b40b1e38e8c6006cb0a, $this->buffer, $v21ffce5b8a6cc8cc6a41448dd69623c9);exit();}}private function processRedirection() {$v3d788fa62d7c185a1bee4c9147ee1091 = new DOMXpath($this->dom);$vca15fd43dfaeb80eb8c125735e0479b0 = $v3d788fa62d7c185a1bee4c9147ee1091->query("/sitemap/match[@pattern = '{$this->pattern}']/redirect");$v865c0c0b4ab0e063e5caa3387c1a8741 = 0;foreach($vca15fd43dfaeb80eb8c125735e0479b0 as $v36c4536996ca5615dcf9911f068786dc) {if($v865c0c0b4ab0e063e5caa3387c1a8741++) throw new coreException("Only 1 redirect tag allowed in match section.");$v9305b73d359bd06734fee0b3638079e1 = $v36c4536996ca5615dcf9911f068786dc->getAttribute("uri");$v21ffce5b8a6cc8cc6a41448dd69623c9 = $this->extractParams($v36c4536996ca5615dcf9911f068786dc);}if($v865c0c0b4ab0e063e5caa3387c1a8741 == 0) return false;header("Location: {$v9305b73d359bd06734fee0b3638079e1}");if(isset($v21ffce5b8a6cc8cc6a41448dd69623c9['status'])) {$v9acb44549b41563697bb490144ec6258 = $v21ffce5b8a6cc8cc6a41448dd69623c9['status'];header("Status: {$v9acb44549b41563697bb490144ec6258}");}exit();}private function processValidation() {$v3d788fa62d7c185a1bee4c9147ee1091 = new DOMXpath($this->dom);$vca15fd43dfaeb80eb8c125735e0479b0 = $v3d788fa62d7c185a1bee4c9147ee1091->query("/sitemap/match[@pattern = '{$this->pattern}']/validate");$v865c0c0b4ab0e063e5caa3387c1a8741 = 0;foreach($vca15fd43dfaeb80eb8c125735e0479b0 as $v36c4536996ca5615dcf9911f068786dc) {if($v865c0c0b4ab0e063e5caa3387c1a8741++) throw new coreException("Only 1 validate tag allowed in match section.");$v25d902c24283ab8cfbac54dfa101ad31 = $v36c4536996ca5615dcf9911f068786dc->getAttribute("src");$v599dcce2998a6b40b1e38e8c6006cb0a = $v36c4536996ca5615dcf9911f068786dc->getAttribute("type");}if($v865c0c0b4ab0e063e5caa3387c1a8741 == 0) return false;switch($v599dcce2998a6b40b1e38e8c6006cb0a) {case "xsd": {if($this->validateXmlByXsd($v25d902c24283ab8cfbac54dfa101ad31)) {return true;}else {throw new coreException("Document is not valid according to xsd scheme \"{$v25d902c24283ab8cfbac54dfa101ad31}\"");}break;}case "dtd": {if($this->validateXmlByDtd($v25d902c24283ab8cfbac54dfa101ad31)) {return true;}else {throw new coreException("Document is not valid according to dtd scheme \"{$v25d902c24283ab8cfbac54dfa101ad31}\"");}break;}default: {throw new coreException("Unknown validation method \"{$v599dcce2998a6b40b1e38e8c6006cb0a}\"");break;}}}private function extractParams(DOMElement $v36c4536996ca5615dcf9911f068786dc) {$v21ffce5b8a6cc8cc6a41448dd69623c9 = Array();$v3d788fa62d7c185a1bee4c9147ee1091 = new DOMXpath($this->dom);$ve43f0203c36cc70bf17296f7a7ad0a7d = $v3d788fa62d7c185a1bee4c9147ee1091->query("param", $v36c4536996ca5615dcf9911f068786dc);foreach($ve43f0203c36cc70bf17296f7a7ad0a7d as $vfe35958165bbc2da0b84301b7ac74205) {$v865c0c0b4ab0e063e5caa3387c1a8741 = (string) $vfe35958165bbc2da0b84301b7ac74205->getAttribute("name");$v9e3669d19b675bd57058fd4664205d2a = (string) $vfe35958165bbc2da0b84301b7ac74205->getAttribute("value");$v21ffce5b8a6cc8cc6a41448dd69623c9[$v865c0c0b4ab0e063e5caa3387c1a8741] = $v9e3669d19b675bd57058fd4664205d2a;$_subnodes = $v3d788fa62d7c185a1bee4c9147ee1091->query("param", $vfe35958165bbc2da0b84301b7ac74205);if($_subnodes->length > 0) {$v21ffce5b8a6cc8cc6a41448dd69623c9[$v865c0c0b4ab0e063e5caa3387c1a8741] = $this->extractParams($vfe35958165bbc2da0b84301b7ac74205);}}return $v21ffce5b8a6cc8cc6a41448dd69623c9;}private function validateXmlByXsd($v25d902c24283ab8cfbac54dfa101ad31) {if(file_exists($v25d902c24283ab8cfbac54dfa101ad31)) {$vdd988cfd769c9f7fbd795a0f5da8e751 = $this->loadBufferDom();return $vdd988cfd769c9f7fbd795a0f5da8e751->schemaValidate($v25d902c24283ab8cfbac54dfa101ad31);}else {throw new coreException("Failed to validate, because xsd scheme not found \"{$v25d902c24283ab8cfbac54dfa101ad31}\"");return false;}}private function validateXmlByDtd($v25d902c24283ab8cfbac54dfa101ad31) {if(file_exists($v25d902c24283ab8cfbac54dfa101ad31)) {$vdd988cfd769c9f7fbd795a0f5da8e751 = $this->loadBufferDom();return $vdd988cfd769c9f7fbd795a0f5da8e751->validate($v25d902c24283ab8cfbac54dfa101ad31);}else {throw new coreException("Failed to validate, because dtd scheme not found \"{$v25d902c24283ab8cfbac54dfa101ad31}\"");return false;}}private function loadBufferDom() {return DOMDocument::loadXML($this->buffer);}};?>