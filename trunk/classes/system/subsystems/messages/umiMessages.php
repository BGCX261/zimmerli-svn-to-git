<?php
 class umiMessages extends singleton implements iSingleton, iUmiMessages {private static $messageTypes = Array('private', 'sys-event', 'sys-log');protected function __construct() {}public function getMessages($v3b8cb51bd8c4ef331893ce61e3f3bc39 = false, $vcddce64c174af26a6a96332151d4013c = false) {$v8e44f0089b076e18a718eb9ca3d94674 = (int) $this->getCurrentUserId();$v3b8cb51bd8c4ef331893ce61e3f3bc39 = (int) $v3b8cb51bd8c4ef331893ce61e3f3bc39;$vb71a97a0f96cb8b238309d23a188ae98[] = "m.`id` = mi.`message_id`";if ($v3b8cb51bd8c4ef331893ce61e3f3bc39) $vb71a97a0f96cb8b238309d23a188ae98[] = "m.`sender_id` = '{$v3b8cb51bd8c4ef331893ce61e3f3bc39}'";if ($vcddce64c174af26a6a96332151d4013c) $vb71a97a0f96cb8b238309d23a188ae98[] = "mi.`is_opened` = 0";$vb71a97a0f96cb8b238309d23a188ae98 = implode(' AND ', $vb71a97a0f96cb8b238309d23a188ae98);$vac5c74b64b4b8352ef2f181affb5ac2a = <<<SQL
SELECT m.`id`
	FROM `cms3_messages` m, `cms3_messages_inbox` mi
		WHERE mi.`recipient_id` = '{$v8e44f0089b076e18a718eb9ca3d94674}' AND {$vb71a97a0f96cb8b238309d23a188ae98}
			ORDER BY m.`create_time` DESC
SQL;
SELECT m.`id`
	FROM `cms3_messages` m, `cms3_messages_inbox` mi
		WHERE m.`sender_id` = '{$v8e44f0089b076e18a718eb9ca3d94674}' AND mi.`recipient_id` = '{$vf971c32bc4e78145496d6fc158959139}' AND m.`id` = mi.`message_id`
			ORDER BY m.`create_time` DESC
SQL;
SELECT m.`id`
	FROM `cms3_messages` m
		WHERE m.`sender_id` = '{$v8e44f0089b076e18a718eb9ca3d94674}'
			ORDER BY m.`create_time` DESC
SQL;
INSERT INTO `cms3_messages` (`sender_id`, `create_time`, `type`)
	VALUES ('{$v3b8cb51bd8c4ef331893ce61e3f3bc39}', '{$v07cc694b9b3fc636710fa08b6922c42b}', '{$v599dcce2998a6b40b1e38e8c6006cb0a}')
SQL;