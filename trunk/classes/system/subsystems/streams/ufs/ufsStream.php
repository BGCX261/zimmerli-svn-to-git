<?php
 class ufsStream extends umiBaseStream {protected $scheme = "ufs",    $depth = 0,    $modeAll = false,    $ignoreNames = Array( '.', '..', '.svn',       '.htaccess'       );public function stream_open($vd6fe1d0be6347b8ef2427fa629c04485, $v15d61712450a686a7f365adf4fef581f, $v93da65a9fd0004d9477aeac024e08e15, $v6385a5865e0b96f09e4142ab2d9e3736) {$vd6fe1d0be6347b8ef2427fa629c04485 = $this->parsePath($vd6fe1d0be6347b8ef2427fa629c04485);if($vd6fe1d0be6347b8ef2427fa629c04485 !== false) {if(file_exists($vd6fe1d0be6347b8ef2427fa629c04485)) {switch(filetype($vd6fe1d0be6347b8ef2427fa629c04485)) {case "dir": {$v8d777f385d3dfec8815d20f7496026dc = $this->readDirectory($vd6fe1d0be6347b8ef2427fa629c04485, $this->depth);break;}case "file": {$this->modeAll = true;$v8d777f385d3dfec8815d20f7496026dc = $this->readFile($vd6fe1d0be6347b8ef2427fa629c04485);break;}default: {return true;}}}else {$v8d777f385d3dfec8815d20f7496026dc = false;}if($v8d777f385d3dfec8815d20f7496026dc !== false) {$v8d777f385d3dfec8815d20f7496026dc = $this->translateToXml($v8d777f385d3dfec8815d20f7496026dc);$this->setData($v8d777f385d3dfec8815d20f7496026dc);return true;}}return $this->setDataError('not-found');}protected function parsePath($vd6fe1d0be6347b8ef2427fa629c04485) {$vd6fe1d0be6347b8ef2427fa629c04485 = parent::parsePath($vd6fe1d0be6347b8ef2427fa629c04485);if(array_key_exists("all", $this->params)) {$this->modeAll = true;}if(array_key_exists("depth", $this->params)) {$this->depth = $this->params['depth'];}$vd6fe1d0be6347b8ef2427fa629c04485 = str_replace("..", "", $vd6fe1d0be6347b8ef2427fa629c04485);if(substr($vd6fe1d0be6347b8ef2427fa629c04485, 0, strlen(CURRENT_WORKING_DIR)) == CURRENT_WORKING_DIR) {$vd6fe1d0be6347b8ef2427fa629c04485 = substr($vd6fe1d0be6347b8ef2427fa629c04485, strlen(CURRENT_WORKING_DIR) + 1);}return realpath("./" . trim($vd6fe1d0be6347b8ef2427fa629c04485));}protected function translateToXml() {$args = func_get_args();return parent::translateToXml($args[0]);}protected function readDirectory($vd6fe1d0be6347b8ef2427fa629c04485, $v12a055bf01a31369fe81ac35d85c7bc1 = 0) {$result = Array();$v45b963397aa40d4a0063e0d85e4fe7a1 = Array();$v33030abc929f083da5f6c3f755b46034 = Array();$v9aa06b6ccc231e66ab8f6289e7212c4c = opendir($vd6fe1d0be6347b8ef2427fa629c04485);$vfbd79507bfe8e92ae14ee624160ad6d2 = Array();while(($vbe8f80182e0c983916da7338c2c1c040 = readdir($v9aa06b6ccc231e66ab8f6289e7212c4c)) !== false) {$vfbd79507bfe8e92ae14ee624160ad6d2[] = $vbe8f80182e0c983916da7338c2c1c040;}natsort($vfbd79507bfe8e92ae14ee624160ad6d2);foreach($vfbd79507bfe8e92ae14ee624160ad6d2 as $vbe8f80182e0c983916da7338c2c1c040) {if(in_array($vbe8f80182e0c983916da7338c2c1c040, $this->ignoreNames)) continue;$v5383dda84022548870c15451eace1437 = $vd6fe1d0be6347b8ef2427fa629c04485 . "/" . $vbe8f80182e0c983916da7338c2c1c040;switch(filetype($v5383dda84022548870c15451eace1437)) {case "dir": {$v736007832d2167baaae763fd3a3f3cf1 = $this->translateDirectory($v5383dda84022548870c15451eace1437);if($v12a055bf01a31369fe81ac35d85c7bc1) {$v8a68dc3e925eacf92633be230722a140 = $this->readDirectory($v5383dda84022548870c15451eace1437, $v12a055bf01a31369fe81ac35d85c7bc1 - 1);$v736007832d2167baaae763fd3a3f3cf1 = array_merge($v736007832d2167baaae763fd3a3f3cf1, $v8a68dc3e925eacf92633be230722a140);}$v33030abc929f083da5f6c3f755b46034[] = $v736007832d2167baaae763fd3a3f3cf1;break;}case "file": {$v45b963397aa40d4a0063e0d85e4fe7a1[] = $this->translateFile($v5383dda84022548870c15451eace1437);break;}default: {continue;}}}$result['attribute:path'] = $vd6fe1d0be6347b8ef2427fa629c04485;$result['nodes:directory'] = $v33030abc929f083da5f6c3f755b46034;$result['nodes:file'] = $v45b963397aa40d4a0063e0d85e4fe7a1;return $result;}protected function readFile($vd6fe1d0be6347b8ef2427fa629c04485) {$result = Array();$result['file'] = $this->translateFile($vd6fe1d0be6347b8ef2427fa629c04485);return $result;}protected function translateDirectory($vd6fe1d0be6347b8ef2427fa629c04485) {$result = Array();$result['attribute:name'] = self::convertCharset(basename($vd6fe1d0be6347b8ef2427fa629c04485));return $result;}protected function translateFile($vd6fe1d0be6347b8ef2427fa629c04485) {$result = Array();$v7a6b154733290cd8da376eb56fe2d5fa = getPathInfo($vd6fe1d0be6347b8ef2427fa629c04485);$result['attribute:name'] = self::convertCharset($v7a6b154733290cd8da376eb56fe2d5fa['basename']);if (isset($v7a6b154733290cd8da376eb56fe2d5fa['extension'])) {$result['attribute:ext'] = $vabf77184f55403d75b9d51d79162a7ca = $v7a6b154733290cd8da376eb56fe2d5fa['extension'];}$result['attribute:size'] = filesize($vd6fe1d0be6347b8ef2427fa629c04485);if(function_exists("mime_content_type")) {$result['attribute:mimeType'] = mime_content_type($vd6fe1d0be6347b8ef2427fa629c04485);}$v3fe00293f378dc5b77dcc1a8116cb6f3 = stat($vd6fe1d0be6347b8ef2427fa629c04485);$result['attribute:create-time'] = $v3fe00293f378dc5b77dcc1a8116cb6f3['ctime'];$result['attribute:modify-time'] = $v3fe00293f378dc5b77dcc1a8116cb6f3['mtime'];if($this->modeAll) {switch($vabf77184f55403d75b9d51d79162a7ca) {case "xml":     case "xsl":     case "xsd":     case "html": {$result['xml:source'] = file_get_contents($vd6fe1d0be6347b8ef2427fa629c04485);break;}case "txt": {$result['source'] = file_get_contents($vd6fe1d0be6347b8ef2427fa629c04485);break;}case "gif":     case "jpg":     case "jpeg":     case "png": {list($veaae26a6fb20ed3ef54fb23bfa0b1fcc, $vb435e227d5dd201e1768b2bcb2e0aa81) = $vf7bd60b75b29d79b660a2859395c1a24 = getimagesize($vd6fe1d0be6347b8ef2427fa629c04485);$result['attribute:mimeType'] = $vf7bd60b75b29d79b660a2859395c1a24['mime'];$result['imageWidth'] = $veaae26a6fb20ed3ef54fb23bfa0b1fcc;$result['imageHeight'] = $vb435e227d5dd201e1768b2bcb2e0aa81;break;}}}return $result;}private static function convertCharset($v1cb251ec0d568de6a929b520c4aed8d1) {$v1803894f41a63302ad78951ffd9eb570 = rawurldecode($v1cb251ec0d568de6a929b520c4aed8d1);if ($v1803894f41a63302ad78951ffd9eb570) $v1cb251ec0d568de6a929b520c4aed8d1 = $v1803894f41a63302ad78951ffd9eb570;$v33628c49aa08100bec3d1d2f313ce35d = self::detectCharset($v1cb251ec0d568de6a929b520c4aed8d1);if (function_exists('iconv') && $v33628c49aa08100bec3d1d2f313ce35d !== 'UTF-8') {$v1803894f41a63302ad78951ffd9eb570 = @iconv($v33628c49aa08100bec3d1d2f313ce35d, 'UTF-8', $v1cb251ec0d568de6a929b520c4aed8d1);if ($v1803894f41a63302ad78951ffd9eb570) $v1cb251ec0d568de6a929b520c4aed8d1 = $v1803894f41a63302ad78951ffd9eb570;}return $v1cb251ec0d568de6a929b520c4aed8d1;}private static function winToLowercase($v19a97ad5524a2d14e58b104936effbde) {for($v865c0c0b4ab0e063e5caa3387c1a8741=0;$v865c0c0b4ab0e063e5caa3387c1a8741<strlen($v19a97ad5524a2d14e58b104936effbde);$v865c0c0b4ab0e063e5caa3387c1a8741++) {$v4a8a08f09d37b73795649038408b5f33 = ord($v19a97ad5524a2d14e58b104936effbde[$v865c0c0b4ab0e063e5caa3387c1a8741]);if ($v4a8a08f09d37b73795649038408b5f33 >= 0xC0 && $v4a8a08f09d37b73795649038408b5f33 <= 0xDF) {$v19a97ad5524a2d14e58b104936effbde[$v865c0c0b4ab0e063e5caa3387c1a8741] = chr($v4a8a08f09d37b73795649038408b5f33+32);}elseif ($v19a97ad5524a2d14e58b104936effbde[$v865c0c0b4ab0e063e5caa3387c1a8741] >= 0x41 && $v19a97ad5524a2d14e58b104936effbde[$v865c0c0b4ab0e063e5caa3387c1a8741] <= 0x5A) {$v19a97ad5524a2d14e58b104936effbde[$v865c0c0b4ab0e063e5caa3387c1a8741] = chr($v4a8a08f09d37b73795649038408b5f33+32);}}return $v19a97ad5524a2d14e58b104936effbde;}private static function detectCharset($v19a97ad5524a2d14e58b104936effbde) {if (preg_match("/[\x{0000}-\x{FFFF}]+/u", $v19a97ad5524a2d14e58b104936effbde)) return 'UTF-8';$va985177e18afdab154ab615657ef1514 = 'CP1251';if (!function_exists('iconv')) return $va985177e18afdab154ab615657ef1514;$vc8a02849a395786b0162365c9c8e285d = array(    'CP1251',    'KOI8-R',    'UTF-8',    'ISO-8859-5',    'CP866'   );if(function_exists("mb_detect_encoding")) {return mb_detect_encoding($v19a97ad5524a2d14e58b104936effbde, implode(", ",$vc8a02849a395786b0162365c9c8e285d));}else {return "UTF-8";}}};?>
