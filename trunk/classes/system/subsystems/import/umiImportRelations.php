<?php
 class umiImportRelations extends singleton implements iUmiImportRelations {protected function __construct() {}public static function getInstance($v4a8a08f09d37b73795649038408b5f33 = NULL) {return parent::getInstance(__CLASS__);}public function getSourceId($vaf721e88e6c0a612be51c329cb2bc12a) {$vaf721e88e6c0a612be51c329cb2bc12a = l_mysql_real_escape_string($vaf721e88e6c0a612be51c329cb2bc12a);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT id FROM cms3_import_sources WHERE source_name = '{$vaf721e88e6c0a612be51c329cb2bc12a}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a,true);if(list($v0afd9202ba86aa11ce63ad7007e7990b) = mysql_fetch_row($result)) {return $v0afd9202ba86aa11ce63ad7007e7990b;}else {return false;}}public function addNewSource($vaf721e88e6c0a612be51c329cb2bc12a) {if($v0afd9202ba86aa11ce63ad7007e7990b = $this->getSourceId($vaf721e88e6c0a612be51c329cb2bc12a)) {return $v0afd9202ba86aa11ce63ad7007e7990b;}else {$vaf721e88e6c0a612be51c329cb2bc12a = l_mysql_real_escape_string($vaf721e88e6c0a612be51c329cb2bc12a);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_import_sources (source_name) VALUES('{$vaf721e88e6c0a612be51c329cb2bc12a}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);return l_mysql_insert_id();}}public function setIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);if(!$ve1ecb99e7d44ff958e8773995f930c0c) {return false;}$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_import_relations WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND (new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' OR old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_import_relations (source_id, old_id, new_id) VALUES('{$v0afd9202ba86aa11ce63ad7007e7990b}', '{$v61ce6a78cb3c8547fed20990c92edfe3}', '{$ve1ecb99e7d44ff958e8773995f930c0c}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);return true;}public function getNewIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT new_id FROM cms3_import_relations WHERE old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($ve1ecb99e7d44ff958e8773995f930c0c) = mysql_fetch_row($result)) {return (string) $ve1ecb99e7d44ff958e8773995f930c0c;}else {return false;}}public function getOldIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$ve1ecb99e7d44ff958e8773995f930c0c =  l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT old_id FROM cms3_import_relations WHERE new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v61ce6a78cb3c8547fed20990c92edfe3) = mysql_fetch_row($result)) {return (string) $v61ce6a78cb3c8547fed20990c92edfe3;}else {return false;}}public function setObjectIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);if(!$ve1ecb99e7d44ff958e8773995f930c0c) {return false;}$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_import_objects WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND (new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' OR old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_import_objects (source_id, old_id, new_id) VALUES('{$v0afd9202ba86aa11ce63ad7007e7990b}', '{$v61ce6a78cb3c8547fed20990c92edfe3}', '{$ve1ecb99e7d44ff958e8773995f930c0c}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);return true;}public function getNewObjectIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT new_id FROM cms3_import_objects WHERE old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($ve1ecb99e7d44ff958e8773995f930c0c) = mysql_fetch_row($result)) {return (string) $ve1ecb99e7d44ff958e8773995f930c0c;}else {return false;}}public function getOldObjectIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT old_id FROM cms3_import_objects WHERE new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v61ce6a78cb3c8547fed20990c92edfe3) = mysql_fetch_row($result)) {return (string) $v61ce6a78cb3c8547fed20990c92edfe3;}else {return false;}}public function setTypeIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_import_types WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND (new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' OR old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_import_types (source_id, old_id, new_id) VALUES('{$v0afd9202ba86aa11ce63ad7007e7990b}', '{$v61ce6a78cb3c8547fed20990c92edfe3}', '{$ve1ecb99e7d44ff958e8773995f930c0c}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);return true;}public function getNewTypeIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT new_id FROM cms3_import_types WHERE old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($ve1ecb99e7d44ff958e8773995f930c0c) = mysql_fetch_row($result)) {return (string) $ve1ecb99e7d44ff958e8773995f930c0c;}else {return false;}}public function getOldTypeIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT old_id FROM cms3_import_types WHERE new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v61ce6a78cb3c8547fed20990c92edfe3) = mysql_fetch_row($result)) {return (string) $v61ce6a78cb3c8547fed20990c92edfe3;}else {return false;}}public function setFieldIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v94757cae63fd3e398c0811a976dd6bbe, $v6adb6b0ad1941d569b23e089910c5e74, $v32efe3ba69eb769cff89b115a9760c26) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v94757cae63fd3e398c0811a976dd6bbe = l_mysql_real_escape_string($v94757cae63fd3e398c0811a976dd6bbe);$v6adb6b0ad1941d569b23e089910c5e74 = l_mysql_real_escape_string($v6adb6b0ad1941d569b23e089910c5e74);$v32efe3ba69eb769cff89b115a9760c26 = l_mysql_real_escape_string($v32efe3ba69eb769cff89b115a9760c26);$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_import_fields WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND type_id = '{$v94757cae63fd3e398c0811a976dd6bbe}' AND (field_name = '{$v6adb6b0ad1941d569b23e089910c5e74}' OR new_id = '{$v32efe3ba69eb769cff89b115a9760c26}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_import_fields (source_id, type_id, field_name, new_id) VALUES('{$v0afd9202ba86aa11ce63ad7007e7990b}', '{$v94757cae63fd3e398c0811a976dd6bbe}', '{$v6adb6b0ad1941d569b23e089910c5e74}', '{$v32efe3ba69eb769cff89b115a9760c26}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);return (string) $v32efe3ba69eb769cff89b115a9760c26;}public function getNewFieldId($v0afd9202ba86aa11ce63ad7007e7990b, $v94757cae63fd3e398c0811a976dd6bbe, $v6adb6b0ad1941d569b23e089910c5e74) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v94757cae63fd3e398c0811a976dd6bbe = l_mysql_real_escape_string($v94757cae63fd3e398c0811a976dd6bbe);$v6adb6b0ad1941d569b23e089910c5e74 = l_mysql_real_escape_string($v6adb6b0ad1941d569b23e089910c5e74);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT new_id FROM cms3_import_fields WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND type_id = '{$v94757cae63fd3e398c0811a976dd6bbe}' AND field_name = '{$v6adb6b0ad1941d569b23e089910c5e74}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v32efe3ba69eb769cff89b115a9760c26) = mysql_fetch_row($result)) {return (string) $v32efe3ba69eb769cff89b115a9760c26;}else {return false;}}public function getOldFieldName($v0afd9202ba86aa11ce63ad7007e7990b, $v94757cae63fd3e398c0811a976dd6bbe, $v32efe3ba69eb769cff89b115a9760c26) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v94757cae63fd3e398c0811a976dd6bbe = l_mysql_real_escape_string($v94757cae63fd3e398c0811a976dd6bbe);$v32efe3ba69eb769cff89b115a9760c26 = l_mysql_real_escape_string($v32efe3ba69eb769cff89b115a9760c26);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT field_name FROM cms3_import_fields WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND type_id = '{$v94757cae63fd3e398c0811a976dd6bbe}' AND new_id = '{$v32efe3ba69eb769cff89b115a9760c26}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v6adb6b0ad1941d569b23e089910c5e74) = mysql_fetch_row($result)) {return (string) $v6adb6b0ad1941d569b23e089910c5e74;}else {return false;}}public function setGroupIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v94757cae63fd3e398c0811a976dd6bbe, $v8fe62617c470a7a0465d0ccd7c6970f6, $v5f2444d49c5d43b9cf7a3d7174b983f1) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v94757cae63fd3e398c0811a976dd6bbe = l_mysql_real_escape_string($v94757cae63fd3e398c0811a976dd6bbe);$v8fe62617c470a7a0465d0ccd7c6970f6 = l_mysql_real_escape_string($v8fe62617c470a7a0465d0ccd7c6970f6);$v5f2444d49c5d43b9cf7a3d7174b983f1 = l_mysql_real_escape_string($v5f2444d49c5d43b9cf7a3d7174b983f1);$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_import_groups WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND type_id = '{$v94757cae63fd3e398c0811a976dd6bbe}' AND (group_name = '{$v8fe62617c470a7a0465d0ccd7c6970f6}' OR new_id = '{$v5f2444d49c5d43b9cf7a3d7174b983f1}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_import_groups (source_id, type_id, group_name, new_id) VALUES('{$v0afd9202ba86aa11ce63ad7007e7990b}', '{$v94757cae63fd3e398c0811a976dd6bbe}', '{$v8fe62617c470a7a0465d0ccd7c6970f6}', '{$v5f2444d49c5d43b9cf7a3d7174b983f1}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);return (string) $v5f2444d49c5d43b9cf7a3d7174b983f1;}public function getNewGroupId($v0afd9202ba86aa11ce63ad7007e7990b, $v94757cae63fd3e398c0811a976dd6bbe, $v8fe62617c470a7a0465d0ccd7c6970f6) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v94757cae63fd3e398c0811a976dd6bbe = l_mysql_real_escape_string($v94757cae63fd3e398c0811a976dd6bbe);$v8fe62617c470a7a0465d0ccd7c6970f6 = l_mysql_real_escape_string($v8fe62617c470a7a0465d0ccd7c6970f6);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT new_id FROM cms3_import_groups WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND type_id = '{$v94757cae63fd3e398c0811a976dd6bbe}' AND group_name = '{$v8fe62617c470a7a0465d0ccd7c6970f6}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v5f2444d49c5d43b9cf7a3d7174b983f1) = mysql_fetch_row($result)) {return (string) $v5f2444d49c5d43b9cf7a3d7174b983f1;}else {return false;}}public function getOldGroupName($v0afd9202ba86aa11ce63ad7007e7990b, $v94757cae63fd3e398c0811a976dd6bbe, $v5f2444d49c5d43b9cf7a3d7174b983f1) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v94757cae63fd3e398c0811a976dd6bbe = l_mysql_real_escape_string($v94757cae63fd3e398c0811a976dd6bbe);$v5f2444d49c5d43b9cf7a3d7174b983f1 = l_mysql_real_escape_string($v5f2444d49c5d43b9cf7a3d7174b983f1);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT group_name FROM cms3_import_groups WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND type_id = '{$v94757cae63fd3e398c0811a976dd6bbe}' AND new_id = '{$v5f2444d49c5d43b9cf7a3d7174b983f1}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v8fe62617c470a7a0465d0ccd7c6970f6) = mysql_fetch_row($result)) {return l_mysql_real_escape_string($v8fe62617c470a7a0465d0ccd7c6970f6);}else {return false;}}public function setDomainIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_import_domains WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND (new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' OR old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_import_domains (source_id, old_id, new_id) VALUES('{$v0afd9202ba86aa11ce63ad7007e7990b}', '{$v61ce6a78cb3c8547fed20990c92edfe3}', '{$ve1ecb99e7d44ff958e8773995f930c0c}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);return true;}public function getNewDomainIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT new_id FROM cms3_import_domains WHERE old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($ve1ecb99e7d44ff958e8773995f930c0c) = mysql_fetch_row($result)) {return (string) $ve1ecb99e7d44ff958e8773995f930c0c;}else {return false;}}public function getOldDomainIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT old_id FROM cms3_import_domains WHERE new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v61ce6a78cb3c8547fed20990c92edfe3) = mysql_fetch_row($result)) {return (string) $v61ce6a78cb3c8547fed20990c92edfe3;}else {return false;}}public function setDomainMirrorIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_import_domain_mirrors WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND (new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' OR old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_import_domain_mirrors (source_id, old_id, new_id) VALUES('{$v0afd9202ba86aa11ce63ad7007e7990b}', '{$v61ce6a78cb3c8547fed20990c92edfe3}', '{$ve1ecb99e7d44ff958e8773995f930c0c}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);return true;}public function getNewDomainMirrorIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT new_id FROM cms3_import_domain_mirrors WHERE old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($ve1ecb99e7d44ff958e8773995f930c0c) = mysql_fetch_row($result)) {return (string) $ve1ecb99e7d44ff958e8773995f930c0c;}else {return false;}}public function getOldDomainMirrorIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT old_id FROM cms3_import_domain_mirrors WHERE new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v61ce6a78cb3c8547fed20990c92edfe3) = mysql_fetch_row($result)) {return (string) $v61ce6a78cb3c8547fed20990c92edfe3;}else {return false;}}public function setLangIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_import_langs WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND (new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' OR old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_import_langs (source_id, old_id, new_id) VALUES('{$v0afd9202ba86aa11ce63ad7007e7990b}', '{$v61ce6a78cb3c8547fed20990c92edfe3}', '{$ve1ecb99e7d44ff958e8773995f930c0c}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);return true;}public function getNewLangIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT new_id FROM cms3_import_langs WHERE old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($ve1ecb99e7d44ff958e8773995f930c0c) = mysql_fetch_row($result)) {return (string) $ve1ecb99e7d44ff958e8773995f930c0c;}else {return false;}}public function getOldLangIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT old_id FROM cms3_import_langs WHERE new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v61ce6a78cb3c8547fed20990c92edfe3) = mysql_fetch_row($result)) {return (string) $v61ce6a78cb3c8547fed20990c92edfe3;}else {return false;}}public function setTemplateIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_import_templates WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND (new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' OR old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_import_templates (source_id, old_id, new_id) VALUES('{$v0afd9202ba86aa11ce63ad7007e7990b}', '{$v61ce6a78cb3c8547fed20990c92edfe3}', '{$ve1ecb99e7d44ff958e8773995f930c0c}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);return true;}public function getNewTemplateIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT new_id FROM cms3_import_templates WHERE old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($ve1ecb99e7d44ff958e8773995f930c0c) = mysql_fetch_row($result)) {return (string) $ve1ecb99e7d44ff958e8773995f930c0c;}else {return false;}}public function getOldTemplateIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT old_id FROM cms3_import_templates WHERE new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v61ce6a78cb3c8547fed20990c92edfe3) = mysql_fetch_row($result)) {return (string) $v61ce6a78cb3c8547fed20990c92edfe3;}else {return false;}}public function setRestrictionIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "DELETE FROM cms3_import_restrictions WHERE source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}' AND (new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' OR old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);$vac5c74b64b4b8352ef2f181affb5ac2a = "INSERT INTO cms3_import_restrictions (source_id, old_id, new_id) VALUES('{$v0afd9202ba86aa11ce63ad7007e7990b}', '{$v61ce6a78cb3c8547fed20990c92edfe3}', '{$ve1ecb99e7d44ff958e8773995f930c0c}')";l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);return true;}public function getNewRestrictionIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $v61ce6a78cb3c8547fed20990c92edfe3) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$v61ce6a78cb3c8547fed20990c92edfe3 = l_mysql_real_escape_string($v61ce6a78cb3c8547fed20990c92edfe3);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT new_id FROM cms3_import_restrictions WHERE old_id = '{$v61ce6a78cb3c8547fed20990c92edfe3}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($ve1ecb99e7d44ff958e8773995f930c0c) = mysql_fetch_row($result)) {return (string) $ve1ecb99e7d44ff958e8773995f930c0c;}else {return false;}}public function getOldRestrictionIdRelation($v0afd9202ba86aa11ce63ad7007e7990b, $ve1ecb99e7d44ff958e8773995f930c0c) {$v0afd9202ba86aa11ce63ad7007e7990b = l_mysql_real_escape_string($v0afd9202ba86aa11ce63ad7007e7990b);$ve1ecb99e7d44ff958e8773995f930c0c = l_mysql_real_escape_string($ve1ecb99e7d44ff958e8773995f930c0c);$vac5c74b64b4b8352ef2f181affb5ac2a = "SELECT old_id FROM cms3_import_restrictions WHERE new_id = '{$ve1ecb99e7d44ff958e8773995f930c0c}' AND source_id = '{$v0afd9202ba86aa11ce63ad7007e7990b}'";$result = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a, true);if(list($v61ce6a78cb3c8547fed20990c92edfe3) = mysql_fetch_row($result)) {return (string) $v61ce6a78cb3c8547fed20990c92edfe3;}else {return false;}}};?>
