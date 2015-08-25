<?php
class umiCaptcha implements iUmiCaptcha {public static function generateCaptcha($v66f6181bcb4cff4cd38fbc804a036db6="default", $vb082bdddeadb1ea23f679c64ae900ef9="sys_captcha", $ve98737036f7752124468103e7fcdb14d="") {if (!self::isNeedCaptha()) {return def_module::isXSLTResultMode() ? array(    'comment:explain' => 'Captcha is not required for logged users'   ) : '';}if(!$v66f6181bcb4cff4cd38fbc804a036db6) $v66f6181bcb4cff4cd38fbc804a036db6 = "default";if(!$vb082bdddeadb1ea23f679c64ae900ef9) $vb082bdddeadb1ea23f679c64ae900ef9 = "sys_captcha";if(!$ve98737036f7752124468103e7fcdb14d) $ve98737036f7752124468103e7fcdb14d = "";$v9af24b163db8fe13fd0c36ae8c4080c1 = "?" . time();$vfca1bff8ad8b3a8585abfb0ad523ba42 = array();$vfca1bff8ad8b3a8585abfb0ad523ba42['void:input_id'] = $vb082bdddeadb1ea23f679c64ae900ef9;$vfca1bff8ad8b3a8585abfb0ad523ba42['attribute:captcha_hash'] = $ve98737036f7752124468103e7fcdb14d;$vfca1bff8ad8b3a8585abfb0ad523ba42['attribute:random_string'] = $v9af24b163db8fe13fd0c36ae8c4080c1;$vfca1bff8ad8b3a8585abfb0ad523ba42['url'] = array(   'attribute:random-string' => $v9af24b163db8fe13fd0c36ae8c4080c1,   'node:value'    => '/captcha.php'  );list($vb7c60eca084c05c6f9d7b6f220a32025) = def_module::loadTemplates("captcha/".$v66f6181bcb4cff4cd38fbc804a036db6, "captcha");return def_module::parseTemplate($vb7c60eca084c05c6f9d7b6f220a32025, $vfca1bff8ad8b3a8585abfb0ad523ba42);}public static function isNeedCaptha() {if (cmsController::getInstance()->getModule('users')->is_auth()) return false;if(getCookie('umi_captcha') == md5(getCookie('user_captcha'))) {$_SESSION['is_human'] = 1;}return (getSession('is_human') != 1);}public static function checkCaptcha() {$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();if(!$v2245023265ae4cf87d02c8b6ba991139->get('anti-spam', 'captcha.enabled')) {return true;}$v41275a535677f79ff347e01bc530c176 = permissionsCollection::getInstance();if ($v41275a535677f79ff347e01bc530c176->isAuth()) return true;if (isset($_COOKIE['umi_captcha']) && strlen($_COOKIE['umi_captcha'])) {if ($_COOKIE['umi_captcha'] == md5(getArrayKey($_COOKIE, 'user_captcha')) || $_COOKIE['umi_captcha'] == md5(getRequest('captcha')) ) {$v70b29c4920daf4e51e8175179027e668 = getRequest('captcha');if(md5($v70b29c4920daf4e51e8175179027e668) == $_COOKIE['umi_captcha']) {setcookie("user_captcha", $v70b29c4920daf4e51e8175179027e668, time() + 3600*24*31, "/");}$_SESSION['is_human'] = 1;return true;}else {unset($_SESSION['is_human']);return false;}}return false;}public static function getDrawer() {static $v062fa598b0c2852221e15e2085f0959a = null;if(!is_null($v062fa598b0c2852221e15e2085f0959a)) return $v062fa598b0c2852221e15e2085f0959a;$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();$v66941754547f94a40384649db36113e0 = $v2245023265ae4cf87d02c8b6ba991139->get('anti-spam', 'captcha.drawer');if(!$v66941754547f94a40384649db36113e0) {$v66941754547f94a40384649db36113e0 = 'default';}$vd6fe1d0be6347b8ef2427fa629c04485 = CURRENT_WORKING_DIR . '/classes/system/utils/captcha/drawers/' . $v66941754547f94a40384649db36113e0 . '.php';if(!is_file($vd6fe1d0be6347b8ef2427fa629c04485)) {throw new coreException("Captcha image drawer named \"{$v66941754547f94a40384649db36113e0}\" not found");}require $vd6fe1d0be6347b8ef2427fa629c04485;$v6f66e878c62db60568a3487869695820 = $v66941754547f94a40384649db36113e0 . 'CaptchaDrawer';if(class_exists($v6f66e878c62db60568a3487869695820)) {return $v062fa598b0c2852221e15e2085f0959a = new $v6f66e878c62db60568a3487869695820;}else {throw new coreException("Class \"{$v6f66e878c62db60568a3487869695820}\" not found in \"{$vd6fe1d0be6347b8ef2427fa629c04485}\"");}}}?>
