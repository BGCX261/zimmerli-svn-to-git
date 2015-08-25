<?php
 require './libs/config.php';$v572d4e421e5e6b9bc11d815e8a027112 = getRequest('url');$v67b3dba8bc6778101892eb77249db32e = getServer('HTTP_HOST') ? str_replace('www.', '', getServer('HTTP_HOST')) : false;$vc66c00ae9f18fc0c67d8973bd07dc4cd = getServer('HTTP_REFERER') ? parse_url(getServer('HTTP_REFERER')) : false;$v8068ea76a6331e2c8a27393e9b8e9422 = false;if ($vc66c00ae9f18fc0c67d8973bd07dc4cd && isset($vc66c00ae9f18fc0c67d8973bd07dc4cd['host'])) $v8068ea76a6331e2c8a27393e9b8e9422 = $vc66c00ae9f18fc0c67d8973bd07dc4cd['host'];if (!$v572d4e421e5e6b9bc11d815e8a027112 || !$v8068ea76a6331e2c8a27393e9b8e9422 || !$v67b3dba8bc6778101892eb77249db32e || strpos($v8068ea76a6331e2c8a27393e9b8e9422, $v67b3dba8bc6778101892eb77249db32e) === false){header ("HTTP/1.0 404 Not Found");exit();}else {header("Content-type: text/html; charset=utf8");$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();$v9af4d8381781baccb0f915e554f8798d = $v2245023265ae4cf87d02c8b6ba991139->get('system', 'gsb-apikey');if ($v9af4d8381781baccb0f915e554f8798d) {require './gsb/phpgsb.class.php';$vce8f9d0355f82957d1e56e105c370da8 = new phpGSB($v2245023265ae4cf87d02c8b6ba991139->get('connection', 'core.dbname'), $v2245023265ae4cf87d02c8b6ba991139->get('connection', 'core.login'), $v2245023265ae4cf87d02c8b6ba991139->get('connection', 'core.password'), $v2245023265ae4cf87d02c8b6ba991139->get('connection', 'core.host'));$vce8f9d0355f82957d1e56e105c370da8->apikey = $v9af4d8381781baccb0f915e554f8798d;$vce8f9d0355f82957d1e56e105c370da8->usinglists = array('googpub-phish-shavar','goog-malware-shavar');if ($vce8f9d0355f82957d1e56e105c370da8->doLookup($v572d4e421e5e6b9bc11d815e8a027112)) {$vfc35fdc70d5fc69d269883a822c7a53e = <<<HTML
<html style="margin:0; padding:0;">
	<head></head>
	<body style="margin:0; padding:0;">
		<div style="background: url('//yandex.st/serp/_/VipTApuC_1mDAMs6DzoMLtK89jg.png') repeat-x scroll 20px 0 transparent; height: 16px;"/>
		<div style="float:left; width: 240px; text-align:center; padding-top:32px">
			<a href="http://yandex.ru"><img src="http://avatars.yandex.net/get-avatar/127047242/0636c66ad5ff3c13438c04bb6a6ad7b1.4704-normal" alt="Безопасный Поиск Яндекса"></a>
		</div>
		<div style="float:left; padding-top:32px">
			<p>Сайт <strong>$v572d4e421e5e6b9bc11d815e8a027112</strong> может быть опасен для вашего компьютера</p>
			<h2>Что произошло</h2>
			<p>Яндекс обнаружил на этом сайте вредоносный программный код, который может заразить ваш компьютер вирусом или получить доступ к вашей личной информации.</p>
			<h2>Что делать дальше</h2>
			<a href="$v572d4e421e5e6b9bc11d815e8a027112">Всё равно перейти на опасный сайт</a>
			<p>Переход может нанести вред вашему компьютеру.</p>
		</div>
	</body>
</html>
HTML;    echo $vfc35fdc70d5fc69d269883a822c7a53e;exit();}}header('Location:' . $v572d4e421e5e6b9bc11d815e8a027112);exit();}?>
