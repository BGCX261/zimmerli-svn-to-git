<?php
 class umiSelection implements iUmiSelection {private $order = Array(),   $limit = Array(),   $object_type = Array(),   $element_type = Array(),   $props = Array(),   $hierarchy = Array(),   $perms = Array(),   $names = Array(),   $active = Array(),   $owner = Array(),   $objects_ids = Array(),   $elements_ids = Array(),   $is_order = false,  $is_limit = false, $is_object_type = false, $is_element_type = false, $is_props = false, $is_hierarchy = false, $is_permissions = false, $is_forced = false, $is_names = false, $is_active = false,   $condition_mode_or = false, $is_owner = false,   $is_objects_ids = false, $is_elements_ids = false,   $is_domain_ignored = false, $isDomainIgnored = false, $isLangIgnored = false, $langId = false, $domainId = false,   $permissionsLevel = 1,   $searchStrings = Array();public $result = false, $count = false, $switchIllegalBetween = true;public $optimize_root_search_query = false;public $sql_part__hierarchy = "";public $sql_part__element_type = "";public $sql_part__owner = "";public $sql_part__objects = "";public $sql_part__elements = "";public $sql_part__perms = "";public $sql_part__perms_tables = "";public $sql_part__content_tables = "";public $sql_part__object_type = "";public $sql_part__props_and_names = "";public $sql_part__lang_cond = "";public $sql_part__domain_cond = "";public $sql_part__unactive_cond = "";public $sql_cond__total_joins = 0;public $sql_cond__content_tables_loaded = 0;public $sql_cond__need_content = false;public $sql_cond__need_hierarchy = false;public $sql_cond__domain_ignored = false;public $sql_cond_auto_domain = false;public $sql_arr_for_mark_used_fields = array();public $sql_arr_for_and_or_part = array();public $sql_kwd_distinct = "";public $sql_kwd_distinct_count = "";public $sql_kwd_straight_join = "";public $sql_select_expr = "";public $sql_table_references = "";public $sql_where_condition_required = "";public $sql_where_condition_common = "";public $sql_where_condition_additional = "";public $sql_order_by = "";public $sql_limit = "";public $objectTableIsRequired = false;public $excludeNestedPages = false;public $usedContentTables = Array();public function result() {return umiSelectionsParser::runSelection($this);}public function count() {return umiSelectionsParser::runSelectionCounts($this);}public function setObjectTypeFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_object_type = (bool) $v615ed030b41392ae2a69ca39f0d521a3;if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->object_type = Array();}public function setElementTypeFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_element_type = (bool) $v615ed030b41392ae2a69ca39f0d521a3;if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->element_type = Array();}public function setPropertyFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_props = (bool) $v615ed030b41392ae2a69ca39f0d521a3;if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->props = Array();}public function setLimitFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_limit = (bool) $v615ed030b41392ae2a69ca39f0d521a3;if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->limit = Array();}public function setHierarchyFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_hierarchy = (bool) $v615ed030b41392ae2a69ca39f0d521a3;if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->hierarchy = Array();}public function setOrderFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_order = (bool) $v615ed030b41392ae2a69ca39f0d521a3;if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->order = Array();}public function setPermissionsFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_permissions = $v615ed030b41392ae2a69ca39f0d521a3;$ve8701ad48ba05a91604e480dd60899a3 = $this->getCurrentUserId();if(cmsController::getInstance()->getModule("users")->isSv($ve8701ad48ba05a91604e480dd60899a3)) {$this->is_permissions = false;}if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->perms = Array();}public function setActiveFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_active = (bool) $v615ed030b41392ae2a69ca39f0d521a3;if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->is_active = Array();}public function setOwnerFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_owner = (bool) $v615ed030b41392ae2a69ca39f0d521a3;if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->is_owner = Array();}public function setObjectsFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_objects_ids = (bool) $v615ed030b41392ae2a69ca39f0d521a3;if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->is_objects_ids = Array();}public function setElementsFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_elements_ids = (bool) $v615ed030b41392ae2a69ca39f0d521a3;if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->is_elements_ids = Array();}public function setNamesFilter($v615ed030b41392ae2a69ca39f0d521a3 = true) {$this->is_names = (bool) $v615ed030b41392ae2a69ca39f0d521a3;if (!$v615ed030b41392ae2a69ca39f0d521a3) $this->names = Array();}public function forceHierarchyTable($v9a11e4b1e888a4467c1e9cabcd5243c9 = true) {$this->is_forced = (bool) $v9a11e4b1e888a4467c1e9cabcd5243c9;}public function addObjectType($v87306dd4235ed712ebc07fe169b76f83) {$this->setObjectTypeFilter();if(is_array($v87306dd4235ed712ebc07fe169b76f83)) {foreach($v87306dd4235ed712ebc07fe169b76f83 as $v9191678b4dce60a558a09976502caa71) {if(!$this->addObjectType($v9191678b4dce60a558a09976502caa71)) {return false;}}return true;}if(umiObjectTypesCollection::getInstance()->isExists($v87306dd4235ed712ebc07fe169b76f83)) {if(in_array($v87306dd4235ed712ebc07fe169b76f83, $this->object_type) === false) {$this->object_type[] = $v87306dd4235ed712ebc07fe169b76f83;return true;}else {return false;}}else {return false;}}public function addElementType($v9a0ad81d8ded2798e111f35a942f00e9) {$this->setElementTypeFilter();if(umiHierarchyTypesCollection::getInstance()->isExists($v9a0ad81d8ded2798e111f35a942f00e9)) {if(in_array($v9a0ad81d8ded2798e111f35a942f00e9, $this->element_type) === false) {$this->element_type[] = $v9a0ad81d8ded2798e111f35a942f00e9;return true;}else {return false;}}else {return false;}}public function addLimit($v9d85c254b5062e518a134a61950999c3, $v71860c77c6745379b0d44304d66b6a13 = 0) {$this->setLimitFilter();$v9d85c254b5062e518a134a61950999c3 = (int) $v9d85c254b5062e518a134a61950999c3;$v71860c77c6745379b0d44304d66b6a13 = (int) $v71860c77c6745379b0d44304d66b6a13;if($v71860c77c6745379b0d44304d66b6a13 < 0) {$v71860c77c6745379b0d44304d66b6a13 = 0;}$this->limit = Array($v9d85c254b5062e518a134a61950999c3, $v71860c77c6745379b0d44304d66b6a13);}public function addActiveFilter($vc76a5e84e4bdee527e274ea30c680d79) {$this->setActiveFilter();$this->active = Array($vc76a5e84e4bdee527e274ea30c680d79);}public function addOwnerFilter($vca105ed04a437dfe76422775527d3e83) {$this->setOwnerFilter();$this->owner = $this->toIntsArray($vca105ed04a437dfe76422775527d3e83);}public function addObjectsFilter($v486e8f4c27e77f00e55301bea98709b3) {$this->setObjectsFilter();$this->objects_ids = $this->toIntsArray($v486e8f4c27e77f00e55301bea98709b3);}public function addElementsFilter($v8d7953acf74eb79d375a932e111d71a3) {$this->setElementsFilter();$this->elements_ids = $this->toIntsArray($v8d7953acf74eb79d375a932e111d71a3);}public function setOrderByProperty($v3aabf39f2d943fa886d86dcbbee4d910, $v375a52cb87b22005816fe7a418ec6660 = true) {if(!$v3aabf39f2d943fa886d86dcbbee4d910) return false;$this->setOrderFilter();$v17f71d965fe9589ddbd11caf7182243e = $this->getDataByFieldId($v3aabf39f2d943fa886d86dcbbee4d910);$vb2c97ae425dd751b0e48a3acae79cf4a = Array("field_id" => $v3aabf39f2d943fa886d86dcbbee4d910, "asc" => $v375a52cb87b22005816fe7a418ec6660, "type" => $v17f71d965fe9589ddbd11caf7182243e, "native_field" => false);if(in_array($vb2c97ae425dd751b0e48a3acae79cf4a, $this->order) === false) {$this->order[] = $vb2c97ae425dd751b0e48a3acae79cf4a;return true;}else {return false;}}public function setOrderByOrd($v375a52cb87b22005816fe7a418ec6660 = true) {$this->setOrderFilter();$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => "native", "native_field" => "ord", "asc" => $v375a52cb87b22005816fe7a418ec6660);if(in_array($vb2c97ae425dd751b0e48a3acae79cf4a, $this->order) === false) {$this->order[] = $vb2c97ae425dd751b0e48a3acae79cf4a;return true;}else {return false;}}public function setOrderByRand() {$this->setOrderFilter();$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => "native", "native_field" => "rand", "asc" => true);if(in_array($vb2c97ae425dd751b0e48a3acae79cf4a, $this->order) === false) {$this->order[] = $vb2c97ae425dd751b0e48a3acae79cf4a;return true;}else {return false;}}public function setOrderByName($v375a52cb87b22005816fe7a418ec6660 = true) {$this->setOrderFilter();$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => "native", "native_field" => "name", "asc" => $v375a52cb87b22005816fe7a418ec6660);if(in_array($vb2c97ae425dd751b0e48a3acae79cf4a, $this->order) === false) {$this->order[] = $vb2c97ae425dd751b0e48a3acae79cf4a;return true;}else {return false;}}public function setOrderByObjectId($v375a52cb87b22005816fe7a418ec6660 = true) {$this->setOrderFilter();$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => "native", "native_field" => "object_id", "asc" => $v375a52cb87b22005816fe7a418ec6660);if(in_array($vb2c97ae425dd751b0e48a3acae79cf4a, $this->order) === false) {$this->order[] = $vb2c97ae425dd751b0e48a3acae79cf4a;return true;}else {return false;}}public function addHierarchyFilter($v7057e8409c7c531a1a6e9ac3df4ed549, $v12a055bf01a31369fe81ac35d85c7bc1 = 0, $vabd12ea100a9ec8377e3c7339f056b00 = true) {$this->setHierarchyFilter();if(is_array($v7057e8409c7c531a1a6e9ac3df4ed549)) {foreach($v7057e8409c7c531a1a6e9ac3df4ed549 as $vb80bb7740288fda1f201890375a60c8f) {$this->addHierarchyFilter($vb80bb7740288fda1f201890375a60c8f, $v12a055bf01a31369fe81ac35d85c7bc1);}return;}if(umiHierarchy::getInstance()->isExists($v7057e8409c7c531a1a6e9ac3df4ed549) || (is_numeric($v7057e8409c7c531a1a6e9ac3df4ed549) && $v7057e8409c7c531a1a6e9ac3df4ed549 == 0)) {if($v7057e8409c7c531a1a6e9ac3df4ed549 == umiHierarchy::getInstance()->getDefaultElementId() && $vabd12ea100a9ec8377e3c7339f056b00 == false) {$v7057e8409c7c531a1a6e9ac3df4ed549 = Array(0, 0);}if(in_array($v7057e8409c7c531a1a6e9ac3df4ed549, $this->hierarchy) === false || $v7057e8409c7c531a1a6e9ac3df4ed549 == 0) {$this->hierarchy[] = Array((int) $v7057e8409c7c531a1a6e9ac3df4ed549, $v12a055bf01a31369fe81ac35d85c7bc1);}if($v12a055bf01a31369fe81ac35d85c7bc1 > 0) {$this->hierarchy[] = Array($v7057e8409c7c531a1a6e9ac3df4ed549, $v12a055bf01a31369fe81ac35d85c7bc1);}}else {return false;}}public function addPropertyFilterBetween($v3aabf39f2d943fa886d86dcbbee4d910, $vd8bd79cc131920d5de426f914d17405a, $v2ffe4e77325d9a7152f7086ea7aa5114) {if(!$v3aabf39f2d943fa886d86dcbbee4d910) return false;$this->setPropertyFilter();$v17f71d965fe9589ddbd11caf7182243e = $this->getDataByFieldId($v3aabf39f2d943fa886d86dcbbee4d910);if($this->switchIllegalBetween && $vd8bd79cc131920d5de426f914d17405a > $v2ffe4e77325d9a7152f7086ea7aa5114) {$vfa816edb83e95bf0c8da580bdfd491ef = $vd8bd79cc131920d5de426f914d17405a;$vd8bd79cc131920d5de426f914d17405a = $v2ffe4e77325d9a7152f7086ea7aa5114;$v2ffe4e77325d9a7152f7086ea7aa5114 = $vfa816edb83e95bf0c8da580bdfd491ef;unset($vfa816edb83e95bf0c8da580bdfd491ef);}$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => $v17f71d965fe9589ddbd11caf7182243e, "field_id" => $v3aabf39f2d943fa886d86dcbbee4d910, "filter_type" => "between", "min" => $vd8bd79cc131920d5de426f914d17405a, "max" => $v2ffe4e77325d9a7152f7086ea7aa5114);$this->props[] = $vb2c97ae425dd751b0e48a3acae79cf4a;}public function addPropertyFilterEqual($v3aabf39f2d943fa886d86dcbbee4d910, $v2063c1608d6e0baf80249c42e2be5804, $ve1e4c5d3ee9d4ae51d2a0e4d3ed5460c = true) {if(!$v3aabf39f2d943fa886d86dcbbee4d910 || !sizeof($v2063c1608d6e0baf80249c42e2be5804)) return false;$this->setPropertyFilter();$v17f71d965fe9589ddbd11caf7182243e = $this->getDataByFieldId($v3aabf39f2d943fa886d86dcbbee4d910);$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => $v17f71d965fe9589ddbd11caf7182243e, "field_id" => $v3aabf39f2d943fa886d86dcbbee4d910, "filter_type" => "equal", "value" => $v2063c1608d6e0baf80249c42e2be5804, "case_insencetive" => $ve1e4c5d3ee9d4ae51d2a0e4d3ed5460c);$this->props[] = $vb2c97ae425dd751b0e48a3acae79cf4a;}public function addPropertyFilterNotEqual($v3aabf39f2d943fa886d86dcbbee4d910, $v2063c1608d6e0baf80249c42e2be5804, $ve1e4c5d3ee9d4ae51d2a0e4d3ed5460c = true) {if(!$v3aabf39f2d943fa886d86dcbbee4d910) return false;$this->setPropertyFilter();$v17f71d965fe9589ddbd11caf7182243e = $this->getDataByFieldId($v3aabf39f2d943fa886d86dcbbee4d910);$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => $v17f71d965fe9589ddbd11caf7182243e, "field_id" => $v3aabf39f2d943fa886d86dcbbee4d910, "filter_type" => "not_equal", "value" => $v2063c1608d6e0baf80249c42e2be5804, "case_insencetive" => $ve1e4c5d3ee9d4ae51d2a0e4d3ed5460c);$this->props[] = $vb2c97ae425dd751b0e48a3acae79cf4a;}public function addPropertyFilterLike($v3aabf39f2d943fa886d86dcbbee4d910, $v2063c1608d6e0baf80249c42e2be5804, $ve1e4c5d3ee9d4ae51d2a0e4d3ed5460c = true) {if(!$v3aabf39f2d943fa886d86dcbbee4d910) return false;$this->setPropertyFilter();$v17f71d965fe9589ddbd11caf7182243e = $this->getDataByFieldId($v3aabf39f2d943fa886d86dcbbee4d910);$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => $v17f71d965fe9589ddbd11caf7182243e, "field_id" => $v3aabf39f2d943fa886d86dcbbee4d910, "filter_type" => "like", "value" => $v2063c1608d6e0baf80249c42e2be5804, "case_insencetive" => $ve1e4c5d3ee9d4ae51d2a0e4d3ed5460c);$this->props[] = $vb2c97ae425dd751b0e48a3acae79cf4a;}public function addPropertyFilterMore($v3aabf39f2d943fa886d86dcbbee4d910, $v2063c1608d6e0baf80249c42e2be5804) {if(!$v3aabf39f2d943fa886d86dcbbee4d910) return false;$this->setPropertyFilter();$v17f71d965fe9589ddbd11caf7182243e = $this->getDataByFieldId($v3aabf39f2d943fa886d86dcbbee4d910);$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => $v17f71d965fe9589ddbd11caf7182243e, "field_id" => $v3aabf39f2d943fa886d86dcbbee4d910, "filter_type" => "more", "value" => $v2063c1608d6e0baf80249c42e2be5804);$this->props[] = $vb2c97ae425dd751b0e48a3acae79cf4a;}public function addPropertyFilterLess($v3aabf39f2d943fa886d86dcbbee4d910, $v2063c1608d6e0baf80249c42e2be5804) {if(!$v3aabf39f2d943fa886d86dcbbee4d910) return false;$this->setPropertyFilter();$v17f71d965fe9589ddbd11caf7182243e = $this->getDataByFieldId($v3aabf39f2d943fa886d86dcbbee4d910);$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => $v17f71d965fe9589ddbd11caf7182243e, "field_id" => $v3aabf39f2d943fa886d86dcbbee4d910, "filter_type" => "less", "value" => $v2063c1608d6e0baf80249c42e2be5804);$this->props[] = $vb2c97ae425dd751b0e48a3acae79cf4a;}public function addPropertyFilterIsNull($v3aabf39f2d943fa886d86dcbbee4d910) {if(!$v3aabf39f2d943fa886d86dcbbee4d910) return false;$this->setPropertyFilter();$v17f71d965fe9589ddbd11caf7182243e = $this->getDataByFieldId($v3aabf39f2d943fa886d86dcbbee4d910);$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => $v17f71d965fe9589ddbd11caf7182243e, "field_id" => $v3aabf39f2d943fa886d86dcbbee4d910, "filter_type" => "null");$this->props[] = $vb2c97ae425dd751b0e48a3acae79cf4a;}public function addPropertyFilterIsNotNull($v3aabf39f2d943fa886d86dcbbee4d910) {if(!$v3aabf39f2d943fa886d86dcbbee4d910) return false;$this->setPropertyFilter();$v17f71d965fe9589ddbd11caf7182243e = $this->getDataByFieldId($v3aabf39f2d943fa886d86dcbbee4d910);$vb2c97ae425dd751b0e48a3acae79cf4a = Array("type" => $v17f71d965fe9589ddbd11caf7182243e, "field_id" => $v3aabf39f2d943fa886d86dcbbee4d910, "filter_type" => "notnull");$this->props[] = $vb2c97ae425dd751b0e48a3acae79cf4a;}public function addPermissions($ve8701ad48ba05a91604e480dd60899a3 = false) {$this->setPermissionsFilter();if($ve8701ad48ba05a91604e480dd60899a3 === false) {$v41275a535677f79ff347e01bc530c176 = permissionsCollection::getInstance();if($v41275a535677f79ff347e01bc530c176->isSv()) return;$ve8701ad48ba05a91604e480dd60899a3 = $v41275a535677f79ff347e01bc530c176->getUserId();}$vb132392a317588e56460e77a8fd74229 = $this->getOwnersByUser($ve8701ad48ba05a91604e480dd60899a3);$this->perms = $vb132392a317588e56460e77a8fd74229;}public function setPermissionsLevel($vc9e9a848920877e76685b2e4e76de38d = 1) {$this->permissionsLevel = (int) $vc9e9a848920877e76685b2e4e76de38d;}public function addNameFilterEquals($v2063c1608d6e0baf80249c42e2be5804) {$this->setNamesFilter();$v2063c1608d6e0baf80249c42e2be5804 = Array("value" => $v2063c1608d6e0baf80249c42e2be5804, "type" => "exact");if(!in_array($v2063c1608d6e0baf80249c42e2be5804, $this->names)) {$this->names[] = $v2063c1608d6e0baf80249c42e2be5804;}}public function addNameFilterLike($v2063c1608d6e0baf80249c42e2be5804) {$this->setNamesFilter();$v2063c1608d6e0baf80249c42e2be5804 = Array("value" => $v2063c1608d6e0baf80249c42e2be5804, "type" => "like");if(!in_array($v2063c1608d6e0baf80249c42e2be5804, $this->names)) {$this->names[] = $v2063c1608d6e0baf80249c42e2be5804;}}public function getOrderConds() {return ($this->is_order) ? $this->order : false;}public function getLimitConds() {return ($this->is_limit) ? $this->limit : false;}public function getActiveConds() {return ($this->is_active) ? $this->active : false;}public function getOwnerConds() {$va7ea85302605a40475ffd70703779448 = array();if (is_array($this->owner) && count($this->owner)) {$va7ea85302605a40475ffd70703779448 = array_map('intval', $this->owner);}return ($this->is_owner) ? $va7ea85302605a40475ffd70703779448 : false;}public function getObjectsConds() {$va7ea85302605a40475ffd70703779448 = array();if (is_array($this->objects_ids) && count($this->objects_ids)) {$va7ea85302605a40475ffd70703779448 = array_map('intval', $this->objects_ids);}return ($this->is_objects_ids) ? $va7ea85302605a40475ffd70703779448 : false;}public function getElementsConds() {$va7ea85302605a40475ffd70703779448 = array();if (is_array($this->elements_ids) && count($this->elements_ids)) {$va7ea85302605a40475ffd70703779448 = array_map('intval', $this->elements_ids);}return ($this->is_elements_ids) ? $va7ea85302605a40475ffd70703779448 : false;}public function getPropertyConds() {return ($this->is_props) ? $this->props : false;}public function getObjectTypeConds() {return ($this->is_object_type) ? $this->object_type : false;}public function getElementTypeConds() {if($this->getObjectTypeConds() !== false) {return false;}if($this->optimize_root_search_query) {if(is_array($this->element_type)) {if(sizeof($this->element_type) > 1) {reset($this->element_type);$this->element_type = Array(current($this->element_type));}}}return ($this->is_element_type) ? $this->element_type : false;}public function getHierarchyConds() {$this->hierarchy = array_unique_arrays($this->hierarchy, 0);return ($this->is_hierarchy && !$this->optimize_root_search_query) ? $this->hierarchy : false;}public function getPermissionsConds() {return ($this->is_permissions) ? $this->perms : false;}public function getForceCond() {return $this->is_forced;}public function getNameConds() {return ($this->is_names) ? $this->names : false;}private function getDataByFieldId($v3aabf39f2d943fa886d86dcbbee4d910) {if($v06e3d36fa30cea095545139854ad1fb9 = umiFieldsCollection::getInstance()->getField($v3aabf39f2d943fa886d86dcbbee4d910)) {$v1e3f04102267eaf5e8d0ca424fd5c561 = $v06e3d36fa30cea095545139854ad1fb9->getFieldTypeId();if($v519504d7d4beb745dac24ccfb6c1d7c9 = umiFieldTypesCollection::getInstance()->getFieldType($v1e3f04102267eaf5e8d0ca424fd5c561)) {if($v17f71d965fe9589ddbd11caf7182243e = $v519504d7d4beb745dac24ccfb6c1d7c9->getDataType()) {return umiFieldType::getDataTypeDB($v17f71d965fe9589ddbd11caf7182243e);}else {return false;}}else {return false;}}else {return false;}}private function getCurrentUserId() {if($v9bc65c2abec141778ffaa729489f3e87 = cmsController::getInstance()->getModule("users")) {return $v9bc65c2abec141778ffaa729489f3e87->user_id;}else {return false;}}private function getOwnersByUser($ve8701ad48ba05a91604e480dd60899a3) {if($vee11cbb19052e40b07aac0ca060c23ee = umiObjectsCollection::getInstance()->getObject($ve8701ad48ba05a91604e480dd60899a3)) {$v1471e4e05a4db95d353cc867fe317314 = $vee11cbb19052e40b07aac0ca060c23ee->getValue("groups");$v1471e4e05a4db95d353cc867fe317314[] = $ve8701ad48ba05a91604e480dd60899a3;return $v1471e4e05a4db95d353cc867fe317314;}else {return false;}}public function setConditionModeOr() {$this->condition_mode_or = true;}public function getConditionModeOr() {return $this->condition_mode_or;}public function setIsDomainIgnored($vf3e6017a1a6654acd4f621a18cc49878 = false) {$this->isDomainIgnored = (bool) $vf3e6017a1a6654acd4f621a18cc49878;}public function setIsLangIgnored($ve17f508d15b7985bf0f67b6d72c72072 = false) {$this->isLangIgnored = (bool) $ve17f508d15b7985bf0f67b6d72c72072;}public function getIsDomainIgnored() {return $this->isDomainIgnored;}public function getIsLangIgnored() {return $this->isLangIgnored;}public function setDomainId($v72ee76c5c29383b7c9f9225c1fa4d10b = false) {$this->domainId = ($v72ee76c5c29383b7c9f9225c1fa4d10b === false) ? false : (int) $v72ee76c5c29383b7c9f9225c1fa4d10b;}public function setLangId($vf585b7f018bb4ced15a03683a733e50b = false) {$this->langId = ($vf585b7f018bb4ced15a03683a733e50b === false) ? false : (int) $vf585b7f018bb4ced15a03683a733e50b;}public function searchText($v597a51f04d341eba4ca965899acc10b3) {if(is_string($v597a51f04d341eba4ca965899acc10b3)) {if(strlen($v597a51f04d341eba4ca965899acc10b3) > 0 && !in_array($v597a51f04d341eba4ca965899acc10b3, $this->searchStrings)) {$this->searchStrings[] = $v597a51f04d341eba4ca965899acc10b3;return true;}}return false;}public function getDomainId() {return $this->domainId;}public function getLangId() {return $this->langId;}public function getRequiredPermissionsLevel() {return $this->permissionsLevel;}public function getSearchStrings() {return $this->searchStrings;}public function resetTextSearch() {$this->searchStrings = Array();}private function toIntsArray($vb84684c51768c267eb8836ba206ab734) {$va7ea85302605a40475ffd70703779448 = Array();if (is_string($vb84684c51768c267eb8836ba206ab734)) {$va7ea85302605a40475ffd70703779448 = preg_split("/[^\d]/is", $vb84684c51768c267eb8836ba206ab734);}elseif (is_numeric($vb84684c51768c267eb8836ba206ab734)) {$va7ea85302605a40475ffd70703779448 = array(intval($vb84684c51768c267eb8836ba206ab734));}elseif (!is_array($vb84684c51768c267eb8836ba206ab734)) {$va7ea85302605a40475ffd70703779448 = array();}else {$va7ea85302605a40475ffd70703779448 = $vb84684c51768c267eb8836ba206ab734;}return array_map('intval', $va7ea85302605a40475ffd70703779448);}};?>
