<?php
 class searchModel extends singleton implements iSingleton, iSearchModel {public function __construct() {}public static function getInstance($v4a8a08f09d37b73795649038408b5f33 = NULL) {return parent::getInstance(__CLASS__);}public function index_all($vaa9f73eea60a006820d0f8768bc8a3fc = false, $ve4f9a63df3b81b4ed1a414f12da04a6e = 0) {$vfbb44b4487415b134bce9c790a27fe5e = 0;$ve4f9a63df3b81b4ed1a414f12da04a6e = (int) $ve4f9a63df3b81b4ed1a414f12da04a6e;$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT id, updatetime FROM cms3_hierarchy WHERE is_deleted = '0' AND is_active = '1' AND id > '{$ve4f9a63df3b81b4ed1a414f12da04a6e}' ORDER BY id LIMIT 1";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);while(list($v7057e8409c7c531a1a6e9ac3df4ed549, $v3e04dc2abd929a9d02e2e0fa41d24bf9) = mysql_fetch_row($result)) {++$vfbb44b4487415b134bce9c790a27fe5e;$ve4f9a63df3b81b4ed1a414f12da04a6e = $v7057e8409c7c531a1a6e9ac3df4ed549;$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT id, updatetime FROM cms3_hierarchy WHERE is_deleted = '0' AND is_active = '1' and id > '{$v7057e8409c7c531a1a6e9ac3df4ed549}' ORDER BY id LIMIT 1";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(!$this->elementIsReindexed($v7057e8409c7c531a1a6e9ac3df4ed549, $v3e04dc2abd929a9d02e2e0fa41d24bf9)) {$vd30305c13d0f42414482bf155bd13041 = $this->index_item($v7057e8409c7c531a1a6e9ac3df4ed549, true);}if(($vaa9f73eea60a006820d0f8768bc8a3fc !== false) && (--$vaa9f73eea60a006820d0f8768bc8a3fc == 0)) {break;}}$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT COUNT(*) FROM `cms3_search` LIMIT 1";$v43b5c9175984c071f30b873fdce0a000 = mysql_result(l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true), 0);return array("current"=>$v43b5c9175984c071f30b873fdce0a000, "lastId"=>$ve4f9a63df3b81b4ed1a414f12da04a6e);}public function index_item($v7057e8409c7c531a1a6e9ac3df4ed549, $v887c6b9b516fdd344e1f03a0786c90e8 = false) {if(defined("UMICMS_CLI_MODE") || defined("DISABLE_SEARCH_REINDEX")) {return false;}l_mysql_query("START TRANSACTION /* Reindexing element #{$v7057e8409c7c531a1a6e9ac3df4ed549} */", true);$vec5463c0e508eaa43548444d87ab2e83 = $this->parseItem($v7057e8409c7c531a1a6e9ac3df4ed549);l_mysql_query("COMMIT", true);return $vec5463c0e508eaa43548444d87ab2e83;}public function elementIsReindexed($v7057e8409c7c531a1a6e9ac3df4ed549, $v3e04dc2abd929a9d02e2e0fa41d24bf9) {$v7057e8409c7c531a1a6e9ac3df4ed549 = (int) $v7057e8409c7c531a1a6e9ac3df4ed549;$v3e04dc2abd929a9d02e2e0fa41d24bf9 = (int) $v3e04dc2abd929a9d02e2e0fa41d24bf9;$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT COUNT(*) FROM cms3_search WHERE rel_id = '{$v7057e8409c7c531a1a6e9ac3df4ed549}' AND indextime > '{$v3e04dc2abd929a9d02e2e0fa41d24bf9}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);list($v4a8a08f09d37b73795649038408b5f33) = mysql_fetch_row($result);return (bool) $v4a8a08f09d37b73795649038408b5f33;}public function parseItem($v7057e8409c7c531a1a6e9ac3df4ed549) {$v7057e8409c7c531a1a6e9ac3df4ed549 = (int) $v7057e8409c7c531a1a6e9ac3df4ed549;if(!($v8e2dcfd7e7e24b1ca76c1193f645902b = umiHierarchy::getInstance()->getElement($v7057e8409c7c531a1a6e9ac3df4ed549, true, true))) {return false;}if($v8e2dcfd7e7e24b1ca76c1193f645902b->getValue("is_unindexed")) {$v662cbf1253ac7d8750ed9190c52163e5 = $v8e2dcfd7e7e24b1ca76c1193f645902b->getDomainId();$v78e6dd7a49f5b0cb2106a3a434dd5c86 = $v8e2dcfd7e7e24b1ca76c1193f645902b->getLangId();$v94757cae63fd3e398c0811a976dd6bbe = $v8e2dcfd7e7e24b1ca76c1193f645902b->getTypeId();$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT COUNT(*) FROM cms3_search WHERE rel_id = '{$v7057e8409c7c531a1a6e9ac3df4ed549}'";list($v4a8a08f09d37b73795649038408b5f33) = mysql_fetch_row(l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true));if(!$v4a8a08f09d37b73795649038408b5f33) {$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_search (rel_id, domain_id, lang_id, type_id) VALUES('{$v7057e8409c7c531a1a6e9ac3df4ed549}', '{$v662cbf1253ac7d8750ed9190c52163e5}', '{$v78e6dd7a49f5b0cb2106a3a434dd5c86}', '{$v94757cae63fd3e398c0811a976dd6bbe}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);}return false;}$v9d1be7b20c9b43741bbda33a93ae2597 = Array();$v94757cae63fd3e398c0811a976dd6bbe = $v8e2dcfd7e7e24b1ca76c1193f645902b->getObject()->getTypeId();$v599dcce2998a6b40b1e38e8c6006cb0a = umiObjectTypesCollection::getInstance()->getType($v94757cae63fd3e398c0811a976dd6bbe);$vb308737ea9e2bcc45fd2bf20dc6c7d45 = $v599dcce2998a6b40b1e38e8c6006cb0a->getFieldsGroupsList();foreach($vb308737ea9e2bcc45fd2bf20dc6c7d45 as $v6c26c1979a522c2dd7e76e527aa69ca5 => $v38f582e54454005ec0664831734e1152) {foreach($v38f582e54454005ec0664831734e1152->getFields() as $v3aabf39f2d943fa886d86dcbbee4d910 => $v06e3d36fa30cea095545139854ad1fb9) {if($v06e3d36fa30cea095545139854ad1fb9->getIsInSearch() == false) continue;$v73f329f154a663bfda020aadcdd0b775 = $v06e3d36fa30cea095545139854ad1fb9->getName();$v3a6d0284e743dc4a9b86f97d6dd1a3bf = $v8e2dcfd7e7e24b1ca76c1193f645902b->getValue($v73f329f154a663bfda020aadcdd0b775);$v17f71d965fe9589ddbd11caf7182243e = $v06e3d36fa30cea095545139854ad1fb9->getFieldType()->getDataType();if($v17f71d965fe9589ddbd11caf7182243e) {if(is_array($v3a6d0284e743dc4a9b86f97d6dd1a3bf)) {if($v17f71d965fe9589ddbd11caf7182243e == 'relation') {foreach($v3a6d0284e743dc4a9b86f97d6dd1a3bf as $v865c0c0b4ab0e063e5caa3387c1a8741 => $v9e3669d19b675bd57058fd4664205d2a) {if($v447b7147e84be512208dcc0995d67ebc = selector::get('object')->id($v9e3669d19b675bd57058fd4664205d2a)) {$v3a6d0284e743dc4a9b86f97d6dd1a3bf[$v865c0c0b4ab0e063e5caa3387c1a8741] = $v447b7147e84be512208dcc0995d67ebc->name;unset($v447b7147e84be512208dcc0995d67ebc);}}}$v3a6d0284e743dc4a9b86f97d6dd1a3bf = implode(' ', $v3a6d0284e743dc4a9b86f97d6dd1a3bf);}else {if(is_object($v3a6d0284e743dc4a9b86f97d6dd1a3bf)) {continue;}if($v17f71d965fe9589ddbd11caf7182243e == 'relation') {if($v447b7147e84be512208dcc0995d67ebc = selector::get('object')->id($v3a6d0284e743dc4a9b86f97d6dd1a3bf)) {$v3a6d0284e743dc4a9b86f97d6dd1a3bf = $v447b7147e84be512208dcc0995d67ebc->name;}}}}if(is_null($v3a6d0284e743dc4a9b86f97d6dd1a3bf) || !$v3a6d0284e743dc4a9b86f97d6dd1a3bf) continue;$v3a6d0284e743dc4a9b86f97d6dd1a3bf = preg_replace("/%([A-z_]*)%/m", "", $v3a6d0284e743dc4a9b86f97d6dd1a3bf);$v3a6d0284e743dc4a9b86f97d6dd1a3bf = preg_replace("/%([A-zЂ-пРђ-СЏ \/\._\-\(\)0-9%:<>,!@\|'&=;\?\+#]*)%/m", "", $v3a6d0284e743dc4a9b86f97d6dd1a3bf);$v9d1be7b20c9b43741bbda33a93ae2597[$v73f329f154a663bfda020aadcdd0b775] = $v3a6d0284e743dc4a9b86f97d6dd1a3bf;}}$v9f1c8757350ffe06fffc7cc4b03150af = $this->buildIndexImage($v9d1be7b20c9b43741bbda33a93ae2597);$this->updateSearchIndex($v7057e8409c7c531a1a6e9ac3df4ed549, $v9f1c8757350ffe06fffc7cc4b03150af);}public function buildIndexImage($v5308cca1be08c0bdbdfd06290ce5bed2) {$vb798abe6e1b1318ee36b0dcb3fb9e4d3 = Array();$v63f4f1e9b725370f459720575cd5f953 = Array(    'h1' => 5,    'title' => 5,    'meta_keywords' => 3,    'meta_descriptions' => 3,    'tags' => 3   );foreach($v5308cca1be08c0bdbdfd06290ce5bed2 as $v972bf3f05d14ffbdb817bef60638ff00 => $v341be97d9aff90c9978347f66f945b77) {$v47c80780ab608cc046f2a6e6f071feb6 = $this->splitString($v341be97d9aff90c9978347f66f945b77);if(isset($v63f4f1e9b725370f459720575cd5f953[$v972bf3f05d14ffbdb817bef60638ff00])) {$v7edabf994b76a00cbc60c95af337db8f = (int) $v63f4f1e9b725370f459720575cd5f953[$v972bf3f05d14ffbdb817bef60638ff00];}else {$v7edabf994b76a00cbc60c95af337db8f = 1;}foreach($v47c80780ab608cc046f2a6e6f071feb6 as $vc47d187067c6cf953245f128b5fde62a)  {if(array_key_exists($vc47d187067c6cf953245f128b5fde62a, $vb798abe6e1b1318ee36b0dcb3fb9e4d3)) {$vb798abe6e1b1318ee36b0dcb3fb9e4d3[$vc47d187067c6cf953245f128b5fde62a] += $v7edabf994b76a00cbc60c95af337db8f;}else {$vb798abe6e1b1318ee36b0dcb3fb9e4d3[$vc47d187067c6cf953245f128b5fde62a] = $v7edabf994b76a00cbc60c95af337db8f;}}}return $vb798abe6e1b1318ee36b0dcb3fb9e4d3;}public static function splitString($v341be97d9aff90c9978347f66f945b77) {if(is_object($v341be97d9aff90c9978347f66f945b77)) {return NULL;}$v29a6859860d0f35ec9a976557ce6923c = Array("&nbsp;", "&quote;", ".", ",", "?", ":", ";", "%", ")", "(", "/", 0x171, 0x187, "<", ">", "-");$v341be97d9aff90c9978347f66f945b77 = str_replace(">", "> ", $v341be97d9aff90c9978347f66f945b77);$v341be97d9aff90c9978347f66f945b77 = str_replace("\"", " ", $v341be97d9aff90c9978347f66f945b77);$v341be97d9aff90c9978347f66f945b77 = strip_tags($v341be97d9aff90c9978347f66f945b77);$v341be97d9aff90c9978347f66f945b77 = str_replace($v29a6859860d0f35ec9a976557ce6923c, " ", $v341be97d9aff90c9978347f66f945b77);$v341be97d9aff90c9978347f66f945b77 = preg_replace("/([ \t\r\n]{1-100})/u", " ", $v341be97d9aff90c9978347f66f945b77);$v341be97d9aff90c9978347f66f945b77 = wa_strtolower($v341be97d9aff90c9978347f66f945b77);$vfa816edb83e95bf0c8da580bdfd491ef = explode(" ", $v341be97d9aff90c9978347f66f945b77);$v9b207167e5381c47682c6b4f58a623fb = Array();foreach($vfa816edb83e95bf0c8da580bdfd491ef as $v9e3669d19b675bd57058fd4664205d2a) {$v9e3669d19b675bd57058fd4664205d2a = trim($v9e3669d19b675bd57058fd4664205d2a);if(wa_strlen($v9e3669d19b675bd57058fd4664205d2a) <= 2) continue;$v9b207167e5381c47682c6b4f58a623fb[] = $v9e3669d19b675bd57058fd4664205d2a;}return $v9b207167e5381c47682c6b4f58a623fb;}public function updateSearchIndex($v7057e8409c7c531a1a6e9ac3df4ed549, $v9f1c8757350ffe06fffc7cc4b03150af) {$v8e2dcfd7e7e24b1ca76c1193f645902b = umiHierarchy::getInstance()->getElement($v7057e8409c7c531a1a6e9ac3df4ed549, true);if (!$v8e2dcfd7e7e24b1ca76c1193f645902b instanceof umiEntinty) return false;$v662cbf1253ac7d8750ed9190c52163e5 = $v8e2dcfd7e7e24b1ca76c1193f645902b->getDomainId();$v78e6dd7a49f5b0cb2106a3a434dd5c86 = $v8e2dcfd7e7e24b1ca76c1193f645902b->getLangId();$v94757cae63fd3e398c0811a976dd6bbe = $v8e2dcfd7e7e24b1ca76c1193f645902b->getTypeId();$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT COUNT(*) FROM cms3_search WHERE rel_id = '{$v7057e8409c7c531a1a6e9ac3df4ed549}'";list($v4a8a08f09d37b73795649038408b5f33) = mysql_fetch_row(l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true));if(!$v4a8a08f09d37b73795649038408b5f33) {$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_search (rel_id, domain_id, lang_id, type_id) VALUES('{$v7057e8409c7c531a1a6e9ac3df4ed549}', '{$v662cbf1253ac7d8750ed9190c52163e5}', '{$v78e6dd7a49f5b0cb2106a3a434dd5c86}', '{$v94757cae63fd3e398c0811a976dd6bbe}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);}$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_search_index WHERE rel_id = '{$v7057e8409c7c531a1a6e9ac3df4ed549}'";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_search_index (rel_id, weight, word_id, tf) VALUES ";$v7b8b965ad4bca0e41ab51de7b31363a1 = 0;$vb29c3fd06b2e60bd082b5378410d9171 = array_sum($v9f1c8757350ffe06fffc7cc4b03150af);foreach($v9f1c8757350ffe06fffc7cc4b03150af as $vc47d187067c6cf953245f128b5fde62a => $v7edabf994b76a00cbc60c95af337db8f) {if(($v83ca49d02d735958e354492a19f076b0 = $this->getWordId($vc47d187067c6cf953245f128b5fde62a)) == false) continue;$vc3ee2af7ca7bbe492f11cf36a6a7cea7 = $v7edabf994b76a00cbc60c95af337db8f / $vb29c3fd06b2e60bd082b5378410d9171;$vac5c74b64b4b8352ef2f181affb5ac2a .= "('{$v7057e8409c7c531a1a6e9ac3df4ed549}', '{$v7edabf994b76a00cbc60c95af337db8f}', '{$v83ca49d02d735958e354492a19f076b0}', '{$vc3ee2af7ca7bbe492f11cf36a6a7cea7}'), ";++$v7b8b965ad4bca0e41ab51de7b31363a1;}if($v7b8b965ad4bca0e41ab51de7b31363a1) {$vac5c74b64b4b8352ef2f181affb5ac2a = substr($vac5c74b64b4b8352ef2f181affb5ac2a, 0, wa_strlen($vac5c74b64b4b8352ef2f181affb5ac2a) - 2);l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);}$v07cc694b9b3fc636710fa08b6922c42b = time();$vac5c74b64b4b8352ef2f181affb5ac2a = "UPDATE cms3_search SET indextime = '{$v07cc694b9b3fc636710fa08b6922c42b}' WHERE rel_id = '{$v7057e8409c7c531a1a6e9ac3df4ed549}'";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);umiHierarchy::getInstance()->unloadElement($v7057e8409c7c531a1a6e9ac3df4ed549);return true;}public static function getWordId($vc47d187067c6cf953245f128b5fde62a) {$vc47d187067c6cf953245f128b5fde62a = str_replace("037", "", $vc47d187067c6cf953245f128b5fde62a);$vc47d187067c6cf953245f128b5fde62a = trim($vc47d187067c6cf953245f128b5fde62a, "\r\n\t? ;.,!@#$%^&*()_+-=\\/:<>{}[]'\"`~|");$vc47d187067c6cf953245f128b5fde62a = wa_strtolower($vc47d187067c6cf953245f128b5fde62a);if(wa_strlen($vc47d187067c6cf953245f128b5fde62a) < 3) {return false;}$vc47d187067c6cf953245f128b5fde62a = l_mysql_real_escape_string($vc47d187067c6cf953245f128b5fde62a);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT id FROM cms3_search_index_words WHERE word = '{$vc47d187067c6cf953245f128b5fde62a}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v83ca49d02d735958e354492a19f076b0) = mysql_fetch_row($result)) {return $v83ca49d02d735958e354492a19f076b0;}else {$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_search_index_words (word) VALUES('{$vc47d187067c6cf953245f128b5fde62a}')";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);return (int) l_mysql_insert_id();}}public function getIndexPages() {$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT SQL_SMALL_RESULT COUNT(*) FROM cms3_search";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);list($v4a8a08f09d37b73795649038408b5f33) = mysql_fetch_row($result);return (int) $v4a8a08f09d37b73795649038408b5f33;}public function getAllIndexablePages() {$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT COUNT(*) FROM cms3_hierarchy WHERE is_deleted = '0' AND is_active = '1' ORDER BY id LIMIT 1";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);list($v4a8a08f09d37b73795649038408b5f33) = mysql_fetch_row($result);return (int) $v4a8a08f09d37b73795649038408b5f33;}public function getIndexWords() {$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT SQL_SMALL_RESULT SUM(weight) FROM cms3_search_index";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);list($v4a8a08f09d37b73795649038408b5f33) = mysql_fetch_row($result);return (int) $v4a8a08f09d37b73795649038408b5f33;}public function getIndexWordsUniq() {$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT SQL_SMALL_RESULT COUNT(*) FROM cms3_search_index_words";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);list($v4a8a08f09d37b73795649038408b5f33) = mysql_fetch_row($result);return (int) $v4a8a08f09d37b73795649038408b5f33;}public function getIndexLast() {$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT SQL_SMALL_RESULT indextime FROM cms3_search ORDER BY indextime DESC LIMIT 1";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);list($v4a8a08f09d37b73795649038408b5f33) = mysql_fetch_row($result);return (int) $v4a8a08f09d37b73795649038408b5f33;}public function truncate_index () {$vac5c74b64b4b8352ef2f181affb5ac2a = "TRUNCATE TABLE cms3_search_index_words";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);$vac5c74b64b4b8352ef2f181affb5ac2a = "TRUNCATE TABLE cms3_search_index";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);$vac5c74b64b4b8352ef2f181affb5ac2a = "TRUNCATE TABLE cms3_search";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);return true;}public function runSearch($v341be97d9aff90c9978347f66f945b77, $vb934cdf74d9a078a5654bd8b129741d9 = NULL, $v06eba0c81e2c853a3850d7d920570edb = NULL, $vae1d6a6518a73b480c52bcf30553f9f8 = false) {$v2574a7edd9f928bdb2eb29959e4e1797 = $this->splitString($v341be97d9aff90c9978347f66f945b77);$v89759e1284e2479b991d2669de104942 = Array();foreach($v2574a7edd9f928bdb2eb29959e4e1797 as $vc47d187067c6cf953245f128b5fde62a) {if(wa_strlen($vc47d187067c6cf953245f128b5fde62a) >= 3) {$v89759e1284e2479b991d2669de104942[] = $vc47d187067c6cf953245f128b5fde62a;}}$v6a7f245843454cf4f28ad7c5e2572aa2 = $this->buildQueries($v89759e1284e2479b991d2669de104942, $vb934cdf74d9a078a5654bd8b129741d9, $v06eba0c81e2c853a3850d7d920570edb, $vae1d6a6518a73b480c52bcf30553f9f8);return $v6a7f245843454cf4f28ad7c5e2572aa2;}public function buildQueries($v89759e1284e2479b991d2669de104942, $vb934cdf74d9a078a5654bd8b129741d9 = NULL, $v06eba0c81e2c853a3850d7d920570edb = NULL, $vae1d6a6518a73b480c52bcf30553f9f8 = false) {$v78e6dd7a49f5b0cb2106a3a434dd5c86 = cmsController::getInstance()->getCurrentLang()->getId();$v662cbf1253ac7d8750ed9190c52163e5 = cmsController::getInstance()->getCurrentDomain()->getId();$vf363554fffcbe5ed0107628b8a7452ba  = mainConfiguration::getInstance()->get('system','search-morph-disabled');$v721023118cca90897209b50c681b3160 = Array();foreach($v89759e1284e2479b991d2669de104942 as $v865c0c0b4ab0e063e5caa3387c1a8741 => $vc47d187067c6cf953245f128b5fde62a) {if(wa_strlen($vc47d187067c6cf953245f128b5fde62a) < 3) {unset($v89759e1284e2479b991d2669de104942[$v865c0c0b4ab0e063e5caa3387c1a8741]);continue;}$vc47d187067c6cf953245f128b5fde62a = l_mysql_real_escape_string($vc47d187067c6cf953245f128b5fde62a);$vc47d187067c6cf953245f128b5fde62a = str_replace(Array("%", "_"), Array("\\%", "\\_"), $vc47d187067c6cf953245f128b5fde62a);$v1c8b3a3ca57a0beda8c7653fd724183d = "siw.word LIKE '{$vc47d187067c6cf953245f128b5fde62a}%' ";if(!$vf363554fffcbe5ed0107628b8a7452ba)  {$v1c8b3a3ca57a0beda8c7653fd724183d .=' OR ';$v76f3c2687c1bc668f07f87b8e760cad7 = language_morph::get_word_base($vc47d187067c6cf953245f128b5fde62a);if(wa_strlen($v76f3c2687c1bc668f07f87b8e760cad7) >= 3) {$v76f3c2687c1bc668f07f87b8e760cad7 = l_mysql_real_escape_string($v76f3c2687c1bc668f07f87b8e760cad7);$v1c8b3a3ca57a0beda8c7653fd724183d .= "siw.word LIKE '{$v76f3c2687c1bc668f07f87b8e760cad7}%'";}else {$v1c8b3a3ca57a0beda8c7653fd724183d = trim($v1c8b3a3ca57a0beda8c7653fd724183d, " OR ");}}$v721023118cca90897209b50c681b3160[] = "(" . $v1c8b3a3ca57a0beda8c7653fd724183d . ")";}$v03ed04426fc17f79e0b77603ce6c81d3 = implode(" OR ", $v721023118cca90897209b50c681b3160);$v538df8a817542c341fb29adc5c5b165d = "";$v7b3d2a2630466b55db035bc4adc620b4 = "";if (!permissionsCollection::getInstance()->isSv()) {$v9bc65c2abec141778ffaa729489f3e87 = cmsController::getInstance()->getModule("users");$ve8701ad48ba05a91604e480dd60899a3 = $v9bc65c2abec141778ffaa729489f3e87->user_id;$vee11cbb19052e40b07aac0ca060c23ee = umiObjectsCollection::getInstance()->getObject($ve8701ad48ba05a91604e480dd60899a3);$v1471e4e05a4db95d353cc867fe317314 = $vee11cbb19052e40b07aac0ca060c23ee->getValue("groups");$v1471e4e05a4db95d353cc867fe317314[] = $ve8701ad48ba05a91604e480dd60899a3;$v1471e4e05a4db95d353cc867fe317314[] = regedit::getInstance()->getVal("//modules/users/guest_id");$v1471e4e05a4db95d353cc867fe317314 = array_extract_values($v1471e4e05a4db95d353cc867fe317314);$v1471e4e05a4db95d353cc867fe317314 = implode(', ', $v1471e4e05a4db95d353cc867fe317314);$v538df8a817542c341fb29adc5c5b165d = " AND c3p.level >= 1 AND c3p.owner_id IN({$v1471e4e05a4db95d353cc867fe317314})";$v7b3d2a2630466b55db035bc4adc620b4 = "INNER JOIN cms3_permissions as  `c3p` ON c3p.rel_id = s.rel_id";}$v6c666917ae648d1e7ec45408bf54efc6 = "";if(is_array($vb934cdf74d9a078a5654bd8b129741d9)) {if(sizeof($vb934cdf74d9a078a5654bd8b129741d9)) {if($vb934cdf74d9a078a5654bd8b129741d9 && $vb934cdf74d9a078a5654bd8b129741d9[0]) {$v6c666917ae648d1e7ec45408bf54efc6 = " AND s.type_id IN (" . l_mysql_real_escape_string(implode(", ", $vb934cdf74d9a078a5654bd8b129741d9)) . ")";}}}$va9e49c488dc6a07200de31dbd512d69a = "";if (is_array($v06eba0c81e2c853a3850d7d920570edb) && count($v06eba0c81e2c853a3850d7d920570edb)) {$va9e49c488dc6a07200de31dbd512d69a = " AND h.rel IN (" . l_mysql_real_escape_string(implode(", ", $v06eba0c81e2c853a3850d7d920570edb)) . ")";}if($v03ed04426fc17f79e0b77603ce6c81d3 == false) {return Array();}l_mysql_query("CREATE TEMPORARY TABLE temp_search (rel_id int unsigned, tf float, word varchar(64))");$vac5c74b64b4b8352ef2f181affb5ac2a = <<<EOF

				INSERT INTO temp_search SELECT SQL_SMALL_RESULT HIGH_PRIORITY  s.rel_id, si.weight, siw.word
				FROM cms3_search_index_words as `siw`
				 	INNER JOIN cms3_search_index as `si` ON si.word_id = siw.id
				 	INNER JOIN cms3_search as `s` ON s.rel_id = si.rel_id
				 	INNER JOIN cms3_hierarchy as  `h` ON h.id = s.rel_id
				 	{$v7b3d2a2630466b55db035bc4adc620b4}

				 WHERE
				 	({$v03ed04426fc17f79e0b77603ce6c81d3}) AND
				 	s.domain_id = '{$v662cbf1253ac7d8750ed9190c52163e5}' AND
				 	s.lang_id = '{$v78e6dd7a49f5b0cb2106a3a434dd5c86}' AND
					h.is_deleted = '0' AND
					h.is_active = '1'
					{$v6c666917ae648d1e7ec45408bf54efc6}
					{$va9e49c488dc6a07200de31dbd512d69a}
					{$v538df8a817542c341fb29adc5c5b165d}
				 GROUP BY s.rel_id, si.weight, siw.word


EOF;   $v9b207167e5381c47682c6b4f58a623fb = Array();l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);if($vae1d6a6518a73b480c52bcf30553f9f8) {$vac5c74b64b4b8352ef2f181affb5ac2a = <<<SQL
SELECT rel_id, SUM(tf) AS x
	FROM temp_search
		GROUP BY rel_id
			ORDER BY x DESC
SQL;   }else {$vdb9d5968645f90092f4b913cf77a9af7 = sizeof($v89759e1284e2479b991d2669de104942);$vac5c74b64b4b8352ef2f181affb5ac2a = <<<SQL
SELECT rel_id, SUM(tf) AS x, COUNT(word) AS wc
	FROM temp_search
		GROUP BY rel_id
			HAVING wc >= '{$vdb9d5968645f90092f4b913cf77a9af7}'
				ORDER BY x DESC
SQL;   }$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);while(list($v7057e8409c7c531a1a6e9ac3df4ed549) = mysql_fetch_row($result)) {$v9b207167e5381c47682c6b4f58a623fb[] = $v7057e8409c7c531a1a6e9ac3df4ed549;}l_mysql_query("DROP TEMPORARY TABLE IF EXISTS temp_search");return $v9b207167e5381c47682c6b4f58a623fb;}public function prepareContext($v7057e8409c7c531a1a6e9ac3df4ed549, $vcc475582f6f7e3f30f5a46236d75b6c5 = false) {if(!($v8e2dcfd7e7e24b1ca76c1193f645902b = umiHierarchy::getInstance()->getElement($v7057e8409c7c531a1a6e9ac3df4ed549))) {return false;}if($v8e2dcfd7e7e24b1ca76c1193f645902b->getValue("is_unindexed")) return false;$v5c18ef72771564b7f43c497dc507aeab = Array();$v94757cae63fd3e398c0811a976dd6bbe = $v8e2dcfd7e7e24b1ca76c1193f645902b->getObject()->getTypeId();$v599dcce2998a6b40b1e38e8c6006cb0a = umiObjectTypesCollection::getInstance()->getType($v94757cae63fd3e398c0811a976dd6bbe);$vb308737ea9e2bcc45fd2bf20dc6c7d45 = $v599dcce2998a6b40b1e38e8c6006cb0a->getFieldsGroupsList();foreach($vb308737ea9e2bcc45fd2bf20dc6c7d45 as $v6c26c1979a522c2dd7e76e527aa69ca5 => $v38f582e54454005ec0664831734e1152) {foreach($v38f582e54454005ec0664831734e1152->getFields() as $v3aabf39f2d943fa886d86dcbbee4d910 => $v06e3d36fa30cea095545139854ad1fb9) {if($v06e3d36fa30cea095545139854ad1fb9->getIsInSearch() == false) continue;$v73f329f154a663bfda020aadcdd0b775 = $v06e3d36fa30cea095545139854ad1fb9->getName();$v17f71d965fe9589ddbd11caf7182243e = $v06e3d36fa30cea095545139854ad1fb9->getFieldType()->getDataType();$v3a6d0284e743dc4a9b86f97d6dd1a3bf = $v8e2dcfd7e7e24b1ca76c1193f645902b->getValue($v73f329f154a663bfda020aadcdd0b775);if($v17f71d965fe9589ddbd11caf7182243e == 'relation') {if(!is_array($v3a6d0284e743dc4a9b86f97d6dd1a3bf)) {$v3a6d0284e743dc4a9b86f97d6dd1a3bf = array($v3a6d0284e743dc4a9b86f97d6dd1a3bf);}foreach($v3a6d0284e743dc4a9b86f97d6dd1a3bf as $v865c0c0b4ab0e063e5caa3387c1a8741 => $v9e3669d19b675bd57058fd4664205d2a) {if($v447b7147e84be512208dcc0995d67ebc = selector::get('object')->id($v9e3669d19b675bd57058fd4664205d2a)) {$v3a6d0284e743dc4a9b86f97d6dd1a3bf[$v865c0c0b4ab0e063e5caa3387c1a8741] = $v447b7147e84be512208dcc0995d67ebc->name;}}$v3a6d0284e743dc4a9b86f97d6dd1a3bf = implode(' ', $v3a6d0284e743dc4a9b86f97d6dd1a3bf);}if(is_null($v3a6d0284e743dc4a9b86f97d6dd1a3bf) || !$v3a6d0284e743dc4a9b86f97d6dd1a3bf) continue;if(is_object($v3a6d0284e743dc4a9b86f97d6dd1a3bf)) {continue;}$v5c18ef72771564b7f43c497dc507aeab[] = $v3a6d0284e743dc4a9b86f97d6dd1a3bf;}}if($vcc475582f6f7e3f30f5a46236d75b6c5) {$v5c18ef72771564b7f43c497dc507aeab = array_unique($v5c18ef72771564b7f43c497dc507aeab);}$v9b207167e5381c47682c6b4f58a623fb = "";foreach($v5c18ef72771564b7f43c497dc507aeab as $v3a6d0284e743dc4a9b86f97d6dd1a3bf) {if(is_array($v3a6d0284e743dc4a9b86f97d6dd1a3bf)) {continue;}$v9b207167e5381c47682c6b4f58a623fb .= $v3a6d0284e743dc4a9b86f97d6dd1a3bf . " ";}$v9b207167e5381c47682c6b4f58a623fb = preg_replace("/%[A-z0-9_]+ [A-z0-9_]+\([^\)]+\)%/im", "", $v9b207167e5381c47682c6b4f58a623fb);$v9b207167e5381c47682c6b4f58a623fb = str_replace("%", "&#037", $v9b207167e5381c47682c6b4f58a623fb);return $v9b207167e5381c47682c6b4f58a623fb;}public function getContext($v7057e8409c7c531a1a6e9ac3df4ed549, $va3dbaf37ab12f39c3cd19c0f04a360a0) {$v9a0364b9e99bb480dd25e1f0284c8555 = $this->prepareContext($v7057e8409c7c531a1a6e9ac3df4ed549, true);$v9a0364b9e99bb480dd25e1f0284c8555 = preg_replace("/%content redirect\((.*)\)%/im", "::CONTENT_REDIRECT::\\1::", $v9a0364b9e99bb480dd25e1f0284c8555);$v9a0364b9e99bb480dd25e1f0284c8555 = preg_replace("/(%|&#037)[A-z0-9]+ [A-z0-9]+\((.*)\)(%|&#037)/im", "", $v9a0364b9e99bb480dd25e1f0284c8555);$v6920626369b1f05844f5e3d6f93b5f6e = "<b>";$v4de1b7a4dc53e4a84c25ffb7cdb580ee = "</b>";$v8836d156dbd01a6c0776b086b0ff3b83 = explode(" ", $va3dbaf37ab12f39c3cd19c0f04a360a0);$v9a0364b9e99bb480dd25e1f0284c8555 = preg_replace("/([A-zА-я0-9])\.([A-zА-я0-9])/im", "\\1&#46;\\2", $v9a0364b9e99bb480dd25e1f0284c8555);$v5c18ef72771564b7f43c497dc507aeab = str_replace(">", "> ", $v9a0364b9e99bb480dd25e1f0284c8555);$v5c18ef72771564b7f43c497dc507aeab = str_replace("<br>", " ", $v5c18ef72771564b7f43c497dc507aeab);$v5c18ef72771564b7f43c497dc507aeab = str_replace("&nbsp;", " ", $v5c18ef72771564b7f43c497dc507aeab);$v5c18ef72771564b7f43c497dc507aeab = str_replace("\n", " ", $v5c18ef72771564b7f43c497dc507aeab);$v5c18ef72771564b7f43c497dc507aeab = strip_tags($v5c18ef72771564b7f43c497dc507aeab);if(preg_match_all("/::CONTENT_REDIRECT::(.*)::/i", $v5c18ef72771564b7f43c497dc507aeab, $v3d801aa532c1cec3ee82d87a99fdf63f)) {$v7dabf5c198b0bab2eaa42bb03a113e55 = sizeof($v3d801aa532c1cec3ee82d87a99fdf63f[1]);for($v865c0c0b4ab0e063e5caa3387c1a8741 = 0;$v865c0c0b4ab0e063e5caa3387c1a8741 < $v7dabf5c198b0bab2eaa42bb03a113e55;$v865c0c0b4ab0e063e5caa3387c1a8741++) {if(is_numeric($v3d801aa532c1cec3ee82d87a99fdf63f[1][$v865c0c0b4ab0e063e5caa3387c1a8741])) {$v4a0dc59dd475d7fbeadc872e24f24dd0 = cmsController::getInstance()->getModule('content')->get_page_url($v3d801aa532c1cec3ee82d87a99fdf63f[1][$v865c0c0b4ab0e063e5caa3387c1a8741]);$v4a0dc59dd475d7fbeadc872e24f24dd0 = umiHierarchy::getInstance()->getPathById($v3d801aa532c1cec3ee82d87a99fdf63f[1][$v865c0c0b4ab0e063e5caa3387c1a8741]);$v4a0dc59dd475d7fbeadc872e24f24dd0 = trim($v4a0dc59dd475d7fbeadc872e24f24dd0, "'");$v9b207167e5381c47682c6b4f58a623fb = str_replace($v3d801aa532c1cec3ee82d87a99fdf63f[0][$v865c0c0b4ab0e063e5caa3387c1a8741], "<p>%search_redirect_text% \"<a href='$v4a0dc59dd475d7fbeadc872e24f24dd0'>$v4a0dc59dd475d7fbeadc872e24f24dd0</a>\"</p>", $v5c18ef72771564b7f43c497dc507aeab);}else {$v4a0dc59dd475d7fbeadc872e24f24dd0 = strip_tags($v3d801aa532c1cec3ee82d87a99fdf63f[1][$v865c0c0b4ab0e063e5caa3387c1a8741]);$v4a0dc59dd475d7fbeadc872e24f24dd0 = trim($v4a0dc59dd475d7fbeadc872e24f24dd0, "'");$v5c18ef72771564b7f43c497dc507aeab = str_replace($v3d801aa532c1cec3ee82d87a99fdf63f[0][$v865c0c0b4ab0e063e5caa3387c1a8741], "<p>%search_redirect_text% <a href=\"" . $v4a0dc59dd475d7fbeadc872e24f24dd0 . "\">" . $v4a0dc59dd475d7fbeadc872e24f24dd0 . "</a></p>", $v5c18ef72771564b7f43c497dc507aeab);}}}$v5c18ef72771564b7f43c497dc507aeab .= "\n";$vcb114fb1f5594c74601a4d8a142d932d = "";$v980da98409d058c365664ff7ea33dd6b = Array();foreach($v8836d156dbd01a6c0776b086b0ff3b83 as $v350e6018b5636ab1e90720fed9694ccf) {if(wa_strlen($v350e6018b5636ab1e90720fed9694ccf) <= 1)    continue;$v1798c7d9bd5a5d637ead47154f0d36e3 = $v5c18ef72771564b7f43c497dc507aeab;$vf3b462d93b24cb0538f5d864546bc3e0 = language_morph::get_word_base($v350e6018b5636ab1e90720fed9694ccf);$vf3b462d93b24cb0538f5d864546bc3e0 = preg_quote($vf3b462d93b24cb0538f5d864546bc3e0, '/');$vd6f81d33de1672f67ef047aa89b6848b = "/([^\.^\?^!^<^>.]*)$vf3b462d93b24cb0538f5d864546bc3e0([^\.^\?^!^<^>.]*)[!\.\?\n]/imu";$v1dcb47f8fb7fc589f094bc7707d8ffa7 = "/([^ ^[\.[ ]*]^!^\?^\(^\).]*)($vf3b462d93b24cb0538f5d864546bc3e0)([^ ^\.^!^\?^\(^\).]*)/imu";if (preg_match($vd6f81d33de1672f67ef047aa89b6848b, $v1798c7d9bd5a5d637ead47154f0d36e3, $v1798c7d9bd5a5d637ead47154f0d36e3)) {$v980da98409d058c365664ff7ea33dd6b[] = $v1798c7d9bd5a5d637ead47154f0d36e3[0];}}$v980da98409d058c365664ff7ea33dd6b = array_unique($v980da98409d058c365664ff7ea33dd6b);$vcb114fb1f5594c74601a4d8a142d932d = "";foreach($v980da98409d058c365664ff7ea33dd6b as $v6438c669e0d0de98e6929c2cc0fac474) {foreach($v8836d156dbd01a6c0776b086b0ff3b83 as $v350e6018b5636ab1e90720fed9694ccf) {$vf3b462d93b24cb0538f5d864546bc3e0 = language_morph::get_word_base($v350e6018b5636ab1e90720fed9694ccf);$vf3b462d93b24cb0538f5d864546bc3e0 = preg_quote($vf3b462d93b24cb0538f5d864546bc3e0, '/');$v1dcb47f8fb7fc589f094bc7707d8ffa7 = "/([^ ^.^!^\?.]*)($vf3b462d93b24cb0538f5d864546bc3e0)([^ ^.^!^\?.]*)/imu";$v6438c669e0d0de98e6929c2cc0fac474 = preg_replace($v1dcb47f8fb7fc589f094bc7707d8ffa7, $v6920626369b1f05844f5e3d6f93b5f6e . "\\1\\2\\3" . $v4de1b7a4dc53e4a84c25ffb7cdb580ee, $v6438c669e0d0de98e6929c2cc0fac474);}if($v6438c669e0d0de98e6929c2cc0fac474) {$vcb114fb1f5594c74601a4d8a142d932d .= "<p>" . $v6438c669e0d0de98e6929c2cc0fac474 . "</p>";}}if(!$vcb114fb1f5594c74601a4d8a142d932d) {preg_match("/([^\.^!^\?.]*)([\.!\?]*)/im", $v5c18ef72771564b7f43c497dc507aeab, $vcb114fb1f5594c74601a4d8a142d932d);$vcb114fb1f5594c74601a4d8a142d932d = $vcb114fb1f5594c74601a4d8a142d932d[0];$vcb114fb1f5594c74601a4d8a142d932d = "<p></p>";}return $vcb114fb1f5594c74601a4d8a142d932d;}public function unindex_items($v7057e8409c7c531a1a6e9ac3df4ed549) {$v7057e8409c7c531a1a6e9ac3df4ed549 = (int) $v7057e8409c7c531a1a6e9ac3df4ed549;$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_search WHERE rel_id = '{$v7057e8409c7c531a1a6e9ac3df4ed549}'";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_search_index WHERE rel_id = '{$v7057e8409c7c531a1a6e9ac3df4ed549}'";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);return true;}public function index_items($v7057e8409c7c531a1a6e9ac3df4ed549) {$vb81ca7c0ccaa77e7aa91936ab0070695 = umiHierarchy::getInstance();$vadce578d04ed03c31f6ac59451fcf8e4 = $vb81ca7c0ccaa77e7aa91936ab0070695->getChilds($v7057e8409c7c531a1a6e9ac3df4ed549, true, true, 99);$v6a7f245843454cf4f28ad7c5e2572aa2 = array($v7057e8409c7c531a1a6e9ac3df4ed549);$this->expandArray($vadce578d04ed03c31f6ac59451fcf8e4, $v6a7f245843454cf4f28ad7c5e2572aa2);foreach($v6a7f245843454cf4f28ad7c5e2572aa2 as $v7057e8409c7c531a1a6e9ac3df4ed549) {$this->index_item($v7057e8409c7c531a1a6e9ac3df4ed549);}}public function calculateIDF($vd1f5ee0092ec47708f200415f2a89717) {static $vf68d7efaad2efd0f8c0c965a34fbe5e1 = false;$vd1f5ee0092ec47708f200415f2a89717 = (int) $vd1f5ee0092ec47708f200415f2a89717;if($vf68d7efaad2efd0f8c0c965a34fbe5e1 === false) {$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT COUNT(*) FROM cms3_search";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);list($v8277e0910d750195b448797616e091ad) = mysql_fetch_row($result);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT COUNT(*) FROM cms3_search_index WHERE word_id = {$vd1f5ee0092ec47708f200415f2a89717}";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);list($v1aabac6d068eef6a7bad3fdf50a05cc8) = mysql_fetch_row($result);$vf68d7efaad2efd0f8c0c965a34fbe5e1 = log($v8277e0910d750195b448797616e091ad / $v1aabac6d068eef6a7bad3fdf50a05cc8);}return $vf68d7efaad2efd0f8c0c965a34fbe5e1;}public function suggestions($vb45cffe084dd3d20d928bee85e7b0f21, $vaa9f73eea60a006820d0f8768bc8a3fc = 10) {$vb45cffe084dd3d20d928bee85e7b0f21 = trim($vb45cffe084dd3d20d928bee85e7b0f21);if(!$vb45cffe084dd3d20d928bee85e7b0f21) return false;$vb45cffe084dd3d20d928bee85e7b0f21 = wa_strtolower($vb45cffe084dd3d20d928bee85e7b0f21);$va04202c712aa415f47dbacb817a60397 = str_split('йцукенгшщзхъфывапролджэячсмитьбю');$v74e6a8b111ea7da1a7d0a596f4c35208 = str_split('qwertyuiop[]asdfghjkl;\'zxcvbnm,.');$v9c1b200500ea38c658ac7c81b10e85d2 = iconv("UTF-8", "CP1251", $vb45cffe084dd3d20d928bee85e7b0f21);$ve39cf8a95dc90270161317376387b25a = iconv("CP1251", "UTF-8", str_replace($va04202c712aa415f47dbacb817a60397, $v74e6a8b111ea7da1a7d0a596f4c35208, $v9c1b200500ea38c658ac7c81b10e85d2));$v67ae3d093b55e92227d0861222db0c6d = iconv("CP1251", "UTF-8", str_replace($v74e6a8b111ea7da1a7d0a596f4c35208, $va04202c712aa415f47dbacb817a60397, $v9c1b200500ea38c658ac7c81b10e85d2));$vd0c03a4c136b717b6ebc603966e26755 = ($ve39cf8a95dc90270161317376387b25a != $vb45cffe084dd3d20d928bee85e7b0f21) ? $ve39cf8a95dc90270161317376387b25a : $v67ae3d093b55e92227d0861222db0c6d;$vb45cffe084dd3d20d928bee85e7b0f21 = l_mysql_real_escape_string($vb45cffe084dd3d20d928bee85e7b0f21);$vd0c03a4c136b717b6ebc603966e26755 = l_mysql_real_escape_string($vd0c03a4c136b717b6ebc603966e26755);$vaa9f73eea60a006820d0f8768bc8a3fc = (int) $vaa9f73eea60a006820d0f8768bc8a3fc;$vac5c74b64b4b8352ef2f181affb5ac2a = <<<SQL
SELECT `siw`.`word` as `word`, COUNT(`si`.`word_id`) AS `cnt`
	FROM
		`cms3_search_index_words` `siw`,
		`cms3_search_index` `si`
	WHERE
		(
			`siw`.`word` LIKE '{$vb45cffe084dd3d20d928bee85e7b0f21}%' OR
			`siw`.`word` LIKE '{$vd0c03a4c136b717b6ebc603966e26755}%'
		) AND
		`si`.`word_id` = `siw`.`id`
	GROUP BY
		`siw`.`id`
	ORDER BY SUM(`si`.`tf`) DESC
	LIMIT {$vaa9f73eea60a006820d0f8768bc8a3fc}
SQL;   $v4717d53ebfdfea8477f780ec66151dcb = ConnectionPool::getInstance()->getConnection('search');return $v4717d53ebfdfea8477f780ec66151dcb->queryResult($vac5c74b64b4b8352ef2f181affb5ac2a);}private function expandArray($v47c80780ab608cc046f2a6e6f071feb6, &$result) {if(is_null($result)) $result = array();foreach($v47c80780ab608cc046f2a6e6f071feb6 as $vb80bb7740288fda1f201890375a60c8f => $vadce578d04ed03c31f6ac59451fcf8e4) {$result[] = $vb80bb7740288fda1f201890375a60c8f;$this->expandArray($vadce578d04ed03c31f6ac59451fcf8e4, $result);}}};?>