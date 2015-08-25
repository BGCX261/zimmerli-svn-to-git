<?php
 class umiHierarchy extends singleton implements iSingleton, iUmiHierarchy {private $elements = array(),   $objects, $langs, $domains, $templates;private $updatedElements = Array();private $autocorrectionDisabled = false;private $elementsLastUpdateTime = 0;private $bForceAbsolutePath = false;private $symlinks = Array();private $misc_elements = Array();private $pathCache = array();private $pathPiecesCache = array();private $defaultCache = array();private $parentsCache = array();private $idByPathCache = array();public static $ignoreSiteMap = false;protected function __construct() {showWorkTime("umihierarchy construct start");$this->objects  = umiObjectsCollection::getInstance();showWorkTime("umihierarchy umiObjectsCollection init");$this->langs  = langsCollection::getInstance();showWorkTime("umihierarchy langsCollection init");$this->domains  = domainsCollection::getInstance();showWorkTime("umihierarchy domainsCollection init");$this->templates = templatesCollection::getInstance();showWorkTime("umihierarchy templatesCollection init");if(regedit::getInstance()->getVal("//settings/disable_url_autocorrection")) {$this->autocorrectionDisabled = true;}}public static function getInstance($v4a8a08f09d37b73795649038408b5f33 = NULL) {return parent::getInstance(__CLASS__);}public function isExists($v7057e8409c7c531a1a6e9ac3df4ed549) {if($this->isLoaded($v7057e8409c7c531a1a6e9ac3df4ed549)) {return true;}else {$v7057e8409c7c531a1a6e9ac3df4ed549 = (int) $v7057e8409c7c531a1a6e9ac3df4ed549;$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT id FROM cms3_hierarchy WHERE id = '{$v7057e8409c7c531a1a6e9ac3df4ed549}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);list($ve2942a04780e223b215eb8b663cf5353) = mysql_fetch_row($result);return (bool) $ve2942a04780e223b215eb8b663cf5353;}}public function isLoaded($v7057e8409c7c531a1a6e9ac3df4ed549) {if($v7057e8409c7c531a1a6e9ac3df4ed549 === false) {return false;}if(is_array($v7057e8409c7c531a1a6e9ac3df4ed549)) {$v5b78ddc78e0a270e44c7928843456220 = true;foreach($v7057e8409c7c531a1a6e9ac3df4ed549 as $v7a83e592dae31301d9b5c2bbc544d822) {if(!array_key_exists($v7a83e592dae31301d9b5c2bbc544d822, $this->elements)) {$v5b78ddc78e0a270e44c7928843456220 = false;break;}}return $v5b78ddc78e0a270e44c7928843456220;}else {return (bool) array_key_exists($v7057e8409c7c531a1a6e9ac3df4ed549, $this->elements);}}public function getElement($v7057e8409c7c531a1a6e9ac3df4ed549, $ve70325c72e806c33fd52022dd9c07eb2 = false, $vbeaf7e25161be5ef9784e550ab4fc891 = false, $vf1965a857bc285d26fe22023aa5ab50d = false) {if(!$v7057e8409c7c531a1a6e9ac3df4ed549) {return false;}if($vf1965a857bc285d26fe22023aa5ab50d === false && !$ve70325c72e806c33fd52022dd9c07eb2 && !$this->isAllowed($v7057e8409c7c531a1a6e9ac3df4ed549)) return false;$vb99eb979e6f6efabc396f777b503f7e7 = cacheFrontend::getInstance();if($this->isLoaded($v7057e8409c7c531a1a6e9ac3df4ed549)) {return $this->elements[$v7057e8409c7c531a1a6e9ac3df4ed549];}else {$v8e2dcfd7e7e24b1ca76c1193f645902b = $vb99eb979e6f6efabc396f777b503f7e7->load($v7057e8409c7c531a1a6e9ac3df4ed549, "element");if($v8e2dcfd7e7e24b1ca76c1193f645902b instanceof iUmiHierarchyElement == false) {try {$v8e2dcfd7e7e24b1ca76c1193f645902b = new umiHierarchyElement($v7057e8409c7c531a1a6e9ac3df4ed549, $vf1965a857bc285d26fe22023aa5ab50d);$vb99eb979e6f6efabc396f777b503f7e7->save($v8e2dcfd7e7e24b1ca76c1193f645902b, "element");}catch (privateException $ve1671797c52e15f763380b45e841ec32) {return false;}}$this->misc_elements[] = $v7057e8409c7c531a1a6e9ac3df4ed549;if(is_object($v8e2dcfd7e7e24b1ca76c1193f645902b)) {if($v8e2dcfd7e7e24b1ca76c1193f645902b->getIsBroken()) return false;if($v8e2dcfd7e7e24b1ca76c1193f645902b->getIsDeleted() && !$vbeaf7e25161be5ef9784e550ab4fc891) return false;$this->pushElementsLastUpdateTime($v8e2dcfd7e7e24b1ca76c1193f645902b->getUpdateTime());$this->elements[$v7057e8409c7c531a1a6e9ac3df4ed549] = $v8e2dcfd7e7e24b1ca76c1193f645902b;return $this->elements[$v7057e8409c7c531a1a6e9ac3df4ed549];}else return false;}}public function delElement($v7057e8409c7c531a1a6e9ac3df4ed549) {$v7057e8409c7c531a1a6e9ac3df4ed549 = (int) $v7057e8409c7c531a1a6e9ac3df4ed549;$this->disableCache();$vb99eb979e6f6efabc396f777b503f7e7 = cacheFrontend::getInstance();$v41275a535677f79ff347e01bc530c176 = permissionsCollection::getInstance();$this->addUpdatedElementId($v7057e8409c7c531a1a6e9ac3df4ed549);$this->forceCacheCleanup();if(!$v41275a535677f79ff347e01bc530c176->isAllowedObject($v41275a535677f79ff347e01bc530c176->getUserId(), $v7057e8409c7c531a1a6e9ac3df4ed549)) return false;if($v8e2dcfd7e7e24b1ca76c1193f645902b = $this->getElement($v7057e8409c7c531a1a6e9ac3df4ed549)) {$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT id FROM cms3_hierarchy FORCE INDEX(rel) WHERE rel = '{$v7057e8409c7c531a1a6e9ac3df4ed549}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);while(list($vf36263a38d7de5cdaa953c1e2b2f79b5) = mysql_fetch_row($result)) {$v2da0d90fc7822dade6effbdd1f48b458 = $this->getElement($vf36263a38d7de5cdaa953c1e2b2f79b5, true, true);$this->delElement($vf36263a38d7de5cdaa953c1e2b2f79b5);$vb99eb979e6f6efabc396f777b503f7e7->del($vf36263a38d7de5cdaa953c1e2b2f79b5, "element");}$v4119639092e62c55ea8be348e4d9260d = new umiEventPoint("hierarchyDeleteElement");$v4119639092e62c55ea8be348e4d9260d->setParam("element_id", $v7057e8409c7c531a1a6e9ac3df4ed549);$v4119639092e62c55ea8be348e4d9260d->setMode("after");$v4119639092e62c55ea8be348e4d9260d->call();$v8e2dcfd7e7e24b1ca76c1193f645902b->setIsDeleted(true);$v8e2dcfd7e7e24b1ca76c1193f645902b->commit();unset($this->elements[$v7057e8409c7c531a1a6e9ac3df4ed549]);$vb99eb979e6f6efabc396f777b503f7e7->del($v7057e8409c7c531a1a6e9ac3df4ed549, "element");return true;}else {return false;}}public function copyElement($v7057e8409c7c531a1a6e9ac3df4ed549, $vd5d4bb9b2c282937ee64b1fb0495ef08, $v5972c4d2dc988e33130281251a6f282a = false) {$v7057e8409c7c531a1a6e9ac3df4ed549 = (int) $v7057e8409c7c531a1a6e9ac3df4ed549;$this->disableCache();cacheFrontend::getInstance()->flush();$this->misc_elements[] = $vd5d4bb9b2c282937ee64b1fb0495ef08;$this->misc_elements[] = $v7057e8409c7c531a1a6e9ac3df4ed549;$this->forceCacheCleanup();if($this->isExists($v7057e8409c7c531a1a6e9ac3df4ed549) && ($this->isExists($vd5d4bb9b2c282937ee64b1fb0495ef08) || $vd5d4bb9b2c282937ee64b1fb0495ef08 === 0)) {$vd5d4bb9b2c282937ee64b1fb0495ef08 = (int) $vd5d4bb9b2c282937ee64b1fb0495ef08;$vd7e6d55ba379a13d08c25d15faf2a23b = self::getTimeStamp();if($v8e2dcfd7e7e24b1ca76c1193f645902b = $this->getElement($v7057e8409c7c531a1a6e9ac3df4ed549)) {$this->misc_elements[] = $v8e2dcfd7e7e24b1ca76c1193f645902b->getParentId();}$v9b207167e5381c47682c6b4f58a623fb = mysql_fetch_array(l_mysql_query('SELECT MAX(ord) FROM cms3_hierarchy', true));$v8bef1cc20ada3bef55fdf132cb2a1cb9 = $v9b207167e5381c47682c6b4f58a623fb[0]+1;$vac5c74b64b4b8352ef2f181affb5ac2a = <<<SQL

INSERT INTO cms3_hierarchy
	(rel, type_id, lang_id, domain_id, tpl_id, obj_id, alt_name, is_active, is_visible, is_deleted, updatetime, ord)
		SELECT '{$vd5d4bb9b2c282937ee64b1fb0495ef08}', type_id, lang_id, domain_id, tpl_id, obj_id, alt_name, is_active, is_visible, is_deleted, '{$vd7e6d55ba379a13d08c25d15faf2a23b}', '{$v8bef1cc20ada3bef55fdf132cb2a1cb9}'
				FROM cms3_hierarchy WHERE id = '{$v7057e8409c7c531a1a6e9ac3df4ed549}' LIMIT 1
SQL;

INSERT INTO cms3_permissions
	(level, owner_id, rel_id)
		SELECT level, owner_id, '{$v7057e8409c7c531a1a6e9ac3df4ed549}' FROM cms3_permissions WHERE rel_id = '{$v2114c8075d855b3cea53d5d880c68948}'

SQL;
INSERT INTO cms3_objects
	(name, is_locked, type_id, owner_id)
		SELECT name, is_locked, type_id, owner_id
			FROM cms3_objects
				WHERE id = '{$vaf31437ce61345f416579830a98c91e5}'
SQL;
INSERT INTO {$vd42aabe7af66a0f15fceb090a57335e0}
	(field_id, int_val, varchar_val, text_val, rel_val, float_val, tree_val, obj_id)
		SELECT field_id, int_val, varchar_val, text_val, rel_val, float_val, tree_val, '{$v5e3f5f5bf865de072ff1e4cd710d4a39}'
			FROM {$vd42aabe7af66a0f15fceb090a57335e0}
				WHERE obj_id = '{$vaf31437ce61345f416579830a98c91e5}'
SQL;

INSERT INTO cms3_hierarchy
	(rel, type_id, lang_id, domain_id, tpl_id, obj_id, alt_name, is_active, is_visible, is_deleted, updatetime, ord)
		SELECT '{$vd5d4bb9b2c282937ee64b1fb0495ef08}', type_id, lang_id, domain_id, tpl_id, '{$v5e3f5f5bf865de072ff1e4cd710d4a39}', alt_name, is_active, is_visible, is_deleted, '{$vd7e6d55ba379a13d08c25d15faf2a23b}', '{$v8bef1cc20ada3bef55fdf132cb2a1cb9}'
				FROM cms3_hierarchy WHERE id = '{$v7057e8409c7c531a1a6e9ac3df4ed549}' LIMIT 1
SQL;

INSERT INTO cms3_permissions
	(level, owner_id, rel_id)
		SELECT level, owner_id, '{$v7057e8409c7c531a1a6e9ac3df4ed549}' FROM cms3_permissions WHERE rel_id = '{$v2114c8075d855b3cea53d5d880c68948}'

SQL;
SELECT id, rel FROM cms3_hierarchy WHERE is_deleted = '1' ORDER BY updatetime DESC
SQL;
SELECT o.type_id, COUNT(*) AS c
	FROM cms3_hierarchy h, cms3_objects o, cms3_hierarchy_relations hr
		WHERE hr.rel_id = '{$v7057e8409c7c531a1a6e9ac3df4ed549}' AND h.id=hr.child_id AND h.is_deleted = '0' AND o.id = h.obj_id AND h.lang_id = '{$v78e6dd7a49f5b0cb2106a3a434dd5c86}' AND h.domain_id = '{$v662cbf1253ac7d8750ed9190c52163e5}'
			{$v3ffc6a9588cb6b3add8e15f37ebc93ad}
			GROUP BY o.type_id
				ORDER BY c DESC
					LIMIT 1
SQL;
SELECT o.type_id, COUNT(*) AS c
	FROM cms3_hierarchy h, cms3_objects o
		WHERE h.rel = '{$v7057e8409c7c531a1a6e9ac3df4ed549}' AND h.is_deleted = '0' AND o.id = h.obj_id AND h.lang_id = '{$v78e6dd7a49f5b0cb2106a3a434dd5c86}' AND h.domain_id = '{$v662cbf1253ac7d8750ed9190c52163e5}'
		{$v3ffc6a9588cb6b3add8e15f37ebc93ad}
			GROUP BY o.type_id
				ORDER BY c DESC
					LIMIT 1
SQL;
INSERT INTO cms3_hierarchy_relations (rel_id, child_id, level)
SELECT rel_id, '{$v7057e8409c7c531a1a6e9ac3df4ed549}', (level + 1) FROM cms3_hierarchy_relations WHERE child_id {$v8eeb1538ad4ac95142835550d08f1212}
SQL;
INSERT INTO cms3_hierarchy_relations (rel_id, child_id, level)
VALUES ({$v59a040d8f146c76cb91c7f341268d909}, '{$v7057e8409c7c531a1a6e9ac3df4ed549}', '{$vc9e9a848920877e76685b2e4e76de38d}')
SQL;