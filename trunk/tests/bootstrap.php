<?php
 error_reporting(-1);ini_set('display_errors', 1);$_SERVER['SCRIPT_NAME']='/'.basename(__FILE__);$_SERVER['SCRIPT_FILENAME']=__FILE__;$_SERVER['HTTP_HOST'] = 'localhost';$_SERVER['SERVER_ADDR'] = '127.0.0.1';require_once(dirname(__FILE__).'/../standalone.php');class umiTestCase extends PHPUnit_Framework_TestCase {protected static $fixtures = array();protected static function clearFixtures() {foreach (self::$fixtures as $v4cf9d4f0069fc18fb3fcc0a50dceb852) {switch (true) {case $v4cf9d4f0069fc18fb3fcc0a50dceb852 instanceof umiHierarchyElement : {self::hierarchy()->delElement($v4cf9d4f0069fc18fb3fcc0a50dceb852->getId());}break;}}self::hierarchy()->removeDeletedAll();}protected static function hierarchy() {return umiHierarchy::getInstance();}protected static function objects() {return umiObjectsCollection::getInstance();}protected static function permissions() {return permissionsCollection::getInstance();}protected static function hierarchyTypes() {return umiHierarchyTypesCollection::getInstance();}protected static function objectTypes() {return umiObjectTypesCollection::getInstance();}protected static function queryResult($vac5c74b64b4b8352ef2f181affb5ac2a) {$result = array();$v26d59e24afcb9c11f03ffe8392b68734 = l_mysql_query($vac5c74b64b4b8352ef2f181affb5ac2a);while ($vf1965a857bc285d26fe22023aa5ab50d = mysql_fetch_assoc($v26d59e24afcb9c11f03ffe8392b68734)) {$result[] = $vf1965a857bc285d26fe22023aa5ab50d;}return $result;}protected static function controller() {return cmsController::getInstance();}protected static function createPageFixture($vb39a766c04008cbf4ec040e3fb92210b, $v22884db148f0ffb0d830ba431102b0b5, $vea9f6aca279138c58f705c8d4cb4b8ce, $vbfa030fe63bacd523dd70a76cfaed98a = 0, $v6301cee35ea764a1e241978f93f01069 = false, $vae75e01dbc2b0919bb97e1c6524a838e = false) {$v89b0b9deff65f8b9cd1f71bc74ce36ba = self::hierarchyTypes()->getTypeByName($v22884db148f0ffb0d830ba431102b0b5, $vea9f6aca279138c58f705c8d4cb4b8ce);$vae75e01dbc2b0919bb97e1c6524a838e = $vae75e01dbc2b0919bb97e1c6524a838e ? $vae75e01dbc2b0919bb97e1c6524a838e : 'Page for "' . $vb39a766c04008cbf4ec040e3fb92210b . '"';$va6eb4816205178e88dad66a16a19ff45 = self::hierarchy()->addElement($vbfa030fe63bacd523dd70a76cfaed98a, $v89b0b9deff65f8b9cd1f71bc74ce36ba->getId(), $vae75e01dbc2b0919bb97e1c6524a838e, uniqid($vae75e01dbc2b0919bb97e1c6524a838e), $v6301cee35ea764a1e241978f93f01069);self::permissions()->setDefaultPermissions($va6eb4816205178e88dad66a16a19ff45);$v71860c77c6745379b0d44304d66b6a13 = self::hierarchy()->getElement($va6eb4816205178e88dad66a16a19ff45);$v71860c77c6745379b0d44304d66b6a13->setIsActive(true);return self::$fixtures[] = $v71860c77c6745379b0d44304d66b6a13;}public static function tearDownAfterClass() {self::clearFixtures();}}OutputBuffer::current('CLIOutputBuffer');?>