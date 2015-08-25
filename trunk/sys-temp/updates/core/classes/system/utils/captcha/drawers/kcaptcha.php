<?php
class kcaptchaCaptchaDrawer extends captchaDrawer {protected $keystring, $foreground_color, $background_color;const alphabet = '0123456789abcdefghijklmnopqrstuvwxyz';const fontsdir = 'fonts/kcaptcha';const length = 6;const width = 121;const height = 60;const fluctuation_amplitude = 5;const no_spaces = true;const show_credits = false;const credits = 'www.captcha.ru';const jpeg_quality = 90;public function __construct() {$this->foreground_color = array(mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));$this->background_color = array(mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));}public function draw($vc13367945d5d4c91047b3b50234aa7ab) {$this->keystring = (string) $vc13367945d5d4c91047b3b50234aa7ab;$this->render();}function render(){$vcafc7170ed01c2f5c972cac7cde6e932 = self::alphabet;$v2fa47f7c65fec19cc163b195725e3844 = self::length;$veaae26a6fb20ed3ef54fb23bfa0b1fcc = self::width;$vb435e227d5dd201e1768b2bcb2e0aa81 = self::height;$v58d9b9b07d5c26b2449f60d637fa80ac = self::fluctuation_amplitude;$vfb17f42d29a5744aab71ac8ef80f627e = self::no_spaces;$vb8db67afb5dc6dbf22eba67d7b4d9ac9 = self::show_credits;$v22931135e7ff7a1d98a352025425aba7 = $this->foreground_color;$v1e9c06380fa61f82b6324ef8d21f90ab = $this->background_color;$v980d14c0c85495b48b9a9134658e6121 = array();$v0bc86c45e8a6f9eb71ec3719aec3bccf = dirname(__FILE__) . '/' . self::fontsdir;if ($ve1260894f59eeae98c8440899de4df8d = opendir($v0bc86c45e8a6f9eb71ec3719aec3bccf)) {while (false !== ($v8c7dd922ad47494fc02c388e12c00eac = readdir($ve1260894f59eeae98c8440899de4df8d))) {if (preg_match('/\.png$/i', $v8c7dd922ad47494fc02c388e12c00eac)) {$v980d14c0c85495b48b9a9134658e6121[] = $v0bc86c45e8a6f9eb71ec3719aec3bccf.'/' . $v8c7dd922ad47494fc02c388e12c00eac;}}closedir($ve1260894f59eeae98c8440899de4df8d);}$vc6531b483d566e63d24ee3e0962c3ad7 = strlen($vcafc7170ed01c2f5c972cac7cde6e932);do {$v412bec0b48fd1b10161195b841e0fa12 = $v980d14c0c85495b48b9a9134658e6121[mt_rand(0, count($v980d14c0c85495b48b9a9134658e6121)-1)];$v47a282dfe68a42d302e22c4920ed9b5e = imagecreatefrompng($v412bec0b48fd1b10161195b841e0fa12);imagealphablending($v47a282dfe68a42d302e22c4920ed9b5e, true);$v927fae1423070a16776f104824341e3a = imagesx($v47a282dfe68a42d302e22c4920ed9b5e);$v8ffe759611e3b61b317b696f7789fb8c = imagesy($v47a282dfe68a42d302e22c4920ed9b5e) - 1;$v998e8b6af7d8c7e0dc9d1b31d0146a59 = array();$v97bff26855a8bfa63e05d5477e794b24 = 0;$v44931a2638fdd7431a832fb7c3260582 = false;for($v865c0c0b4ab0e063e5caa3387c1a8741 = 0;$v865c0c0b4ab0e063e5caa3387c1a8741 < $v927fae1423070a16776f104824341e3a && $v97bff26855a8bfa63e05d5477e794b24 < $vc6531b483d566e63d24ee3e0962c3ad7;$v865c0c0b4ab0e063e5caa3387c1a8741++){$v5e96bf62b9b2c18fdb65564b4a18fd1f = (imagecolorat($v47a282dfe68a42d302e22c4920ed9b5e, $v865c0c0b4ab0e063e5caa3387c1a8741, 0) >> 24) == 127;if(!$v44931a2638fdd7431a832fb7c3260582 && !$v5e96bf62b9b2c18fdb65564b4a18fd1f){$v998e8b6af7d8c7e0dc9d1b31d0146a59[$vcafc7170ed01c2f5c972cac7cde6e932{$v97bff26855a8bfa63e05d5477e794b24}] = array('start' => $v865c0c0b4ab0e063e5caa3387c1a8741);$v44931a2638fdd7431a832fb7c3260582 = true;continue;}if($v44931a2638fdd7431a832fb7c3260582 && $v5e96bf62b9b2c18fdb65564b4a18fd1f){$v998e8b6af7d8c7e0dc9d1b31d0146a59[$vcafc7170ed01c2f5c972cac7cde6e932{$v97bff26855a8bfa63e05d5477e794b24}]['end'] = $v865c0c0b4ab0e063e5caa3387c1a8741;$v44931a2638fdd7431a832fb7c3260582 = false;$v97bff26855a8bfa63e05d5477e794b24++;continue;}}$vb798abe6e1b1318ee36b0dcb3fb9e4d3=imagecreatetruecolor($veaae26a6fb20ed3ef54fb23bfa0b1fcc, $vb435e227d5dd201e1768b2bcb2e0aa81);imagealphablending($vb798abe6e1b1318ee36b0dcb3fb9e4d3, true);$vd508fe45cecaf653904a0e774084bb5c=imagecolorallocate($vb798abe6e1b1318ee36b0dcb3fb9e4d3, 255, 255, 255);$v1ffd9e753c8054cc61456ac7fac1ac89=imagecolorallocate($vb798abe6e1b1318ee36b0dcb3fb9e4d3, 0, 0, 0);imagefilledrectangle($vb798abe6e1b1318ee36b0dcb3fb9e4d3, 0, 0, $veaae26a6fb20ed3ef54fb23bfa0b1fcc-1, $vb435e227d5dd201e1768b2bcb2e0aa81-1, $vd508fe45cecaf653904a0e774084bb5c);$v9dd4e461268c8034f5c8564e155c67a6=1;for($v865c0c0b4ab0e063e5caa3387c1a8741=0;$v865c0c0b4ab0e063e5caa3387c1a8741<$v2fa47f7c65fec19cc163b195725e3844;$v865c0c0b4ab0e063e5caa3387c1a8741++){$v6f8f57715090da2632453988d9a1501b=$v998e8b6af7d8c7e0dc9d1b31d0146a59[$this->keystring{$v865c0c0b4ab0e063e5caa3387c1a8741}];$v415290769594460e2e485922904f345d=mt_rand(-$v58d9b9b07d5c26b2449f60d637fa80ac, $v58d9b9b07d5c26b2449f60d637fa80ac)+($vb435e227d5dd201e1768b2bcb2e0aa81-$v8ffe759611e3b61b317b696f7789fb8c)/2+2;if($vfb17f42d29a5744aab71ac8ef80f627e){$v2ab64f4ee279e5baf7ab7059b15e6d12=0;if($v865c0c0b4ab0e063e5caa3387c1a8741>0){$v2ab64f4ee279e5baf7ab7059b15e6d12=10000;for($v1548af1c94ad45584324df8f08baf227=7;$v1548af1c94ad45584324df8f08baf227<$v8ffe759611e3b61b317b696f7789fb8c-20;$v1548af1c94ad45584324df8f08baf227+=1){for($v2c38b9e45cec1b324dde4e3d5b22c648=$v6f8f57715090da2632453988d9a1501b['start']-1;$v2c38b9e45cec1b324dde4e3d5b22c648<$v6f8f57715090da2632453988d9a1501b['end'];$v2c38b9e45cec1b324dde4e3d5b22c648+=1){$vef70a6546536ccd835479f6cddc0188e=imagecolorat($v47a282dfe68a42d302e22c4920ed9b5e, $v2c38b9e45cec1b324dde4e3d5b22c648, $v1548af1c94ad45584324df8f08baf227);$va44359421a97c76c01b5dd673f421fdd=$vef70a6546536ccd835479f6cddc0188e>>24;if($va44359421a97c76c01b5dd673f421fdd<127){$v811882fecd5c7618d7099ebbd39ea254=$v2c38b9e45cec1b324dde4e3d5b22c648-$v6f8f57715090da2632453988d9a1501b['start']+$v9dd4e461268c8034f5c8564e155c67a6;$vdfed5bc177b87ab317c584e06566adc6=$v1548af1c94ad45584324df8f08baf227+$v415290769594460e2e485922904f345d;if($vdfed5bc177b87ab317c584e06566adc6>$vb435e227d5dd201e1768b2bcb2e0aa81) break;for($v21de26caa6bcfc936378c4e45d235bd9=min($v811882fecd5c7618d7099ebbd39ea254,$veaae26a6fb20ed3ef54fb23bfa0b1fcc-1);$v21de26caa6bcfc936378c4e45d235bd9>$v811882fecd5c7618d7099ebbd39ea254-12 && $v21de26caa6bcfc936378c4e45d235bd9>=0;$v21de26caa6bcfc936378c4e45d235bd9-=1){$v70dda5dfb8053dc6d1c492574bce9bfd=imagecolorat($vb798abe6e1b1318ee36b0dcb3fb9e4d3, $v21de26caa6bcfc936378c4e45d235bd9, $vdfed5bc177b87ab317c584e06566adc6) & 0xff;if($v70dda5dfb8053dc6d1c492574bce9bfd+$va44359421a97c76c01b5dd673f421fdd<190){if($v2ab64f4ee279e5baf7ab7059b15e6d12>$v811882fecd5c7618d7099ebbd39ea254-$v21de26caa6bcfc936378c4e45d235bd9){$v2ab64f4ee279e5baf7ab7059b15e6d12=$v811882fecd5c7618d7099ebbd39ea254-$v21de26caa6bcfc936378c4e45d235bd9;}break;}}break;}}}if($v2ab64f4ee279e5baf7ab7059b15e6d12==10000){$v2ab64f4ee279e5baf7ab7059b15e6d12=mt_rand(4,6);}}}else{$v2ab64f4ee279e5baf7ab7059b15e6d12=1;}imagecopy($vb798abe6e1b1318ee36b0dcb3fb9e4d3, $v47a282dfe68a42d302e22c4920ed9b5e, $v9dd4e461268c8034f5c8564e155c67a6-$v2ab64f4ee279e5baf7ab7059b15e6d12, $v415290769594460e2e485922904f345d, $v6f8f57715090da2632453988d9a1501b['start'], 1, $v6f8f57715090da2632453988d9a1501b['end']-$v6f8f57715090da2632453988d9a1501b['start'], $v8ffe759611e3b61b317b696f7789fb8c);$v9dd4e461268c8034f5c8564e155c67a6+=$v6f8f57715090da2632453988d9a1501b['end']-$v6f8f57715090da2632453988d9a1501b['start']-$v2ab64f4ee279e5baf7ab7059b15e6d12;}}while($v9dd4e461268c8034f5c8564e155c67a6>=$veaae26a6fb20ed3ef54fb23bfa0b1fcc-10);$vadb115059e28d960fa8badfac5516667=$v9dd4e461268c8034f5c8564e155c67a6/2;$vfe5067706fde605fcc635835a1e52fc8=imagecreatetruecolor($veaae26a6fb20ed3ef54fb23bfa0b1fcc, $vb435e227d5dd201e1768b2bcb2e0aa81+($vb8db67afb5dc6dbf22eba67d7b4d9ac9?12:0));$v0fa009a743944a032eb54727acec48d6=imagecolorallocate($vfe5067706fde605fcc635835a1e52fc8, $v22931135e7ff7a1d98a352025425aba7[0], $v22931135e7ff7a1d98a352025425aba7[1], $v22931135e7ff7a1d98a352025425aba7[2]);$vd229bbf31eaeebc7c88897732d8b932d=imagecolorallocate($vfe5067706fde605fcc635835a1e52fc8, $v1e9c06380fa61f82b6324ef8d21f90ab[0], $v1e9c06380fa61f82b6324ef8d21f90ab[1], $v1e9c06380fa61f82b6324ef8d21f90ab[2]);imagefilledrectangle($vfe5067706fde605fcc635835a1e52fc8, 0, 0, $veaae26a6fb20ed3ef54fb23bfa0b1fcc-1, $vb435e227d5dd201e1768b2bcb2e0aa81-1, $vd229bbf31eaeebc7c88897732d8b932d);imagefilledrectangle($vfe5067706fde605fcc635835a1e52fc8, 0, $vb435e227d5dd201e1768b2bcb2e0aa81, $veaae26a6fb20ed3ef54fb23bfa0b1fcc-1, $vb435e227d5dd201e1768b2bcb2e0aa81+12, $v0fa009a743944a032eb54727acec48d6);$v928735d6f2c63bee316dd511c8ccaf55=empty($v928735d6f2c63bee316dd511c8ccaf55)?$_SERVER['HTTP_HOST']:$v928735d6f2c63bee316dd511c8ccaf55;imagestring($vfe5067706fde605fcc635835a1e52fc8, 2, $veaae26a6fb20ed3ef54fb23bfa0b1fcc/2-imagefontwidth(2)*strlen($v928735d6f2c63bee316dd511c8ccaf55)/2, $vb435e227d5dd201e1768b2bcb2e0aa81-2, $v928735d6f2c63bee316dd511c8ccaf55, $vd229bbf31eaeebc7c88897732d8b932d);$v00a50cd81c37c4e381e8161b2d762158=mt_rand(750000,1200000)/10000000;$v3f6e5c4ec9645a2f8ec824625b85c8d3=mt_rand(750000,1200000)/10000000;$v2f4366e156fbc3aac4ce776a8b62f838=mt_rand(750000,1200000)/10000000;$v3960efd6fe22e7e9faea5dec18fde728=mt_rand(750000,1200000)/10000000;$v3f3e2dd4cf66f8268844c20328d6dd82=mt_rand(0,31415926)/10000000;$v6568c56400fabb57b9df1cfcb5aae001=mt_rand(0,31415926)/10000000;$vb2aae71d75c798ea14025776add01ced=mt_rand(0,31415926)/10000000;$vdac6f7da3a1685f5b067befeceb22d95=mt_rand(0,31415926)/10000000;$v9d9cbafdf60ec849d3a7f5eac3a196c9=mt_rand(330,420)/110;$v2d4051a76619ddbe7d8f01aa5f64b4ca=mt_rand(330,450)/110;for($v9dd4e461268c8034f5c8564e155c67a6=0;$v9dd4e461268c8034f5c8564e155c67a6<$veaae26a6fb20ed3ef54fb23bfa0b1fcc;$v9dd4e461268c8034f5c8564e155c67a6++){for($v415290769594460e2e485922904f345d=0;$v415290769594460e2e485922904f345d<$vb435e227d5dd201e1768b2bcb2e0aa81;$v415290769594460e2e485922904f345d++){$v2c38b9e45cec1b324dde4e3d5b22c648=$v9dd4e461268c8034f5c8564e155c67a6+(sin($v9dd4e461268c8034f5c8564e155c67a6*$v00a50cd81c37c4e381e8161b2d762158+$v3f3e2dd4cf66f8268844c20328d6dd82)+sin($v415290769594460e2e485922904f345d*$v2f4366e156fbc3aac4ce776a8b62f838+$v6568c56400fabb57b9df1cfcb5aae001))*$v9d9cbafdf60ec849d3a7f5eac3a196c9-$veaae26a6fb20ed3ef54fb23bfa0b1fcc/2+$vadb115059e28d960fa8badfac5516667+1;$v1548af1c94ad45584324df8f08baf227=$v415290769594460e2e485922904f345d+(sin($v9dd4e461268c8034f5c8564e155c67a6*$v3f6e5c4ec9645a2f8ec824625b85c8d3+$vb2aae71d75c798ea14025776add01ced)+sin($v415290769594460e2e485922904f345d*$v3960efd6fe22e7e9faea5dec18fde728+$vdac6f7da3a1685f5b067befeceb22d95))*$v2d4051a76619ddbe7d8f01aa5f64b4ca;if($v2c38b9e45cec1b324dde4e3d5b22c648<0 || $v1548af1c94ad45584324df8f08baf227<0 || $v2c38b9e45cec1b324dde4e3d5b22c648>=$veaae26a6fb20ed3ef54fb23bfa0b1fcc-1 || $v1548af1c94ad45584324df8f08baf227>=$vb435e227d5dd201e1768b2bcb2e0aa81-1){continue;}else{$v70dda5dfb8053dc6d1c492574bce9bfd=imagecolorat($vb798abe6e1b1318ee36b0dcb3fb9e4d3, $v2c38b9e45cec1b324dde4e3d5b22c648, $v1548af1c94ad45584324df8f08baf227) & 0xFF;$va6390bfc4c6f43dc510ba08681a9405c=imagecolorat($vb798abe6e1b1318ee36b0dcb3fb9e4d3, $v2c38b9e45cec1b324dde4e3d5b22c648+1, $v1548af1c94ad45584324df8f08baf227) & 0xFF;$v60325b22a3d1988ec5b60be3dfdb337d=imagecolorat($vb798abe6e1b1318ee36b0dcb3fb9e4d3, $v2c38b9e45cec1b324dde4e3d5b22c648, $v1548af1c94ad45584324df8f08baf227+1) & 0xFF;$vce730516cc7c5b67eb38b7eb6dfd62cf=imagecolorat($vb798abe6e1b1318ee36b0dcb3fb9e4d3, $v2c38b9e45cec1b324dde4e3d5b22c648+1, $v1548af1c94ad45584324df8f08baf227+1) & 0xFF;}if($v70dda5dfb8053dc6d1c492574bce9bfd==255 && $va6390bfc4c6f43dc510ba08681a9405c==255 && $v60325b22a3d1988ec5b60be3dfdb337d==255 && $vce730516cc7c5b67eb38b7eb6dfd62cf==255){continue;}else if($v70dda5dfb8053dc6d1c492574bce9bfd==0 && $va6390bfc4c6f43dc510ba08681a9405c==0 && $v60325b22a3d1988ec5b60be3dfdb337d==0 && $vce730516cc7c5b67eb38b7eb6dfd62cf==0){$vfe819fd19ed4444b756e5cc069e5cb50=$v22931135e7ff7a1d98a352025425aba7[0];$v81cbbaf3dc7ff7e21920b5507bba3d95=$v22931135e7ff7a1d98a352025425aba7[1];$vc4b69c0726f5e964f9bd5adf3eae3f0e=$v22931135e7ff7a1d98a352025425aba7[2];}else{$v971ad1a3b1827fef078c27a6e669fec4=$v2c38b9e45cec1b324dde4e3d5b22c648-floor($v2c38b9e45cec1b324dde4e3d5b22c648);$v88036e069c5b9a152b321f5c949f0eb5=$v1548af1c94ad45584324df8f08baf227-floor($v1548af1c94ad45584324df8f08baf227);$vc1bec3513d0db30bf8cae482ec791a9b=1-$v971ad1a3b1827fef078c27a6e669fec4;$v7c7f300caf151bb2c5ff82796fd3d2d1=1-$v88036e069c5b9a152b321f5c949f0eb5;$v9fdd735822b5974182b039b25fdc1754=(      $v70dda5dfb8053dc6d1c492574bce9bfd*$vc1bec3513d0db30bf8cae482ec791a9b*$v7c7f300caf151bb2c5ff82796fd3d2d1+      $va6390bfc4c6f43dc510ba08681a9405c*$v971ad1a3b1827fef078c27a6e669fec4*$v7c7f300caf151bb2c5ff82796fd3d2d1+      $v60325b22a3d1988ec5b60be3dfdb337d*$vc1bec3513d0db30bf8cae482ec791a9b*$v88036e069c5b9a152b321f5c949f0eb5+      $vce730516cc7c5b67eb38b7eb6dfd62cf*$v971ad1a3b1827fef078c27a6e669fec4*$v88036e069c5b9a152b321f5c949f0eb5);if($v9fdd735822b5974182b039b25fdc1754>255) $v9fdd735822b5974182b039b25fdc1754=255;$v9fdd735822b5974182b039b25fdc1754=$v9fdd735822b5974182b039b25fdc1754/255;$vbe93a161a5a077c3e2e1dd74ff41a584=1-$v9fdd735822b5974182b039b25fdc1754;$vfe819fd19ed4444b756e5cc069e5cb50=$vbe93a161a5a077c3e2e1dd74ff41a584*$v22931135e7ff7a1d98a352025425aba7[0]+$v9fdd735822b5974182b039b25fdc1754*$v1e9c06380fa61f82b6324ef8d21f90ab[0];$v81cbbaf3dc7ff7e21920b5507bba3d95=$vbe93a161a5a077c3e2e1dd74ff41a584*$v22931135e7ff7a1d98a352025425aba7[1]+$v9fdd735822b5974182b039b25fdc1754*$v1e9c06380fa61f82b6324ef8d21f90ab[1];$vc4b69c0726f5e964f9bd5adf3eae3f0e=$vbe93a161a5a077c3e2e1dd74ff41a584*$v22931135e7ff7a1d98a352025425aba7[2]+$v9fdd735822b5974182b039b25fdc1754*$v1e9c06380fa61f82b6324ef8d21f90ab[2];}imagesetpixel($vfe5067706fde605fcc635835a1e52fc8, $v9dd4e461268c8034f5c8564e155c67a6, $v415290769594460e2e485922904f345d, imagecolorallocate($vfe5067706fde605fcc635835a1e52fc8, $vfe819fd19ed4444b756e5cc069e5cb50, $v81cbbaf3dc7ff7e21920b5507bba3d95, $vc4b69c0726f5e964f9bd5adf3eae3f0e));}}if(function_exists("imagejpeg")){header("Content-Type: image/jpeg");imagejpeg($vfe5067706fde605fcc635835a1e52fc8, null, self::jpeg_quality);}else if(function_exists("imagegif")){header("Content-Type: image/gif");imagegif($vfe5067706fde605fcc635835a1e52fc8);}else if(function_exists("imagepng")){header("Content-Type: image/x-png");imagepng($vfe5067706fde605fcc635835a1e52fc8);}}};?>