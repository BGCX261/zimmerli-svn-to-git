<?php
$v8fa14cdd754f91cc6554c9e71929cce7 = trim((string)@$_GET['path'], '-');$v8fa14cdd754f91cc6554c9e71929cce7 = preg_replace("/[^a-z0-9]/i", '', $v8fa14cdd754f91cc6554c9e71929cce7);if(!empty($v8fa14cdd754f91cc6554c9e71929cce7)) {define("CRON","CLI");require CURRENT_WORKING_DIR."/standalone.php";$v4717d53ebfdfea8477f780ec66151dcb = ConnectionPool::getInstance()->getConnection('core');$v4717d53ebfdfea8477f780ec66151dcb->query("
		   CREATE TABLE IF NOT EXISTS  cms_stat_dispatches
		   (
				`hash` Varchar(10) NOT NULL, 
				`time` INT(11) NOT NULL
		   )
		   engine=innodb DEFAULT CHARSET=utf8;
		");$v4717d53ebfdfea8477f780ec66151dcb->query("INSERT INTO cms_stat_dispatches (hash, time) VALUES('".$v8fa14cdd754f91cc6554c9e71929cce7."', '".time()."')");}header('Content-Type: image/gif');$v73bebce395b6f1efedcf6842fbdb4d76  = imagecreatetruecolor (1, 1);imagealphablending($v73bebce395b6f1efedcf6842fbdb4d76, true);$v0f9e80982566a13dc0c281a4500c4a13 = imagecolorallocate ($v73bebce395b6f1efedcf6842fbdb4d76, 255, 255, 255);imagecolortransparent($v73bebce395b6f1efedcf6842fbdb4d76, $v0f9e80982566a13dc0c281a4500c4a13);imagegif($v73bebce395b6f1efedcf6842fbdb4d76);?>