<?php
 class umiObjectWrapper extends translatorWrapper {public function translate($v8d777f385d3dfec8815d20f7496026dc) {return $this->translateData($v8d777f385d3dfec8815d20f7496026dc);}protected function translateData(iUmiObject $va8cfde6331bd59eb2ac96f8911c4b666) {$v16b2b26000987faccb260b9d39df1269 = $va8cfde6331bd59eb2ac96f8911c4b666->getId();$v26b75b176d665f24a5fd22a2ad815763 = Array();$v26b75b176d665f24a5fd22a2ad815763['attribute:id'] = $v16b2b26000987faccb260b9d39df1269;$v26b75b176d665f24a5fd22a2ad815763['attribute:guid'] = $va8cfde6331bd59eb2ac96f8911c4b666->getGUID();$v26b75b176d665f24a5fd22a2ad815763['attribute:name'] = $va8cfde6331bd59eb2ac96f8911c4b666->getName();$v26b75b176d665f24a5fd22a2ad815763['attribute:type-id'] = $va8cfde6331bd59eb2ac96f8911c4b666->getTypeId();$v26b75b176d665f24a5fd22a2ad815763['attribute:type-guid'] = $va8cfde6331bd59eb2ac96f8911c4b666->getTypeGUID();$vb0ab4f7791b60b1e8ea01057b77873b0 = $va8cfde6331bd59eb2ac96f8911c4b666->getOwnerId();if($vb0ab4f7791b60b1e8ea01057b77873b0) {$v26b75b176d665f24a5fd22a2ad815763['attribute:ownerId'] = $vb0ab4f7791b60b1e8ea01057b77873b0;}if($this->isFull === false) {$v26b75b176d665f24a5fd22a2ad815763['xlink:href'] = "uobject://" . $v16b2b26000987faccb260b9d39df1269;return $v26b75b176d665f24a5fd22a2ad815763;}$v6301cee35ea764a1e241978f93f01069 = $va8cfde6331bd59eb2ac96f8911c4b666->getTypeId();$v726e8e4809d4c1b28a6549d86436a124 = umiObjectTypesCollection::getInstance()->getType($v6301cee35ea764a1e241978f93f01069);$v143fdbfa2afa490e521056bd5040d5fd = $v726e8e4809d4c1b28a6549d86436a124->getFieldsGroupsList();if(!is_null(getRequest('links'))) {$v8b1dc169bf460ee884fceef66c6607d6 = cmsController::getInstance();$vef8eea3357eeef6f5ddb3d707ff0e8e8 = umiHierarchyTypesCollection::getInstance();$v9b81909fd0da3add2602a8d0ede0e4e7    = umiObjectTypesCollection::getInstance();$v641ee90996ed9781bf72b559b9c90742 = $v726e8e4809d4c1b28a6549d86436a124;$v865c0c0b4ab0e063e5caa3387c1a8741 = 0;do {$vacf567c9c3d6cf7c6e2cc0ce108e0631 = $v641ee90996ed9781bf72b559b9c90742->getHierarchyTypeId();$v89b0b9deff65f8b9cd1f71bc74ce36ba   = $vef8eea3357eeef6f5ddb3d707ff0e8e8->getType($vacf567c9c3d6cf7c6e2cc0ce108e0631);if($v641ee90996ed9781bf72b559b9c90742->getParentId()) {$v641ee90996ed9781bf72b559b9c90742 = $v9b81909fd0da3add2602a8d0ede0e4e7->getType($v641ee90996ed9781bf72b559b9c90742->getParentId());break;}if($v641ee90996ed9781bf72b559b9c90742->getParentId() == 0) break;}while(!$v89b0b9deff65f8b9cd1f71bc74ce36ba && $v641ee90996ed9781bf72b559b9c90742);if($v89b0b9deff65f8b9cd1f71bc74ce36ba instanceof iUmiHierarchyType) {$v52a43e48ec4649dee819dadabcab1bde = $v89b0b9deff65f8b9cd1f71bc74ce36ba->getName();$vddaa6e8c8c412299272e183087b8f7b6 = $v89b0b9deff65f8b9cd1f71bc74ce36ba->getExt();if($ve52043002b9b5525cbc3f3bee69ff9b4 = $v8b1dc169bf460ee884fceef66c6607d6->getModule($v52a43e48ec4649dee819dadabcab1bde)) {$v2a304a1348456ccd2234cd71a81bd338 = $ve52043002b9b5525cbc3f3bee69ff9b4->getObjectEditLink($v16b2b26000987faccb260b9d39df1269, $vddaa6e8c8c412299272e183087b8f7b6);if($v2a304a1348456ccd2234cd71a81bd338 !== false) {$v26b75b176d665f24a5fd22a2ad815763['edit-link'] = $v2a304a1348456ccd2234cd71a81bd338;}}}if(!isset($v26b75b176d665f24a5fd22a2ad815763['edit-link']) &&    $v8b1dc169bf460ee884fceef66c6607d6->getCurrentModule() == 'data' && $v8b1dc169bf460ee884fceef66c6607d6->getCurrentMethod() == 'guide_items') {$v764b2484f7ecf6b627a89fd3f7fe9f3d = $v8b1dc169bf460ee884fceef66c6607d6->getModule('data');$v26b75b176d665f24a5fd22a2ad815763['edit-link'] = $v764b2484f7ecf6b627a89fd3f7fe9f3d->getObjectEditLink($v16b2b26000987faccb260b9d39df1269);}}$v26b75b176d665f24a5fd22a2ad815763['properties'] = Array();$v26b75b176d665f24a5fd22a2ad815763['properties']['nodes:group'] = Array();$v865c0c0b4ab0e063e5caa3387c1a8741 = 0;foreach($v143fdbfa2afa490e521056bd5040d5fd as $vdb0f6f37ebeb6ea09489124345af2a45) {$v71ea3b11aebda17ad80b6499a6ab6fb0 = Array();$v03f2ce8694aef1464a97f254c78a26ae = translatorWrapper::get($vdb0f6f37ebeb6ea09489124345af2a45);$v71ea3b11aebda17ad80b6499a6ab6fb0 = $v03f2ce8694aef1464a97f254c78a26ae->translateProperties($vdb0f6f37ebeb6ea09489124345af2a45, $va8cfde6331bd59eb2ac96f8911c4b666);if(!empty($v71ea3b11aebda17ad80b6499a6ab6fb0)) {$v26b75b176d665f24a5fd22a2ad815763['properties']['nodes:group'][(getRequest('jsonMode') == "force" ? $v865c0c0b4ab0e063e5caa3387c1a8741++ : ++$v865c0c0b4ab0e063e5caa3387c1a8741)] = $v71ea3b11aebda17ad80b6499a6ab6fb0;}}if(sizeof($v26b75b176d665f24a5fd22a2ad815763['properties']['nodes:group']) == 0) {unset($v26b75b176d665f24a5fd22a2ad815763['properties']);}return $v26b75b176d665f24a5fd22a2ad815763;}};?>