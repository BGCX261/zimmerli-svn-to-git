<?php
 class umiDistrFolder extends umiDistrInstallItem {protected $filePath, $permissions;public function __construct($v47826cacc65c665212b821e6ff80b9b0 = false) {if($v47826cacc65c665212b821e6ff80b9b0 !== false) {$this->filePath = $v47826cacc65c665212b821e6ff80b9b0;$this->permissions = fileperms($v47826cacc65c665212b821e6ff80b9b0) & 0x1FF;}}public function pack() {return base64_encode(serialize($this));}public static function unpack($v8d777f385d3dfec8815d20f7496026dc) {return base64_decode(unserialize($v8d777f385d3dfec8815d20f7496026dc));}public function restore() {$va93b85dcfbb9969f5bb3c6be71737ed5 = getPathInfo($this->filePath);if(is_dir($va93b85dcfbb9969f5bb3c6be71737ed5['dirname'])) {$v9b207167e5381c47682c6b4f58a623fb = @mkdir($this->filePath);if($v9b207167e5381c47682c6b4f58a623fb) {@chmod($this->filePath, $this->permissions);}}return is_dir($this->filePath);}};?>