<?php
 abstract class antiSpamService {static public function get() {$v2245023265ae4cf87d02c8b6ba991139 = mainConfiguration::getInstance();if((int) $v2245023265ae4cf87d02c8b6ba991139->get('anti-spam', 'service.enabled')) {$v0f096338b64a1d1b348b86df38313c01 = $v2245023265ae4cf87d02c8b6ba991139->get('anti-spam', 'service.name');$vcd3fff114c1e7ae001e9f0e995a21bc7 = SYS_KERNEL_PATH . 'utils/antispam/services/' . $v0f096338b64a1d1b348b86df38313c01 . '.php';$v6f66e878c62db60568a3487869695820 = $v0f096338b64a1d1b348b86df38313c01 . 'AntiSpamService';if(!is_file($vcd3fff114c1e7ae001e9f0e995a21bc7)) {throw new coreException("Antispam service \"{$v0f096338b64a1d1b348b86df38313c01}\" file not found in \"{$vcd3fff114c1e7ae001e9f0e995a21bc7}\"");}require_once $vcd3fff114c1e7ae001e9f0e995a21bc7;if(class_exists($v6f66e878c62db60568a3487869695820) == false) {throw new coreException("Antispam service class \"{$v6f66e878c62db60568a3487869695820}\" not found");}$vaaabf0d39951f3e6c3e8a7911df524c2 = new $v6f66e878c62db60568a3487869695820;if($vaaabf0d39951f3e6c3e8a7911df524c2 instanceof antiSpamService == false) {throw new coreException("Class \"{$v6f66e878c62db60568a3487869695820}\" must be instance of antiSpamService class");}return $vaaabf0d39951f3e6c3e8a7911df524c2;}return false;}abstract public function isSpam();abstract public function setNick($vb068931cc450442b63f5b3d276ea4297);abstract public function setEmail($v0c83f57c786a0b4a39efab23731c7ebc);abstract public function setContent($v9a0364b9e99bb480dd25e1f0284c8555);abstract public function setLink($v2a304a1348456ccd2234cd71a81bd338);abstract public function setReferrer($vc66c00ae9f18fc0c67d8973bd07dc4cd);abstract public function reportSpam();abstract public function reportHam();};?>