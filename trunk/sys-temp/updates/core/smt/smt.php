<?php
 error_reporting(E_ALL);ini_set('display_errors', 1);include('testhost.php');header("Cache-Control: no-store, no-cache, must-revalidate");header("Cache-Control: post-check=0, pre-check=0", false);header("Pragma: no-cache");header("Date: " . gmdate("D, d M Y H:i:s") . " GMT");header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");header("X-XSS-Protection: 0");header("Content-type: text/html; charset=utf-8");header("Content-type: text/xml; charset=utf-8");$v2764ca9d34e90313978d044f27ae433b = isset($_REQUEST['step']) ? $_REQUEST['step'] : 'test-mode';$va7df597feb89d482ec50398728fe2fdc = isset($_REQUEST['test-mode']) ? $_REQUEST['test-mode'] : 'install';$v571ab1ed8c284a6c0cd17b70c34d017a = isset($_REQUEST['db-host']) ? $_REQUEST['db-host'] : false;$v345e16ef0ed4dac2a4ec1acfdf82a56c = isset($_REQUEST['db-user']) ? $_REQUEST['db-user'] : false;$vb7e619c665a519627ecbc20c4cc2489a = isset($_REQUEST['db-password']) ? $_REQUEST['db-password'] : false;$ve44cd6dd02c2edf46ddd6cceb4cbcd2e = isset($_REQUEST['db-name']) ? $_REQUEST['db-name'] : false;$v532902f2815d229ecd121a3a28f37533 = isset($_REQUEST['user-email']) ? $_REQUEST['user-email'] : false;$va0f0f917e8e13d7da3c10328aa1df1a6 = isset($_REQUEST['user-key']) ? $_REQUEST['user-key'] : false;echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";if($v2764ca9d34e90313978d044f27ae433b == 'test-results'){if($v571ab1ed8c284a6c0cd17b70c34d017a == false || $v345e16ef0ed4dac2a4ec1acfdf82a56c == false || $vb7e619c665a519627ecbc20c4cc2489a == false || $ve44cd6dd02c2edf46ddd6cceb4cbcd2e == false){echo <<<XML
			<response type="test-mode">
			<error><![CDATA[13042]]></error>
			</response>
XML;
			<response type="test--change-key">
			<error><![CDATA[А здесь будет ссылка]]></error>
			</response>
XML;